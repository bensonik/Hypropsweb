<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Payroll;
use App\model\Requisition;
use App\model\Company;
use App\model\Tax;
use App\model\AccountJournal;
use App\model\SalaryStructure;
use App\User;
use App\Helpers\Notify;
use Auth;
use Monolog\Handler\Curl\Util;
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

class PayrollController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? Payroll::paginateAllData() :Payroll::specialColumnsPage('payroll_status',Utility::APPROVED) ;
        $salarySum = Utility::sumColumnDataCondition('payroll','payroll_status',Utility::PROCESSING,'total_amount');

        if ($request->ajax()) {
            return \Response::json(view::make('payroll.reload',array('mainData' => $mainData,'salarySum' => $salarySum))->render());

        }else{
            return view::make('payroll.main_view')->with('mainData',$mainData)->with('salarySum',$salarySum);
        }

    }

    public function paySlip(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Payroll::specialColumnsPage2('user_id',Auth::user()->id,'payroll_status',Utility::APPROVED);
        if ($request->ajax()) {
            return \Response::json(view::make('payroll.payslip_reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('payroll.paySlip')->with('mainData',$mainData);
        }

    }

    /**
     * Display payslip item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payslipItem(Request $request)
    {
        //
        $companyInfo = Company::firstRow('active_status',Utility::STATUS_ACTIVE);
        //print_r($companyInfo); exit();
        $payslip = Payroll::firstRow('id',$request->input('dataId'));
        $user = User::firstRow('id',Auth::user()->id);
        $tax = Tax::firstRow('id',$user->salary->tax_id);
        $month = Utility::getMonthFromDate($payslip->month);
        $loan = Utility::checkForDeductions(Auth::user()->id,$month,Utility::EMPLOYEE_LOAN_ID);
        $advance = Utility::checkForDeductions(Auth::user()->id,$month,Utility::SALARY_ADVANCE_ID);
        //$taxAmount = ($tax->sum_percentage/100)*$user->salary->gross_pay;
        $taxAmount = $payslip->tax_amount;
        $payrollDeduct = ($payslip->bonus_deduc_type == Utility::PAYROLL_DEDUCTION) ? $payslip->bonus_deduc : 0;
        $totalSalaryDeduction = $this->primarySalaryDeduction($payslip->component,$loan,$advance,$payrollDeduct);
        //print_r($tax); exit();
        return view::make('payroll.edit_form')->with('edit',$payslip)->with('companyInfo',$companyInfo)
            ->with('user',$user)->with('tax',$tax)->with('taxAmount',$taxAmount)->with('totalDeduction',$totalSalaryDeduction);

    }

    public function primarySalaryDeduction($jsonData,$loan,$salAdv,$payrollDeduct){
        $array = json_decode($jsonData,true);
        $holdArray = [];
        foreach($array as $data){
            if($data['component_type'] == Utility::COMPONENT_TYPE[2]){
                $holdArray[] = $data['amount'];
            }

        }
        $sum = array_sum($holdArray);
        $totalDeduct = $sum+$loan+$salAdv+$payrollDeduct;
        return $totalDeduct;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request)
    {
        //

        $validator = Validator::make($request->all(),Payroll::$mainRules);
        if($validator->passes()){

            $bonusDeduc = ($request->input('extra_amount') == '') ? Utility::ZERO : $request->input('bonus_deduct_type');
            $extraAmount = ($request->input('extra_amount') == '') ? Utility::ZERO : $request->input('extra_amount');
            $all_id = json_decode($request->input('all_data'));
            $processDate = $request->input('date');
            $oldDateUnix = strtotime($processDate);
            $year = date('Y',$oldDateUnix);
            $month = $request->input('month');

            $in_use = [];;
            $monthInt = date('n',$oldDateUnix);
            $unused = [];
            $dataExist = [];
            Utility::checkCurrencyActiveStatus();

            for($i=0;$i<count($all_id);$i++){
                $rowDataSalary = Payroll::countData2('user_id',$all_id[$i],'month',$month);
                $rowDataSalary1 = Payroll::countData('id',$all_id[$i]);
                if($rowDataSalary>0 || $rowDataSalary1>0){
                    $unused[$i] = $all_id[$i];
                }else{
                    $in_use[$i] = $all_id[$i];
                }
            }

            $message = (count($unused) > 0) ? ' and '.count($unused).
                ' user(s) already exist in payroll for the selected period' : '';

            if(count($in_use) > 0){

                $defaultCurr = session('currency')['id'];
                for($i=0;$i<count($in_use);$i++){
                    $user =  User::firstRow('id',$in_use[$i]);
                    $salaryId = SalaryStructure::firstRow('id',$user->salary_id);
                    $tax = Tax::firstRow('id',$salaryId->id);
                    $taxAmount = ($tax->sum_percentage/100)*$salaryId->gross_pay;
                    $totalAmount = Utility::calculateSalary($in_use[$i],$extraAmount,$bonusDeduc);

                    /*return response()->json([
                        'message2' => $totalAmount,
                        'message' => 'warning'
                    ]);*/
                    $dbData = [
                        'user_id' => $in_use[$i],
                        'bonus_deduc' => $extraAmount,
                        'bonus_deduc_type' => $bonusDeduc,
                        'bonus_deduc_desc' => $request->input('amount_desc'),
                        'salary_id' => $salaryId->id,
                        'component' => $salaryId->component,
                        'dept_id' => $user->dept_id,
                        'position_id' => $user->position_id,
                        'total_amount' => $totalAmount,
                        'tax_amount' => $taxAmount,
                        'curr_id' => $defaultCurr,
                        'process_date' => Utility::standardDate($processDate),
                        'payroll_status' => Utility::PROCESSING,
                        'month' => $monthInt,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    $create = Payroll::create($dbData);

                }

                return response()->json([
                'message2' => 'saved',
                'message' => 'saved successfully'
            ]);
                    $mailContentApproved = new \stdClass();
                    $mailContentApproved->type = 'process_request';
                    $mailContentApproved->desc = 'Payroll for '.$month.' '.$year;
                    $mailContentApproved->sender = Auth::user()->firstname . ' ' . Auth::user()->lastname;

                    $accountants = User::specialColumns('role',Utility::ACCOUNTANTS);
                    if(count($accountants) >0){ //SEND MAIL TO ALL IN ACCOUNTS DEPARTMENT ABOUT THIS APPROVAL
                        foreach($accountants as $data) {
                            Notify::payrollMail('mail_views.payroll', $mailContentApproved, $data->email, Auth::user()->firstname, 'Process Request');
                        }
                    }


                return response()->json([
                    'message2' => 'saved',
                    'message' => count($in_use).' data(s) has been sent to accounts for processing '.$message
                ]);

            }
            /////////////////////////////////////////////////

            if(count($unused) > 0){

                $defaultCurr = session('currency')['id'];
                for($i=0;$i<count($unused);$i++){
                    $user =  User::firstRow('id',$unused[$i]);
                    $salaryId = SalaryStructure::firstRow('id',$user->salary_id);
                    $paid = Payroll::firstRow('id',$unused[$i]);
                    $tax = Tax::firstRow('id',$salaryId->id);
                    $taxAmount = ($tax->sum_percentage/100)*$salaryId->gross_pay;
                    $totalAmount = ($bonusDeduc == Utility::PAYROLL_DEDUCTION) ?$paid->total_amount-$extraAmount : $paid->total_amount+$extraAmount;

                    $dbData = [
                        'bonus_deduc' => $extraAmount,
                        'bonus_deduc_type' => $bonusDeduc,
                        'bonus_deduc_desc' => $request->input('amount_desc'),
                        'salary_id' => $salaryId->id,
                        'component' => $salaryId->component,
                        'dept_id' => $user->dept_id,
                        'total_amount' => $totalAmount,
                        'tax_amount' => $taxAmount,
                        'curr_id' => $defaultCurr,
                        'process_date' => Utility::standardDate($processDate),
                        'payroll_status' => Utility::PROCESSING,
                        'month' => $monthInt,
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    $update = Payroll::defaultUpdate('id',$unused[$i],$dbData);

                }

                return response()->json([
                    'message2' => 'saved',
                    'message' => 'saved successfully'
                ]);
                $mailContentApproved = new \stdClass();
                $mailContentApproved->type = 'update_request';
                $mailContentApproved->desc = 'Payroll for '.$month.' '.$year;
                $mailContentApproved->sender = Auth::user()->firstname . ' ' . Auth::user()->lastname;

                $accountants = User::specialColumns('role',Utility::ACCOUNTANTS);
                if(count($accountants) >0){ //SEND MAIL TO ALL IN ACCOUNTS DEPARTMENT ABOUT THIS APPROVAL
                    foreach($accountants as $data) {
                        Notify::payrollMail('mail_views.payroll', $mailContentApproved, $data->email, Auth::user()->firstname, 'Process Request');
                    }
                }


                return response()->json([
                    'message2' => 'saved',
                    'message' => count($in_use).' data(s) has been sent to accounts for processing '.$message
                ]);

            }

            ///////////////////////////////////////////////////

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $journalValid = $request->input('ledger_valid');
        $status = $request->input('input');
        $payDate = $request->input('date');

        $dbData = [
            'payroll_status' => Utility::APPROVED,
            'pay_date' => Utility::standardDate($payDate),
            'updated_by' => Auth::user()->id
        ];

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $rowDataSalary = AccountJournal::specialColumns('foreign_id', $all_id[$i]);
            if(count($rowDataSalary)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }

        $mailContentApproved = new \stdClass();
        $mailContentApproved->type = 'request_approval';
        $mailContentApproved->desc = count($all_id).' users in the payroll have received payment';
        $mailContentApproved->sender = Auth::user()->firstname . ' ' . Auth::user()->lastname;

        $updateApproval = Payroll::massUpdate('id',$all_id,$dbData);

        if(count($in_use) > 0){
            //CREATE DATA TO GENERAL LEDGER IF JOURNALVALID IS 1 AND CHECKED CREATE THE DATA IN LEDGER
            if($journalValid == Utility::STATUS_ACTIVE){

            }

        }else{

            //UPDATE LEDGER IF SOME DATA ALREADY EXISTS IN GENERAL LEDGER
            if(count($unused)>0){

            }

        }

        if($status == 1) {
            $hr = User::specialColumns('role', Utility::HR);
            if (count($hr) > 0) { //SEND MAIL TO ALL IN ACCOUNTS DEPARTMENT ABOUT THIS APPROVAL
                foreach ($hr as $data) {
                    Notify::payrollMail('mail_views.payroll', $mailContentApproved, $data->email, Auth::user()->firstname, 'Request Approval');
                }
            }
        }

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Payment was made to '.count($in_use).' entry(ies)'
        ]);



    }

    /**
     * Search the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchUser(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = User::searchUser($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/

        $user_ids = array_unique($obtain_array);
        $mainData =  (Auth::user()->id == 3) ? User::massDataMassConditionPaginate('uid',$user_ids,'role',Utility::USER_ROLES_ARRAY)
            :User::massDataPaginate('uid', $user_ids);
        //print_r($obtain_array); die();
        if (count($user_ids) > 0) {

            return view::make('payroll.search_user')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

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

            $delete = Payroll::massUpdate('id',$all_id,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($all_id).' data(s) has been deleted'
            ]);

    }

    public function refineData($data){
        $holdArray = [];
        if(count($data) >0){
            foreach($data as $value){
                if($value->payroll_status == Utility::PROCESSING){
                    $holdArray[] = $value->total_amount;
                }
            }
            $data->salary_sum = array_sum($holdArray);
        }


    }

}
