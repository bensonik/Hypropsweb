<?php

namespace App\Http\Controllers;

use App\model\AccountChart;
use App\Http\Controllers\Controller;
use App\model\ExchangeRate;
use App\model\FinancialYear;
use App\model\JournalExtension;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\model\AccountCategory;
use App\model\AccountJournal;
use App\model\Currency;
use App\model\AccountDetailType;
use App\Helpers\Utility;
use App\User;
use App\model\Roles;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AccountChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = AccountChart::paginateAllData();
        $currency = Currency::getAllData();
        $accountCat = AccountCategory::getAllData();
        $this->totalChartAmount($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('account_chart.reload',array('mainData' => $mainData,
                'currency' => $currency,'accountCat' => $accountCat))->render());

        }
            return view::make('account_chart.main_view')->with('mainData',$mainData)->with('currency',$currency)
                ->with('accountCat',$accountCat);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),AccountChart::$mainRules);
        if($validator->passes()){
            $accountCat = $request->input('account_category');

            $countData = AccountChart::countData('acct_name',$request->input('account_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                Utility::checkCurrencyActiveStatus();   //CHECK IF THERE IS AN ACTIVE CURRENCY
                Utility::checkFinYearActiveStatus();    //CHECK IF THERE IS AN ACTIVE FINANCIAL YEAR

                $password = $request->input('password');
                if(Utility::checkClosingBook($request->input('cost_date'),$password) == Utility::ZERO || Utility::checkClosingBook($request->input('depreciation_date'),$password) == Utility::ZERO){
                    return response()->json([
                        'message2' => 'Transaction of this date and below have been closed, or enter a correct password to get access',
                        'message' => 'warning'
                    ]);
                }

                $dbDATA = [
                    'acct_cat_id' => $request->input('account_category'),
                    'detail_id' => $request->input('detail_type'),
                    'acct_no' => $request->input('account_number'),
                    'acct_name' => ucfirst($request->input('account_name')),
                    'curr_id' => $request->input('currency'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                $createChart = AccountChart::create($dbDATA);



                if(in_array($accountCat,Utility::NO_DEPRECIATION_ACCOUNT_CAT_DB_ID) || $accountCat == Utility::FIXED_ASSET_DB_ID){



                    if(empty($request->input('original_cost'))){        //IF ORIGINAL COST IS EMPTY, SAVE DATA AND EXIT PROCESSING OF LEDGER ENTRY BELOW
                        return response()->json([
                            'message' => 'good',
                            'message2' => 'saved'
                        ]);
                    }

                    $finYear = FinancialYear::firstRow('active_status',Utility::STATUS_ACTIVE);
                    $currCurrencyCode  = session('currency')['code'];
                    $currCurrencyId  = session('currency')['id'];
                    $newCurr = Currency::firstRow('id',$request->input('currency'));
                    $secondAccountCurr = Currency::firstRow('id',Utility::checkDefaultAccountChartCurrency(Utility::OPENING_BALANCE_EQUITY_CHART_ID));
                    $latestExRate = ExchangeRate::where('status',Utility::STATUS_ACTIVE)->OrderBy('id','DESC')->first();
                    $uid = Utility::generateUID('account_journal');

                    /*return response()->json([
                        'message2' => Utility::openingBalanceCreditDebit($accountCat),
                        'message' => 'warning'
                    ]);*/

                    $extData = [
                        'sum_total' => $request->input('original_cost'),
                        'post_date' => Utility::standardDate($request->input('cost_date')),
                        'ex_rate' => $latestExRate->rates,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    $journalExt = JournalExtension::create($extData);

                    $journalDbDATA = [
                        'uid' => $uid,
                        'acct_cat_id' => $request->input('account_category'),
                        'detail_id' => $request->input('detail_type'),
                        'chart_id' => $createChart->id,
                        'extension_id' => $journalExt->id,
                        'fin_year' => $finYear->id,
                        'trans_desc' => 'Opening Balance',
                        'amount' => $request->input('original_cost'),
                        'trans_amount' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$request->input('original_cost')),
                        'total' => $request->input('original_cost'),
                        'trans_total' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$request->input('original_cost')),
                        'default_curr' => $currCurrencyId,
                        'trans_curr' => $request->input('currency'),
                        'trans_date' => Utility::standardDate($request->input('cost_date')),
                        'debit_credit' => Utility::openingBalanceCreditDebit($accountCat),
                        'ex_rate' => $latestExRate->rates,
                        'open_balance_status' => Utility::STATUS_ACTIVE,
                        'main_trans' => Utility::STATUS_ACTIVE,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE


                    ];
                    $create1 = AccountJournal::create($journalDbDATA);
                    $openingBalanceCreditDebit = (Utility::openingBalanceCreditDebit($accountCat) == Utility::DEBIT_TABLE_ID) ? Utility::CREDIT_TABLE_ID : Utility::DEBIT_TABLE_ID;

                    $journalOpenBalanceDbDATA = [
                        'uid' => $uid,
                        'acct_cat_id' => Utility::OPENING_BALANCE_ACCOUNT_CATEGORY_ID,
                        'detail_id' => Utility::OPENING_BALANCE_DETAIL_ID,
                        'chart_id' => Utility::OPENING_BALANCE_EQUITY_CHART_ID,
                        'extension_id' => $journalExt->id,
                        'fin_year' => $finYear->id,
                        'trans_desc' => 'Opening Balance for '.$request->input('account_name'),
                        'amount' => $request->input('original_cost'),
                        'trans_amount' => Utility::convertAmount($currCurrencyCode,$secondAccountCurr->code,$request->input('original_cost')),
                        'total' => $request->input('original_cost'),
                        'trans_total' => Utility::convertAmount($currCurrencyCode,$secondAccountCurr->code,$request->input('original_cost')),
                        'default_curr' => $currCurrencyId,
                        'trans_curr' => $secondAccountCurr->id,
                        'trans_date' => Utility::standardDate($request->input('cost_date')),
                        'debit_credit' => $openingBalanceCreditDebit,
                        'ex_rate' => $latestExRate->rates,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE


                    ];
                    $create2 = AccountJournal::create($journalOpenBalanceDbDATA);
                    $selectOpenBalEquity = AccountChart::firstRow('id',Utility::OPENING_BALANCE_EQUITY_CHART_ID);
                    if($selectOpenBalEquity->curr_id == ''){
                        $update = AccountChart::defaultUpdate('id',Utility::OPENING_BALANCE_EQUITY_CHART_ID,['curr_id' => $secondAccountCurr->id]);
                    }

                    //DO THE FOLLOWING IF DEPRECIATION IS CHECKED
                    if($request->input('track_depreciation') == 'checked'){

                        if(empty($request->input('depreciation'))) {        //IF DEPRECIATION AMOUNT IS EMPTY, SAVE DATA AND EXIT PROCESSING OF LEDGER ENTRY BELOW
                            return response()->json([
                                'message' => 'good',
                                'message2' => 'saved'
                            ]);
                        }

                        $dbDATA = [
                            'acct_cat_id' => $request->input('account_category'),
                            'detail_id' => $request->input('detail_type'),
                            'acct_no' => $request->input('account_number'),
                            'acct_name' => ucfirst($request->input('account_name')).' (Depreciation)',
                            'curr_id' => $request->input('currency'),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        $createChart2 = AccountChart::create($dbDATA);

                        $extData = [
                            'sum_total' => $request->input('original_cost'),
                            'post_date' => Utility::standardDate($request->input('cost_date')),
                            'ex_rate' => $newCurr->rates,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];

                        $journalExt2 = JournalExtension::create($extData);

                        $journalDbDATA = [
                            'uid' => $uid,
                            'acct_cat_id' => $request->input('account_category'),
                            'detail_id' => $request->input('detail_type'),
                            'chart_id' => $createChart2->id,
                            'extension_id' => $journalExt2->id,
                            'fin_year' => $finYear->id,
                            'trans_desc' => 'Opening Balance',
                            'amount' => $request->input('depreciation'),
                            'trans_amount' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$request->input('depreciation')),
                            'total' => $request->input('depreciation'),
                            'trans_total' => Utility::convertAmount($currCurrencyCode,$newCurr->code,$request->input('depreciation')),
                            'default_curr' => $currCurrencyId,
                            'trans_curr' => $request->input('currency'),
                            'trans_date' => Utility::standardDate($request->input('cost_date')),
                            'debit_credit' => Utility::CREDIT_TABLE_ID,
                            'ex_rate' => $latestExRate->rates,
                            'open_balance_status' => Utility::STATUS_ACTIVE,
                            'depreciation_status' => Utility::STATUS_ACTIVE,
                            'main_trans' => Utility::STATUS_ACTIVE,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE


                        ];
                        $create1 = AccountJournal::create($journalDbDATA);

                        $journalOpenBalanceDbDATA = [
                            'uid' => $uid,
                            'acct_cat_id' => Utility::OPENING_BALANCE_ACCOUNT_CATEGORY_ID,
                            'detail_id' => Utility::OPENING_BALANCE_DETAIL_ID,
                            'chart_id' => Utility::OPENING_BALANCE_EQUITY_CHART_ID,
                            'extension_id' => $journalExt2->id,
                            'fin_year' => $finYear->id,
                            'trans_desc' => 'Opening Balance for '.$request->input('account_name'). '(Depreciation)',
                            'amount' => $request->input('depreciation'),
                            'trans_amount' => Utility::convertAmount($currCurrencyCode,$secondAccountCurr->code,$request->input('depreciation')),
                            'total' => $request->input('depreciation'),
                            'trans_total' => Utility::convertAmount($currCurrencyCode,$secondAccountCurr->code,$request->input('depreciation')),
                            'default_curr' => $currCurrencyId,
                            'trans_curr' => $request->input('currency'),
                            'trans_date' => Utility::standardDate($request->input('depreciation_date')),
                            'debit_credit' => Utility::DEBIT_TABLE_ID,
                            'ex_rate' => $latestExRate->rates,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE


                        ];
                        $create2 = AccountJournal::create($journalOpenBalanceDbDATA);

                    }
                    //END OF DEPRECIATION PROCESS


                }

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);



    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $mainData = AccountChart::firstRow('id',$request->input('dataId'));
        $currency = Currency::getAllData();
        return view::make('account_chart.edit_form')->with('edit',$mainData)->with('currency',$currency);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //

        $validator = Validator::make($request->all(),AccountChart::$mainRulesEdit);
        if($validator->passes()) {

            $checkCurrency = AccountJournal::firstRow('chart_id',$request->input('edit_id'));

            if(!empty($checkCurrency)){

                return response()->json([
                    'message2' => 'Currency cannot be changed as this account has already recorded transactions in the general ledger',
                    'message' => 'warning'
                ]);

            }

            $dbDATA = [
                'acct_no' => $request->input('account_number'),
                'acct_name' => $request->input('account_name'),
                'curr_id' => $request->input('currency'),
                'updated_by' => Auth::user()->id
            ];

            if(in_array($request->input('edit_id'),Utility::DEFAULT_ACCOUNT_CHART)){

                $dbDATA = [
                    'acct_no' => $request->input('account_number'),
                    'curr_id' => $request->input('currency'),
                    'updated_by' => Auth::user()->id
                ];
                /*return response()->json([
                    'message2' => 'Default chart of accounts cannot be modified',
                    'message' => 'warning'
                ]);*/

            }



            AccountChart::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);


        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));

        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        if(Utility::checkArraySimilarity($all_id,Utility::DEFAULT_ACCOUNT_CHART) == true){
            return response()->json([
                'message2' => 'You cannot delete any selected default account, please deselect default accounts to continue this process',
                'message' => 'warning'
            ]);
        }

        $password = $request->input('input_text');

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $checkJournal = AccountJournal::where('chart_id',$all_id[$i])->orderBy('id','DESC')->first();
            //dd($checkJournal); exit();
            if(!empty($checkJournal)){
                if(Utility::checkClosingBook($checkJournal->trans_date,$password) == Utility::ZERO){
                    $unused[$i] = $all_id[$i];
                }else{
                    $in_use[$i] = $all_id[$i];
                }

            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' account(s) last transaction is dated before or on the date of closing book and cannot be deleted. You can enter a correct password to these accounts' : '';
        if(count($in_use) > 0){
            $delete = AccountChart::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message' => 'deleted',
                'message2' => count($in_use).' data(s) has been deleted '.$message
            ]);

        }else{
            return  response()->json([
                'message2' => count($unused).' account(s) last transaction is dated before or on the date of closing book and cannot be deleted You can enter a correct password to these accounts',
                'message' => 'warning'
            ]);

        }
    }

    public function changeStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $dbData = [
            'active_status' => $status
        ];
        $delete = AccountChart::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

    public function totalChartAmount($data){
        foreach($data as $d){
            $finYear = FinancialYear::firstRow('active_status',Utility::STATUS_ACTIVE);

            if(!empty($finYear)){
                $checkEntry = AccountJournal::firstRow('chart_id',$d->id);
                /*$d->normal_balance = (!empty($checkEntry)) ? 1 : 0;
                $d->foreign_balance = $d->id;*/
                if(!empty($checkEntry)) {
                    $debitSum = AccountJournal::sumColumnDataCondition3('fin_year', $finYear->id, 'chart_id', $d->id, 'debit_credit', Utility::DEBIT_TABLE_ID, 'amount');
                    $foreignDebitSum = AccountJournal::sumColumnDataCondition3('fin_year', $finYear->id, 'chart_id', $d->id, 'debit_credit', Utility::DEBIT_TABLE_ID, 'trans_amount');

                    $creditSum = AccountJournal::sumColumnDataCondition3('fin_year', $finYear->id, 'chart_id', $d->id, 'debit_credit', Utility::CREDIT_TABLE_ID, 'amount');
                    $foreignCreditSum = AccountJournal::sumColumnDataCondition3('fin_year', $finYear->id, 'chart_id', $d->id, 'debit_credit', Utility::CREDIT_TABLE_ID, 'trans_amount');

                    $foreignBalance = Utility::chartBalance($d->acct_cat_id, $foreignDebitSum, $foreignCreditSum);
                    $normalBalance = Utility::chartBalance($d->acct_cat_id, $debitSum, $creditSum);

                    $d->normal_balance = $normalBalance;
                    $d->foreign_balance = $foreignBalance;
                }else{
                    $d->normal_balance = '0.00';
                    $d->foreign_balance = '0.00';
                }

            }

        }
    }


}
