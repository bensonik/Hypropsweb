<?php
/**
 * Created by PhpStorm.
 * User: snweze
 * Date: 11/10/2017
 * Time: 2:05 PM
 */

namespace App\Helpers;

use Illuminate\Http\Request;
use DB;
use Auth;
use view;
use mail;
use Illuminate\Support\Facades\Session;
use Psy\Exception\ErrorException;
use Illuminate\Support\Facades\Storage;

class Utility
{

    const DEFAULT_LOGO = 'logo.jpg';
    const STATUS_INACTIVE = 2, STATUS_ACTIVE = 1, STATUS_DELETED = 0;
    const USER_ROLES_ARRAY = [4,5,6,7,8];
    const PROCESSING = 0, APPROVED = 1, DENIED = 2, COMPLETED = 1;
    const USUAL_REQUEST_TYPE = 1, PROJECT_REQUEST_TYPE = 2;
    const TOP_USERS = [1,2,3], ACCOUNTANTS = 5, HR_MANAGEMENT = [1,2,3,6], ACCOUNT_MANAGEMENT = [1,2,3,5], HR = 6;
    const PRO_QUAL = 1, TECH_COMP = 2, BEHAV_COMP = 3;
    const APP_OBJ_GOAL = 1, COMP_ASSESS = 2, BEHAV_COMP2 = 3, INDI_REV_COMMENT = 4, EMP_COM_APP_PLAT = 5;
    const P25 = '25', P20 = '20', P15 = '15', P50 = '50', P100 = '100', P35 = '35';
    const HOD_DETECTOR = 1, DETECT = 1;
    const REVIEW_RATE = [1 => 'None', 2 => 'Exceeded Expectations', 3 => 'Met expectations', 4 => 'Did not meet expectations'];
    const REVIEW_RATE2 = [1,2,3,4,5,'Nil'];
    const REVIEW_LEVEL = [1,2,3,4,5,'Nil'];
    const OVERALL_RATING = [1 => 'None', 2 => 'O - Outstanding', 3 => 'H - High performer', 4 => 'P - Performing as expected',
                            5 => 'B - Below expectations'];
    const ZERO = 0;
    const SIGN_OFF =[1=>'Appraisal Ongoing', 2 => 'Sign off'];
    const APPRAISAL_STATUS = [0 => 'Reviewing Phase', 1 => 'Appraisal Completed'];
    const SALARY_ADVANCE_ID = 2, EMPLOYEE_LOAN_ID = 3;
    const DEFAULT_REQUEST_CATEGORIES = [self::SALARY_ADVANCE_ID,self::EMPLOYEE_LOAN_ID];
    const LOAN_REQUEST = 1, SALARY_ADVANCE_REQUEST = 2;
    const PAYROLL_BONUS = 1, PAYROLL_DEDUCTION = 2;
    const PAY_INTERVAL = [1 => 'January',2 => 'February',3 => 'March',4 => 'April',5 => 'May',6 => 'June',
        7 => 'July',8 => 'August',9 => 'September',10 => 'October',11 => 'November', 12 => 'December', 13 => 'Week1',
        14 => 'Week2', 15 => 'Week3', 16 => 'Week4'];

    const COMPONENT_TYPE = [1 => 'Earnings',2 => 'Deduction'];
    const TRAINING_TYPE = [1 => 'Internal',2 => 'External'];

    const SPECIAL_EQUIP = ['According to bin','According to SKU/Item'];
    const CAPACITY_POLICY = ['Never check capacity','Allow more than max capacity','Prohibit more than max capacity'];

    const SCM_MANAGEMENT = [1,2,3,9,10];
    const VENDOR = 1, CUSTOMER = 2;
    const COST_METHOD = ['FIFO','LIFO','Specific','Average','Standard'];
    const INVENTORY_TYPE = [1 => 'Inventory', 2 => 'Non-Inventory', 3 => 'Service'];
    const DEFAULT_ACCOUNT_CHART = [1,2,3,4,5,6];
    const NO_DEPRECIATION_ACCOUNT_CAT_DB_ID = [2,3,7,8,9,5], FIXED_ASSET_DB_ID = 4;
    const CREDIT_TABLE_ID = 1, DEBIT_TABLE_ID = 2;
    const CREDIT_OPENING_BALANCE_EQUITY = [3,4,2,5], DEBIT_OPENING_BALANCE_EQUITY = [7,8,9], OPENING_BALANCE_EQUITY_CHART_ID = 1, OPENING_BALANCE_DETAIL_ID = 51,
            OPENING_BALANCE_ACCOUNT_CATEGORY_ID =10;




    public static function IMG_URL(){
        return public_path() . '/images/';
    }

    public static function FILE_URL($file = ''){
        return public_path() . '/files/'.$file;
    }

    public static function AUDIO_URL(){
        return public_path() . '/audio/';
    }

    public static function generateUID($table = null, $limit = 12) {
        $uid = "";
        $array = array_merge(range(0, 1), range(7, 9));
        for ($i = 0; $i < $limit; $i++) {
            $uid.=$array[array_rand($array)];
        }
        if($table === null){
            return $uid;
        }
        else{
            if(self::uidExists($uid , $table)){
                $uid =  self::generateUID($table , $limit);
            }
            return $uid;

        }

    }

    public static function generateEID($table = null, $limit = 6,$prefix) {
        $uid = "";
        $array = array_merge(range(0, 1), range(7, 9));
        for ($i = 0; $i < $limit; $i++) {
            $uid.=$prefix.'-'.$array[array_rand($array)];
        }
        if($table === null){
            return $uid;
        }
        else{
            if(self::eidExists($uid , $table)){
                $uid =  self::generateEID($table , $limit);
            }
            return $uid;

        }

    }

    public static function digitalSign($table = null, $column = null, $limit = 18) {
        $uid = "hyp-";
        $array = array_merge(range(1, 20), range(20, 40));
        for ($i = 0; $i < $limit; $i++) {
            $uid.=$array[array_rand($array)];
        }
        if($table === null){
            return $uid;
        }
        else{
            if(self::digitalSignExists($uid , $column, $table)){
                $uid =  self::digitalSign($table , $column, $limit);
            }
            return $uid;

        }

    }

    public static function genRememberToken($table = null, $limit = 12) {
        $token = "";
        $array = array_merge(range(0, 1), range(7, 9));
        for ($i = 0; $i < $limit; $i++) {
            $token.=$array[array_rand($array)];
        }
        $token.= time();
        if($table === null){
            return md5($token);
        }
        else{
            if(self::tokenExists($token , $table)){
                $token =  self::genRememberToken($table , $limit);
            }
            return md5($token);

        }

    }

    public static function uidExists($uid, $table){
        $exists =  DB::table($table)->where('uid' , $uid)->count();
        return $exists > 0 ? true : false;
    }

    public static function eidExists($uid, $table){
        $exists =  DB::table($table)->where('uid' , $uid)->count();
        return $exists > 0 ? true : false;
    }

    public static function digitalSignExists($uid, $column, $table){
        $exists =  DB::table($table)->where($column , $uid)->count();
        return $exists > 0 ? true : false;
    }

    public static function tokenExists($token, $table){
        $exists =  DB::table($table)->where('remember_token' , $token)->count();
        return $exists > 0 ? true : false;
    }

    public static function itemExists($item, $table,$column){
        $exists =  DB::table($table)->where($column , $item)->where('status' , self::STATUS_ACTIVE)->count();
        if($exists){
            return true;
        }
        else{
            return false;
        }
        //return $exists > 0 ? true : false;
    }

    public static function convertDate(&$date){

        return date("d M Y H:i:s", strtotime($date));
    }

    public static function formatDateFields(&$data){
        foreach($data as &$val){
            //$val->formatted_date = self::convertDate($val->created_at);
            $val->formatted_date = date('d M Y', strtotime($val->created_at));
        }
        return $data;
    }

    public static function humanTiming ($time)
    {

        $time = time() - intval($time); // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }

    public static function realDateInterval(&$dataObject){

        foreach($dataObject as &$value){

            $old_date = $value->created_at;
            $time = strtotime($old_date);
            $diff = self::humanTiming($time).' ago';
            //$diff = self::humanTiming($time);
            $value->time_past = $diff;
            //$value->time_past = $value->created_at->diffForHumans();
        }
        return $dataObject;

    }

    public static function publicHumanTiming($value){

        $old_date = $value;
        $time = strtotime($old_date);
        $diff = self::humanTiming($time).' ago';
        //$diff = self::humanTiming($time);
        return  $diff;
        //return $value->diffForHumans();

    }

    public static function assembleArray(&$array){
        $default = [];
        foreach($array as $item){
            $default[] = $item;
        }
        return $default;
    }

    public static function arrayDiff($localArray,$foreignArray){
        $default = [];
        foreach($localArray as $item){
            $default[] = $item->id;
        }
        $newArray = array_diff($localArray,$foreignArray);
        return $newArray;
    }

    public static function paginateAllData($table)
    {
        return DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->paginate('15');

    }

    public static function getAllData($table)
    {
        return DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();

    }

    public static function paginateData($table,$column, $post)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->paginate('15');

    }

    public static function paginateData2($table,$column, $post, $column2, $post2)
    {
        return DB::table($table)
            ->where($column2, $post2)
            ->where($column, $post)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->paginate('15');

    }

    public static function sumColumnDataCondition($table,$column, $post,$sumColumn)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where('status', self::STATUS_ACTIVE)
            ->sum($sumColumn);

    }

    public static function sumColumnDataCondition2($table,$column, $post,$column2, $post2,$sumColumn)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where($column2, $post2)
            ->where('status', self::STATUS_ACTIVE)
            ->sum($sumColumn);

    }

    public static function sumColumnDataCondition3($table,$column, $post,$column2, $post2,$column3, $post3,$sumColumn)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where($column2, $post2)
            ->where($column3, $post3)
            ->where('status', self::STATUS_ACTIVE)
            ->sum($sumColumn);

    }

    public static function countData($table,$column, $post)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->count();

    }

    public static function countData2($table,$column1, $post1,$column2, $post2)
    {
        return DB::table($table)
            ->where($column1, $post1)
            ->where($column2, $post2)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->count();

    }

    public static function countData3($table,$column1, $post1,$column2, $post2,$column3, $post3)
    {
        return DB::table($table)
            ->where($column1, $post1)
            ->where($column2, $post2)
            ->where($column3, $post3)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->count();

    }

    public static function specialColumns($table,$column, $post)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumns2($table,$column, $post, $column2, $post2)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where($column2, $post2)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumns3($table,$column, $post, $column2, $post2, $column3, $post3)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where($column2, $post2)
            ->where($column3, $post3)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumns4($table,$column, $post, $column2, $post2, $column3, $post3, $column4, $post4)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where($column2, $post2)
            ->where($column3, $post3)
            ->where($column4, $post4)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')
            ->orderBy('id','DESC')->get();

    }

    public static function massData($table,$column, $post)
    {
        return DB::table($table)
            ->whereIn($column, $post)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')
            ->orderBy('id','DESC')->get();

    }
    public static function massDataCondition($table,$column, $post, $column2, $post2)
    {
        return DB::table($table)
            ->whereIn($column, $post)
            ->where($column2, $post2)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();

    }

    public static function firstRow($table,$column, $post)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where('status', self::STATUS_ACTIVE)->first();

    }

    public static function firstRow2($table,$column, $post,$column2, $post2)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where($column2, $post2)
            ->where('status', self::STATUS_ACTIVE)->first();

    }

    public static function firstRow3($table,$column, $post,$column2, $post2,$column3, $post3)
    {
        return DB::table($table)
            ->where($column, $post)
            ->where($column2, $post2)
            ->where($column3, $post3)
            ->where('status', self::STATUS_ACTIVE)->first();

    }

    public static function massUpdate($table,$column, $arrayPost, $arrayDataUpdate=[])
    {
        return DB::table($table)
            ->whereIn($column , $arrayPost
            )->update($arrayDataUpdate);

    }

    public static function defaultUpdate($table,$column, $postId, $arrayDataUpdate=[])
    {
        return DB::table($table)
            ->where($column , $postId
            )->update($arrayDataUpdate);

    }

    public static function deleteItem($table,$postId)
    {
        return DB::table($table)
            ->where('id' , $postId
            )->delete();

    }

    public static function tenColumnSingleValue($table,$column1,$column2,$column3,$column4
        ,$column5,$column6,$column7,$column8,$column9,$column10, $post)
    {
            return DB::table($table)
                ->where($column1, $post)
                ->orWhere($column2, $post)
                ->orWhere($column3, $post)
                ->orWhere($column4, $post)
                ->orWhere($column5, $post)
                ->orWhere($column6, $post)
                ->orWhere($column7, $post)
                ->orWhere($column8, $post)
                ->orWhere($column9, $post)
                ->orWhere($column10, $post)
                ->where('status', self::STATUS_ACTIVE)->get();

    }

    public static function detectHOD($id)
    {
        $data = DB::table('dept_approvals')
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                if ($value->dept_head == $id) {
                    $determiner = 1;
                }
            }
        }
        return $determiner;
    }

    public static function detectHODId($deptId)
    {
        $data = DB::table('dept_approvals')
            ->where('dept', $deptId)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                    $determiner = $value->dept_head;
            }
        }
        return $determiner;
    }

    public static function appSupervisor($table,$dept,$id)
    {
        $data = DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->where('dept_id', $dept)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                if ($value->user_id == $id) {
                    $determiner = 1;
                }
            }
        }
        return $determiner;
    }

    public static function appSupervisorId($table,$dept,$id)
    {
        $data = DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->where('dept_id', $dept)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                    $determiner = 1;
            }
        }
        return $determiner;
    }

    public static function detectSelected($table,$id)
    {
        $data = DB::table($table)
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->get();
        $determiner = 0;
        if(count($data) >0) {
            foreach ($data as $value) {
                if ($value->user_id == $id) {
                    $determiner = 1;
                }
            }
        }
        return $determiner;
    }

    public static function detectRequestAccess($data){
            $detect = 0;
            foreach($data as $val){
                if($val->user_id == Auth::user()->id){
                    $detect = 1;
                }
            }
            return $detect;
    }

    public static function getDaysLength($startDate,$endDate){
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        if($startDate <= $endDate){
            $datediff = $endDate - $startDate;
            return floor($datediff / (60 * 60 * 24));
        }
        return 0;
    }

    public static function LeaveDaysValidator($leaveType,$days)
    {
        $year = date('Y');
        $determiner = false;
        $leave = DB::table('leave_type')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $leaveType)->first();

        $data = DB::table('leave_log')
            ->where('status', self::STATUS_ACTIVE)
            ->where('request_user', Auth::user()->id)
            ->where('deny_reason', '')
            ->where('year', $year)->get();

        $holdArr = [];
        if(count($data) >0) {
            foreach ($data as $value) {
                $holdArr[] = $value->duration;
            }
            $sumArr = array_sum($holdArr);
            $dayLength = $sumArr + $days;
            $determiner = ($leave->days > $dayLength) ? true : false;
        }
        return $determiner;
    }

    public static function standardDate($date){
        $newDate = date("Y-m-d", strtotime($date));
        return $newDate;
    }

    public static function standardDateTime($date){
        $newDate = date("d-m-Y:H:i:s", strtotime($date));
        return $newDate;
    }

    public static function extraLeaveDays($leaveType){
        $year = date('Y');
        $determiner = 0;
        $leaveType = DB::table('leave_type')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $leaveType)->first();

        $data = DB::table('leave_log')
            ->where('status', self::STATUS_ACTIVE)
            ->where('request_user', Auth::user()->id)
            ->where('deny_reason', '')
            ->where('year', $year)->get();

        $holdArr = [];
        if(count($data) >0) {
            foreach ($data as $value) {
                $holdArr[] = $value->duration;
            }
            $sumArr = array_sum($holdArr);
            $determiner = $leaveType->days - $sumArr;
        }
        return $determiner;
    }

    public static function loanMonthlyDeduction($amount,$interestRATE){

        /*$data = DB::table('salary')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', Auth::user()->salary_id)->first();*/

        $interestAmount = $amount*($interestRATE/100);
        $totalPayBackAmount = $amount+$interestAmount;
        $monthPayBackAmount = $totalPayBackAmount/12;
        return $monthPayBackAmount;
    }

    public static function calculateSalary($userId,$extraAmount,$bonusDeduc){

        $data = DB::table('users')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $userId)->first();

        $salaryData = DB::table('salary')
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', $data->salary_id)->first();


        $newAmount = 0;

        if($bonusDeduc == '0') {
            $newAmount = $salaryData->net_pay;
        }else{

            $salAdvData = DB::table('requisition')
                ->where('request_user', $userId)
                ->where('req_cat', self::SALARY_ADVANCE_ID)
                ->where('accessible_status', self::ZERO)
                ->where('status', self::STATUS_ACTIVE)->get();

            $loanData = DB::table('requisition')
                ->where('request_user', $userId)
                ->where('req_cat', self::EMPLOYEE_LOAN_ID)
                ->where('accessible_status', self::ZERO)
                ->where('status', self::STATUS_ACTIVE)->get();

            $loan = 0;
            $salAdv = 0;
            $dbData = ['accessible_status' => self::STATUS_ACTIVE];
            if (count($loanData) > 0 || count($salAdvData) > 0) {

                if (count($loanData) > 0) {
                    $loan = $loanData[0]->loan_monthly_deduc;
                    self::defaultUpdate('requisition','id',$loanData[0]->id,$dbData);
                }
                if (count($salAdvData) > 0) {
                    $salAdv = $salAdvData[0]->amount;
                    self::defaultUpdate('requisition','id',$salAdvData[0]->id,$dbData);
                }

                $extraDeduc = $salAdv + $loan;
                $salaryDeduc = $salaryData->net_pay - $extraDeduc;
                $newAmount = ($bonusDeduc == self::PAYROLL_BONUS) ? $salaryDeduc + $extraAmount : $salaryDeduc - $extraAmount;

            } else {
                $newAmount = ($bonusDeduc == self::PAYROLL_BONUS) ? $salaryData->net_pay + $extraAmount : $salaryData->net_pay - $extraAmount;

            }


        }


        return $newAmount;
    }

    public static function convertIntToMonth($int){

    }

    public static function getMonthFromDate($date){
        return date('n', strtotime( $date ));

    }

    public static function checkForDeductions($userId,$month,$bonusDeduc){

        $deductData = DB::table('requisition')
            ->where('request_user', $userId)
            ->where('req_cat', self::EMPLOYEE_LOAN_ID)
            ->orWhere('req_cat', self::SALARY_ADVANCE_ID)
            ->where('hr_accessible', self::COMPLETED)
            ->where('status', self::STATUS_ACTIVE)->get();

        $deductLoan = 0;
        $deductSalAdv = 0;
        $deduct = 0;
        if (count($deductData) > 0) {
            foreach($deductData as $data){
                $getMonth = self::getMonthFromDate($data->approval_date);
                if($data->req_cat = self::EMPLOYEE_LOAN_ID){
                    if($getMonth == $month  && $data->approval_status == self::APPROVED){
                        $deductLoan = $data->loan_monthly_deduc;
                    }
                }
                if($data->req_cat = self::SALARY_ADVANCE_ID){
                    if($getMonth == $month && $data->approval_status == self::APPROVED){
                        $deductSalAdv = $data->amount;
                    }
                }

            }
            $deduct = ($bonusDeduc == self::EMPLOYEE_LOAN_ID) ? $deductLoan : $deductSalAdv;

        }
        return $deduct;

    }

    public static function companyInfo(){

        $data = DB::table('company_info')
            ->where('status', self::STATUS_ACTIVE)
            ->where('active_status', self::STATUS_ACTIVE)->first();

        return $data;

    }

    public static function convertAmount($currCurrencyCode,$newCurrencyCode,$amount){
        $curr = 'USD'.$currCurrencyCode;
        $data = DB::table('exchange_rate')
            ->where('status', self::STATUS_ACTIVE)
            ->orderBy('id','DESC')->first();

        $rates = json_decode($data->rates,true);
        $currRate = $rates['quotes'][$curr];
        $dollarAmt = $amount/$currRate;
        $new = 'USD'.$newCurrencyCode;
        $newRate = $rates['quotes'][$new];
        $converted = $dollarAmt*$newRate;
        return round($converted,2);
    }

    public static function chartBalance($accCat,$debit,$credit){

        $debitAccounts = [1,2,3,4,5,13,14,15];
        $creditAccounts = [6,7,8,9,10,11,12];
        $value = '0.00';
        if(in_array($accCat,$debitAccounts)){

            $result = $debit - $credit;
            $value = round($result,2);
        }
        if(in_array($accCat,$creditAccounts)){
            $result = $credit - $debit;
            $value =  round($result,2);
        }
        return $value;

    }

    public static function openingBalanceCreditDebit($accountCategoryId){
        $transaction = 0;
        if(in_array($accountCategoryId,self::CREDIT_OPENING_BALANCE_EQUITY)){
            $transaction = self::DEBIT_TABLE_ID;    //RETURN DEBIT TO THIS ACCOUNT CATEGORY AND CREDIT OPENING BALANCE EQUITY
        }
        if(in_array($accountCategoryId,self::DEBIT_OPENING_BALANCE_EQUITY)){
            $transaction = self::CREDIT_TABLE_ID;   //RETURN CREDIT TO THIS ACCOUNT CATEGORY AND DEBIT OPENING BALANCE EQUITY
        }
        return $transaction;

    }

    public static function detectClosingBookStatus(){
        $data = self::firstRow('closing_books','active_status',Utility::STATUS_ACTIVE);
        $detect = 0;
        if(!empty($data)){
            $detect = 1;
        }
        return $detect;
    }

    public static function checkClosingBook($transactionDate,$password){
        $detect = 0;
        if(empty($transactionDate)){
            $detect = 1;
            return $detect;
        }
        $closing = self::firstRow('closing_books','active_status',Utility::STATUS_ACTIVE);
        if(self::detectClosingBookStatus() != self::STATUS_ACTIVE){
            if(self::standardDate($closing->closing_date) <= $transactionDate){
                if(md5($closing->password) == md5($password)){
                    $detect = 1;
                }else{
                    $detect = 0;
                }
            }else{
                $detect = 1;
            }
        }else{
            $detect = 1;
        }
        return $detect;


    }

    public static function checkCurrencyActiveStatus(){
        $data = self::firstRow('currency','active_status',Utility::STATUS_ACTIVE);
        if(empty($data)){
            return response()->json([
                'message2' => 'Please, navigate to the configuration to activate system default currency',
                'message' => 'currency inactive'
            ]);
        }
    }

    public static function checkDefaultAccountChartCurrency($chart_id){
        $data = self::firstRow('account_chart','id',$chart_id);
        $currency = $data->curr_id;
        if($data->curr_id == ''){
            $currency = self::currencyArrayItem('id');
        }
        return $currency;
    }

    public static function checkFinYearActiveStatus(){
        $checkFinYear = self::firstRow('financial_year','active_status',Utility::STATUS_ACTIVE);
        if(empty($checkFinYear)){
            return response()->json([
                'message2' => 'Please,create and activate a financial year to continue this process',
                'message' => 'warning'
            ]);
        }
    }

    public static function checkExistingLedgerTrans(){
        $checkLedgerTrans = DB::table('company_info')
            ->where('debit_credit', self::DEBIT_TABLE_ID)
            ->orWhere('debit_credit', self::CREDIT_TABLE_ID)
            ->where('status', self::STATUS_ACTIVE)->first();

        if(!empty($checkLedgerTrans)) {
            return response()->json([
                'message2' => 'Currency cannot be changed, the general ledger already has existing transaction linked to this data',
                'message' => 'rejected'
            ]);
        }
    }

    public static function currencyArrayItem($arrayItem){
        if(session('currency')){
            return session('currency')[$arrayItem];
        }else{
            return 'None';
        }
    }

    public static function defaultCurrency(){
        if(session('currency')){
            return '('.session('currency')['code'].')'.session('currency')['symbol'];
        }else{
            return 'None';
        }
    }

    public static function checkArraySimilarity($childArray,$houseArray){
        $detect = false;
        foreach($houseArray as $house){
            foreach($childArray as $child){
                if($house == $child){
                   $detect = true;
                }
            }
        }
        return $detect;
    }

}