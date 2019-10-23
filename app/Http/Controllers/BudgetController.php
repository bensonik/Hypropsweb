<?php

namespace App\Http\Controllers;

use App\model\AccountChart;
use App\model\Budget;
use App\model\BudgetSummary;
use App\model\RequestCategory;
use App\model\AccountCategory;
use App\model\Department;
use App\Helpers\Utility;
use App\model\Requisition;
use App\User;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class BudgetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

     * Show the form for creating a new resource.
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response

     */
    public function index(Request $request, $id)
    {
        //
        $bExist = []; $bNotExist = [];
        $existingBudget = Budget::specialColumnsOneRow('budget_id',$id,'request_cat_id');
        $deptRequest = RequestCategory::specialColumnsOr2('dept_id',Auth::user()->dept_id,'general',Utility::DETECT);

        foreach($deptRequest as $data){
            $bNotExist[] = $data->id;
        }
        foreach($existingBudget as $data){
            $bExist[] = $data->request_cat_id;
        }

        $budgetData = Budget::specialColumnsAsc('budget_id',$id);
        $emptyRequestIdArr = array_diff($bNotExist,$bExist);

        $mainData = RequestCategory::massDataAlphaOrder('id',$emptyRequestIdArr);
        $this->addCorrespondingAccountChart($mainData);
        $this->addCorrespondingAccountChart2($budgetData);
        //print_r($emptyRequestIdArr); exit();
        $detectHod = Utility::detectHOD(Auth::user()->id);
        $budgetDetail = BudgetSummary::firstRow('id',$id);




            return view::make('budget.main_view')->with('mainData',$mainData)
                ->with('detectHod',$detectHod)->with('budgetDetail',$budgetDetail)->with('budget',$budgetData);

    }

    /**
     * Show the form for creating a new resource.
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */

    public function createModify(Request $request)
    {
        //

        $budgetApproval = BudgetSummary::firstRow('id',$request->input('budget'));
        if($budgetApproval->approval_status != Utility::APPROVED){
            $month = $this->monthName($request->input('monthName'));
            $quarter = $request->input('quarterName');

            $checkCat = Budget::firstRow('request_cat_id',$request->input('requestCat'));
            if(!empty($checkCat)) {
                $dbDATA = [
                    $month => $request->input('monthCatAmount'),
                    $quarter => $request->input('quarterAmount'),
                    'total_cat_amount' => $request->input('totalCatAmount'),
                    'budget_id' => $request->input('budget'),
                    'request_cat_id' => $request->input('requestCat'),
                    'fin_year_id' => $request->input('finYear'),
                    'updated_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Budget::defaultUpdate('request_cat_id', $request->input('requestCat'), $dbDATA);

            }else{

                $dbDATA = [
                    $month => $request->input('monthCatAmount'),
                    $quarter => $request->input('quarterAmount'),
                    'total_cat_amount' => $request->input('totalCatAmount'),
                    'budget_id' => $request->input('budget'),
                    'request_cat_id' => $request->input('requestCat'),
                    'fin_year_id' => $request->input('finYear'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Budget::create($dbDATA);

            }

            return response()->json([
                'message2' => 'saved',
                'message' => 'success'
            ]);

        }

        return response()->json([
            'message2' => 'warning',
            'message' => 'Budget have been approved and cannot be modified at the moment'
        ]);

    }

    /**
     * Show the form for creating a new resource.
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */


    public function createModifyAcct(Request $request)
    {
        //

        $budgetApproval = BudgetSummary::firstRow('id', $request->input('budget'));
        if ($budgetApproval->approval_status != Utility::APPROVED) {


            $acctData = AccountChart::firstRow('id', $request->input('accountId'));

            $checkCat = Budget::firstRow('request_cat_id',$request->input('requestCat'));
            if(!empty($checkCat)) {
                $dbDATA = [
                    'acct_id' => $request->input('accountId'),
                    'acct_cat_id' => $acctData->acct_cat_id,
                    'acct_detail_id' => $acctData->detail_id,
                    'updated_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Budget::defaultUpdate('request_cat_id', $request->input('requestCat'), $dbDATA);

                return response()->json([
                    'message2' => 'saved',
                    'message' => 'success'
                ]);

            } else {

                    $dbDATA = [
                        'request_cat_id' => $request->input('requestCat'),
                        'acct_id' => $request->input('accountId'),
                        'acct_cat_id' => $acctData->acct_cat_id,
                        'acct_detail_id' => $acctData->detail_id,
                        'budget_id' => $request->input('budget'),
                        'fin_year_id' => $request->input('finYear'),
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    Budget::create($dbDATA);
            }

            return response()->json([
                'message2' => 'saved',
                'message' => 'success'
            ]);

        }

        return response()->json([
            'message' => 'warning',
            'message2' => 'Budget have been approved and cannot be modified at the moment'
        ]);


    }



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
        $deleteId = $request->input('dataId');
        $budgetApproval = BudgetSummary::firstRow('id',$request->input('param'));
        if($budgetApproval->approval_status == Utility::APPROVED) {
            Budget::destroy($deleteId);

            return response()->json([
                'message2' => 'deleted',
                'message' => 'Data deleted successfully'
            ]);

        }

        return response()->json([
            'message2' => 'warning',
            'message' => 'Budget have been approved and cannot be modified at the moment'
        ]);

    }

    public function addCorrespondingAccountChart($mainData){
        foreach($mainData as $data){
            $accountCategories = AccountChart::specialColumns('acct_cat_id',$data->acct_id);
            $data->accountCategories = $accountCategories;
        }
        return $mainData;
    }

    public function addCorrespondingAccountChart2($mainData){
        foreach($mainData as $data){
            $accountCategories = AccountChart::specialColumns('acct_cat_id',$data->acct_cat_id);
            $data->accountCategories = $accountCategories;
        }
        return $mainData;
    }

    public function monthName($monthNum){
        //$explode = explode('_',$monthNum);
        //$month = '';
        switch ($monthNum) {
            case 'month_1' :
                $month = 'Jan';
                break;
            case 'month_2':
                $month = 'Feb';
                break;
            case 'month_3':
                $month = 'March';
                break;
            case 'month_4' :
                $month = 'April';
                break;
            case 'month_5':
                $month = 'May';
                break;
            case 'month_6':
                $month = 'June';
                break;
            case 'month_7' :
                $month = 'July';
                break;
            case 'month_8':
                $month = 'August';
                break;
            case 'month_9':
                $month = 'Sept';
                break;
            case 'month_10' :
                $month = 'Oct';
                break;
            case 'month_11':
                $month = 'Nov';
                break;
            case 'month_12':
                $month = 'Dec';
                break;

            default:
                $month = 'Jan';
                break;
        }
        return $month;
    }

}
