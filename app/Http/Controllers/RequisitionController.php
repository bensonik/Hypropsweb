<?php

namespace App\Http\Controllers;

use App\model\AccountCategory;
use App\model\RequestAccess;
use App\model\RequestType;
use App\model\LoanRates;
use App\model\Requisition;
use App\model\RequestCategory;
use App\model\ProjectTeam;
use App\model\Department;
use App\model\ApprovalSys;
use App\model\ApprovalDept;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\Helpers\Approve;
use App\model\SalaryStructure;
use App\User;
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

class RequisitionController extends Controller
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
        $appButton = '';
        $appUsers = [];
        $approveSys = ApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = Requisition::specialColumnsPageOr2('request_user',Auth::user()->id,'created_by',Auth::user()->id);
        $this->filterData($mainData);
        $reqCat = RequestCategory::specialColumnsOr2('dept_id',Auth::user()->dept_id,'general',Utility::DETECT);
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $currSymbol = session('currency')['symbol'];

        $requestAccess = RequestAccess::getAllData();
        $access = Utility::detectRequestAccess($requestAccess);


        if ($request->ajax()) {
            return \Response::json(view::make('requisition.reload',array('mainData' => $mainData,
                'reqType' => $requestType,'project' => $project, 'reqCat' => $reqCat, 'appAccess' => $approveAccess,
                'curr_symbol' => $currSymbol,'access' => $access))->render());

        }else{
            return view::make('requisition.main_view')->with('mainData',$mainData)->with('reqType',$requestType)
                ->with('project',$project)->with('reqCat',$reqCat)->with('appAccess',$approveAccess)
                ->with('curr_symbol',$currSymbol)->with('access',$access);
        }

    }

    public function loanRequests(Request $request)
    {
        //
        //$req = new Request();
        $appButton = '';
        $appUsers = [];
        $approveSys = ApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? Requisition::specialColumnsPage('hr_accessible',Utility::LOAN_REQUEST) : Requisition::specialColumnsPage2('hr_accessible',Utility::LOAN_REQUEST,'request_user',Auth::user()->id);
        $this->filterData($mainData);
        $reqCat = RequestCategory::specialColumnsOr2('dept_id',Auth::user()->dept_id,'general',Utility::DETECT);
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $currSymbol = session('currency')['symbol'];

        $requestAccess = RequestAccess::getAllData();
        $access = Utility::detectRequestAccess($requestAccess);


        if ($request->ajax()) {
            return \Response::json(view::make('requisition.loan_request_reload',array('mainData' => $mainData,
                'reqType' => $requestType,'project' => $project, 'reqCat' => $reqCat, 'appAccess' => $approveAccess,
                'curr_symbol' => $currSymbol,'access' => $access))->render());

        }else{
            return view::make('requisition.loan_request')->with('mainData',$mainData)->with('reqType',$requestType)
                ->with('project',$project)->with('reqCat',$reqCat)->with('appAccess',$approveAccess)
                ->with('curr_symbol',$currSymbol)->with('access',$access);
        }

    }

    public function salaryAdvanceRequests(Request $request)
    {
        //
        //$req = new Request();
        $appButton = '';
        $appUsers = [];
        $approveSys = ApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? Requisition::specialColumnsPage('hr_accessible',Utility::SALARY_ADVANCE_REQUEST) : Requisition::specialColumnsPage2('hr_accessible',Utility::SALARY_ADVANCE_REQUEST,'request_user',Auth::user()->id);
        $this->filterData($mainData);
        $reqCat = RequestCategory::specialColumnsOr2('dept_id',Auth::user()->dept_id,'general',Utility::DETECT);
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $currSymbol = session('currency')['symbol'];

        $requestAccess = RequestAccess::getAllData();
        $access = Utility::detectRequestAccess($requestAccess);


        if ($request->ajax()) {
            return \Response::json(view::make('requisition.salary_adv_request_reload',array('mainData' => $mainData,
                'reqType' => $requestType,'project' => $project, 'reqCat' => $reqCat, 'appAccess' => $approveAccess,
                'curr_symbol' => $currSymbol,'access' => $access))->render());

        }else{
            return view::make('requisition.salary_adv_request')->with('mainData',$mainData)->with('reqType',$requestType)
                ->with('project',$project)->with('reqCat',$reqCat)->with('appAccess',$approveAccess)
                ->with('curr_symbol',$currSymbol)->with('access',$access);
        }

    }

    public function myRequests(Request $request)
    {
        //
        //$req = new Request();
        $approveSys = ApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);
        $mainData = Requisition::paginateAllData();
        $this->filterData($mainData);
        $reqCat = RequestCategory::getAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $currSymbol = session('currency')['symbol'];

        if ($request->ajax()) {
            return \Response::json(view::make('requisition.request_reload',array('mainData' => $mainData,
                'reqType' => $requestType,'project' => $project, 'reqCat' => $reqCat, 'appAccess' => $approveAccess,
                'curr_symbol' => $currSymbol))->render());

        }else{
            return view::make('requisition.request')->with('mainData',$mainData)->with('reqType',$requestType)
                ->with('project',$project)->with('reqCat',$reqCat)->with('appAccess',$approveAccess)
                ->with('curr_symbol',$currSymbol);
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),Requisition::$mainRules);
        if($validator->passes()){

            $files = $request->file('attachment');
            //return $files;
            $attachment = [];
            //print_r($files);

            //PROCESS LOAN REQUEST
            $hrAccessible = Utility::ZERO;
            $accessibleStatus = Utility::ZERO;
            $loanId = Utility::ZERO;
            $loanBalance = Utility::ZERO;
            $loanMonthlyDeduction = Utility::ZERO;
            if($request->input('request_category') == Utility::EMPLOYEE_LOAN_ID){
                $rowData = LoanRates::specialColumns('loan_status', Utility::STATUS_ACTIVE);
                if(count($rowData) > 0) {
                    $hrAccessible = Utility::LOAN_REQUEST;
                    $accessibleStatus = Utility::STATUS_ACTIVE;
                    $loanId = $rowData[0]->id;
                    $loanBalance = Utility::loanMonthlyDeduction($request->input('amount'),$rowData[0]->interest_rate)*12;
                    $loanMonthlyDeduction = Utility::loanMonthlyDeduction($request->input('amount'),$rowData[0]->interest_rate);
                }else{
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Please navigate to config, find and setup the loan interest rate to continue request'
                    ]);
                }

            }
            //END OF LOAN REQUEST PROCESS

            //PROCESS SALARY ADVANCE

            if($request->input('request_category') == Utility::SALARY_ADVANCE_ID){
                $hrAccessible = Utility::SALARY_ADVANCE_REQUEST;
                $salary = SalaryStructure::firstRow('id',Auth::user()->salary_id);
                if($request->input('amount') >= $salary->net_pay){
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Please enter an amount less than your salary'
                    ]);
                }

            }



            if($files != ''){
                foreach($files as $file){
                    //return$file;
                    $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();
                    $real_images[] = $file_name;
                    $file->move(
                        Utility::FILE_URL(), $file_name
                    );
                        //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                        //array_push($cdn_images,$file_name);
                        $attachment[] =  $file_name;

                }
            }

            $attachJson = json_encode($attachment);
            $defaultCurr = session('currency')['id'];
            $uid = Utility::generateUID('users');
            $userInput = $request->input('user');
            $user = User::firstRow('id',$request->input('user'));
            $reqUser = ($request->input('user') == null) ? Auth::user()->id : $user->id ;
            $reqDept = ($request->input('user') == null) ? Auth::user()->dept_id : $user->dept_id ;

            $approveDept = ApprovalDept::firstRow('dept',$reqDept);
            $approveSys = ApprovalSys::firstRow('id',$approveDept->approval_id);
            $acctCat = RequestCategory::firstRow('id',$request->input('request_category'));
            $project = $request->input('project');
            $approvalArray = json_decode($approveSys->level_users,TRUE);
            $approvalLevel = json_decode($approveSys->levels,TRUE);
            $approvalUsers = json_decode($approveSys->users,TRUE);
            $approveUsers = $approveSys->users; $approveLevels = $approveSys->levels;
            $holdUser = '';
            $appLevel = [];
            $appUser = [];

            Approve::processApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser);
            /*return response()->json([
                            'message' => 'good',
                            'message2' => json_encode($approvalUsers)
                        ]);*/
            if($holdUser != '') {
                $firstUser = User::firstRow('id', $holdUser);
                $email = $firstUser->email;
                $fullName = $firstUser->firstname . ' ' . $firstUser->lastname;
                $senderName = ($userInput == null) ? Auth::user()->firstname . ' ' . Auth::user()->lastname : $user->firstname . ' ' . $user->lastname;
                $subject = 'A New Fund Request from ' . $senderName;
                /*$emailContent = [
                    'user_id' => $reqUser,
                    'type' => 'next_approval',
                    'name' => $fullName,
                    'sender_name' => $senderName,
                    'desc' => $request->input('description'),
                    'amount' => $request->input('amount')
                ];*/
                $emailContent = new \stdClass();
                $emailContent->user_id = $reqUser;
                $emailContent->type = 'next_approval';
                $emailContent->name = $fullName;
                $emailContent->sender_name = $senderName;
                $emailContent->desc = $request->input('description');
                $emailContent->amount = $request->input('amount');
                Notify::sendMail('requisition.send_request',$emailContent,$email,$fullName,$subject);
            }

            if($request->input('request_type') == Utility::USUAL_REQUEST_TYPE ){
                $project = 0;
            }
            $user = User::firstRow('id',$reqUser);
            $dept_id = ($userInput == null) ? Auth::user()->dept_id : $user->dept_id;
            $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;

            $dbDATA = [
                  'acct_cat' => $acctCat->acct_id,
                  'req_cat' => $request->input('request_category'),
                  'req_type' => $request->input('request_type'),
                  'proj_id' => $project,
                  'req_desc' => $request->input('request_description'),
                  'amount' => $request->input('amount'),
                  'hr_accessible' => $hrAccessible,
                  'accessible_status' => $accessibleStatus,
                  'loan_id' => $loanId,
                  'loan_balance' => $loanBalance,
                  'loan_monthly_deduc' => $loanMonthlyDeduction,
                  'curr_id' => $defaultCurr,
                  'default_curr' => $defaultCurr,
                  'invoice_no' => $uid,
                  'dept_id' => $dept_id,
                  'approval_json' => $approvalArray,
                  'approval_level' => $approveLevels,
                  'approval_user' => $approveUsers,
                  'approval_id' => $approveSys->id,
                  'approval_status' => $reqStatus,
                  'complete_status' => $reqStatus,
                  'request_user' => $reqUser,
                  'dept_req_user' => $dept_id,
                  'attachment' => $attachJson,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                $requisition = Requisition::create($dbDATA);


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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $request = Requisition::firstRow('id',$request->input('dataId'));
        $reqCat = RequestCategory::getAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        return view::make('requisition.edit_form')->with('edit',$request)->with('reqType',$requestType)
            ->with('reqCat',$reqCat)->with('project',$project);

    }

    public function attachmentForm(Request $request)
    {
        //
        $request = Requisition::firstRow('id',$request->input('dataId'));
        $reqCat = RequestCategory::getAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        return view::make('requisition.attach_form')->with('edit',$request)->with('reqType',$requestType)
            ->with('reqCat',$reqCat)->with('project',$project);

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
        $validator = Validator::make($request->all(),Requisition::$mainRules);
        if($validator->passes()) {


            $acctCat = AccountCategory::firstRow('id',$request->input('request_category'));
            $project = $request->input('project');
            if($request->input('request_type') == Utility::USUAL_REQUEST_TYPE ){
                $project = 0;
            }

            $previousArray = [];
            $previousData = Requisition::firstRow('id',$request->input('edit_id'));
            $approvalSys = ApprovalSys::firstRow('id',$previousData->approval_id);

            //PROCESS LOAN REQUEST
            $hrAccessible = Utility::ZERO;
            $accessibleStatus = Utility::ZERO;
            $loanId = Utility::ZERO;
            $loanBalance = Utility::ZERO;
            $loanMonthlyDeduction = Utility::ZERO;
            if($request->input('request_category') == Utility::EMPLOYEE_LOAN_ID){
                $rowData = LoanRates::specialColumns('loan_status', Utility::STATUS_ACTIVE);
                if(count($rowData) > 0) {
                    $hrAccessible = Utility::LOAN_REQUEST;
                    $accessibleStatus = Utility::STATUS_ACTIVE;
                    $loanId = $rowData[0]->id;
                    $loanBalance = Utility::loanMonthlyDeduction($request->input('amount'),$rowData[0]->interest_rate)*12;
                    $loanMonthlyDeduction = Utility::loanMonthlyDeduction($request->input('amount'),$rowData[0]->interest_rate);
                }else{
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Please navigate to config, find and setup the loan interest rate to continue request'
                    ]);
                }

            }
            //END OF LOAN REQUEST PROCESS

            //PROCESS SALARY ADVANCE
            if($request->input('request_category') == Utility::SALARY_ADVANCE_ID){
                $hrAccessible = Utility::SALARY_ADVANCE_REQUEST;
                $salary = SalaryStructure::firstRow('id',Auth::user()->salary_id);
                if($request->input('amount') >= $salary->net_pay){
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Please enter an amount less than your salary'
                    ]);
                }
            }


            $dbDATA = [
                'acct_cat' => $acctCat->id,
                'req_cat' => $request->input('request_category'),
                'req_type' => $request->input('request_type'),
                'proj_id' => $project,
                'req_desc' => $request->input('request_description'),
                'amount' => $request->input('amount'),
                'hr_accessible' => $hrAccessible,
                'accessible_status' => $accessibleStatus,
                'loan_id' => $loanId,
                'loan_balance' => $loanBalance,
                'loan_monthly_deduc' => $loanMonthlyDeduction,
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            $previousEntry = '';
            if($previousData->approved_users != '') {

                if ($previousData->deny_user != 0) {

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Request has been denied and can\'t be edited'
                    ]);

                } else {

                //CHECK IF REQUEST IS LOAN AND WHETHER MONTHLY DEDUCTION HAS STARTED
                $totalPayBackAmount = $previousData->loan_monthly_deduc*12;
                if($request->input('request_category') == Utility::EMPLOYEE_LOAN_ID && $totalPayBackAmount != $previousData->loan_balance ) {

                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'Monthly deduction has occurred on this loan request and can\'t be modified'
                    ]);

                }else{

                   //CHECK IF SALARY ADVANCE HAS BEEN CLEARED BY REQUEST USER
                   if($request->input('request_category') == Utility::SALARY_ADVANCE_ID && $previousData->accessible_status == Utility::ZERO){

                       return response()->json([
                           'message' => 'warning',
                           'message2' => 'This salary advance request has been cleared and cannot be modified'
                       ]);

                   }

                    $previousArray['request_type'] = $previousData->requestType->request_type;
                    $previousArray['request_category'] = $previousData->requestCat->request_name;
                    if ($previousData->proj_id != 0) {
                        $previousArray['project'] = $previousData->project->project_name;
                    }
                    $previousArray['request_desc'] = $previousData->req_desc;
                    $previousArray['amount'] = $previousData->amount;

                    $previousEntry = json_encode($previousArray);

                        $approvalArray = json_decode($approvalSys->level_users,TRUE);
                        $approvalLevel = json_decode($approvalSys->levels,TRUE);
                        $approvalUsers = json_decode($approvalSys->users,TRUE);
                        $approveUsers = $approvalSys->users; $approveLevels = $approvalSys->levels;
                        $appLevel = [];
                        $appUser = [];
                        $holdUser = '';

                        Approve::processApproval($approvalArray,$approvalLevel,$approvalUsers,$approveUsers,$approveLevels,$appLevel,$appUser,$holdUser);
                        $reqStatus = ($holdUser == '') ? Utility::APPROVED : Utility::PROCESSING;
                    $dbDATA = [
                        'acct_cat' => $acctCat->id,
                        'req_cat' => $request->input('request_category'),
                        'req_type' => $request->input('request_type'),
                        'proj_id' => $project,
                        'req_desc' => $request->input('request_description'),
                        'amount' => $request->input('amount'),
                        'hr_accessible' => $hrAccessible,
                        'accessible_status' => $accessibleStatus,
                        'loan_id' => $loanId,
                        'loan_balance' => $loanBalance,
                        'loan_monthly_deduc' => $loanMonthlyDeduction,
                        'edit_request' => $previousEntry,
                        'approved_users' => '',
                        'approval_json' => $approvalArray,
                        'approval_level' => $approveLevels,
                        'approval_user' => $approveUsers,
                        'approval_status' => $reqStatus,
                        'views' => '',
                        'complete_status' => $reqStatus,
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                        if($holdUser != '') {
                            $reqUser = $previousData->request_user;
                            $user = User::firstRow('id', $reqUser);
                            $firstUser = User::firstRow('id', $holdUser);
                            $email = $firstUser->email;
                            $fullName = $previousData->requestUser->firstname . ' ' . $previousData->requestUser->lastname;
                            $senderName = $user->firstname . ' ' . $user->lastname;
                            $subject = 'A New Fund Request from ' . $senderName;
                            /*$emailContent = [
                                'user_id' => $previousData->request_user,
                                'type' => 'next_approval',
                                'name' => $fullName,
                                'sender_name' => $senderName,
                                'desc' => $request->input('description'),
                                'amount' => $request->input('amount')
                            ];*/
                            $emailContent = new \stdClass();
                            $emailContent->user_id = $previousData->request_user;
                            $emailContent->type = 'next_approval';
                            $emailContent->name = $fullName;
                            $emailContent->sender_name = $senderName;
                            $emailContent->desc = $request->input('description');
                            $emailContent->amount = $request->input('amount');


                            Notify::sendMail('requisition.send_request', $emailContent, $email, $fullName, $subject);
                        }
                 }   //END OF CHECK IF LOAN REQUEST AND MONTHLY DEDUCTION HAS STARTED

                }   //END OF CHECK FOR IF DENIED

            } //END OF CHECK FOR REQUEST APPROVAL


                Requisition::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function editAttachment(Request $request){
        $files = $request->file('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = Requisition::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->attachment);

        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                $file->move(
                    Utility::FILE_URL(), $file_name
                );
                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                array_push($oldAttachment,$file_name);

            }
        }

        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'attachment' => $attachJson
        ];
        $save = Requisition::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'saved'
        ]);

    }

    public function removeAttachment(Request $request){
        $file_name = $request->input('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = Requisition::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->attachment,true);


                //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
        if (($key = array_search($file_name, $oldAttachment)) !== false) {
            $fileUrl = Utility::FILE_URL($file_name);
            unset($oldAttachment[$key]);
            unlink($fileUrl);
        }


        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'attachment' => $attachJson
        ];
        $save = Requisition::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'File have been removed'
        ]);

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
    }

    /**
     * Approve the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval(Request $request)
    {
        //

        $dbData = [];

        $in_use = [];
        $unused = [];
        $idArray = json_decode($request->input('all_data'));


        for($i=0;$i<count($idArray);$i++){
            $rowDataRequest = Requisition::firstRow('id', $idArray[$i]);
            if($rowDataRequest->complete_status == 1 || $rowDataRequest->deny_reason !=''){
                $unused[$i] = $idArray[$i];
            }else{
                $in_use[$i] = $idArray[$i];
            }
        }

        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' has been approved/denied and cannot be changed' : '';
        if(count($in_use) > 0){

            if($request->input('status') == 1){
                foreach($in_use as $reqId){
                    $proRequisition = Requisition::firstRow('id', $reqId);
                    $approvalUsers = json_decode($proRequisition->approval_user,true);
                    $approvalLevels = json_decode($proRequisition->approval_level,true);
                    $approvalJson = json_decode($proRequisition->approval_json,true);
                    $nextUser = '';
                    $appStatus = '';
                    $compStatus = '';
                    Approve::approvalCheck($proRequisition->approval_status,$approvalUsers,$approvalLevels,$approvalJson,$appStatus,$compStatus,$nextUser);
                    $approvedUsers = ($proRequisition->approved_users == '') ? [] : json_decode($proRequisition->approved_users,true);
                    $approvedUsers[] = Auth::user()->id;
                    $appUsersJson = json_encode($approvedUsers);
                    $dbData = [
                        'approval_status' => $appStatus,
                        'approval_user' => json_encode($approvalUsers),
                        'approved_users' => $appUsersJson,
                        'approval_level' => json_encode($approvalLevels),
                        'approval_json' => json_encode($approvalJson),
                        'complete_status' => $compStatus
                    ];

                    $update = Requisition::defaultUpdate('id',$reqId,$dbData);

                    $mailContentApproved = new \stdClass();
                    $mailContentApproved->type = 'request_approved';
                    $mailContentApproved->desc = $proRequisition->req_desc;
                    $mailContentApproved->amount = $proRequisition->amount;
                    $mailContentApproved->sender = $proRequisition->requestUser->firstname . ' ' . $proRequisition->requestUser->lastname;

                    if(count($approvalLevels) > 0) {
                        $firstUser = User::firstRow('id', $nextUser);
                        $email = $firstUser->email;
                        $fullName = $firstUser->firstname . ' ' . $firstUser->lastname;
                        $senderName = $proRequisition->requestUser->firstname . ' ' . $proRequisition->requestUser->lastname;
                        $subject = 'A New Fund Request from ' . $senderName;
                        /*$emailContent = [
                            'type' => 'next_approval',
                            'name' => $fullName,
                            'user_id' => $proRequisition->request_user,
                            'sender' => $senderName,
                            'desc' => $proRequisition->req_desc,
                            'amount' => $proRequisition->amount
                        ];*/
                        $emailContent = new \stdClass();
                        $emailContent->type = 'next_approval';
                        $emailContent->name = $fullName;
                        $emailContent->user_id = $proRequisition->request_user;
                        $emailContent->sender = $senderName;
                        $emailContent->desc = $proRequisition->req_desc;
                        $emailContent->amount = $proRequisition->amount;

                        /*$mailContentApproved = [
                            'type' => 'request_approved',
                            'desc' => $proRequisition->req_desc,
                            'amount' => $proRequisition->amount,
                            'sender' => $proRequisition->requestUser->firstname . ' ' . $proRequisition->requestUser->lastname
                        ];*/

                        if($update){
                            Notify::sendMail('requisition.send_request', $emailContent, $email, $fullName, $subject);
                        }

                    }


                    if($compStatus == 1){
                        Notify::sendMail('requisition.send_request', $mailContentApproved, $proRequisition->requestUser->email, $proRequisition->requestUser->firstname, 'Request Approval');
                        if($proRequisition->request_user != $proRequisition->created_by) {  //IF REQUEST WAS MADE FOR ANOTHER USER NOTIFY WHO MADE THE REQUEST
                            Notify::sendMail('requisition.send_request', $mailContentApproved, $proRequisition->user_c->email, $proRequisition->user_c->firstname, 'Request Approval');
                        }

                        $accountants = User::specialColumns('role',Utility::ACCOUNTANTS);
                        if(count($accountants) >0){ //SEND MAIL TO ALL IN ACCOUNTS DEPARTMENT ABOUT THIS APPROVAL
                            foreach($accountants as $data) {
                                Notify::sendMail('requisition.send_request', $mailContentApproved, $data->email, $proRequisition->requestUser->firstname, 'Request Approval');
                            }
                        }

                    }   //END OF WHEN STATUS IS COMPLETE

                }   //END OF LOOP FOR APPROVING PROCESS


            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' request(s) has been approved '.$message
            ]);

        }else{  //DENY USER CODES BEGINS HERE

                $denyReason = $request->input('input_text');

                foreach($in_use as $reqId) {
                    $proRequisition = Requisition::firstRow('id', $reqId);
                    $dbData = [
                        'deny_user' => Auth::user()->id,
                        'deny_reason' => $denyReason,
                        'approval_status' => Utility::DENIED,
                        'complete_status' => Utility::COMPLETED,
                    ];
                    /*$mailContentDenied = [
                        'type' => 'request_denied',
                        'desc' => $proRequisition->req_desc,
                        'amount' => $proRequisition->amount
                    ];*/
                    $mailContentDenied = new \stdClass();
                    $mailContentDenied->type = 'request_denied';
                    $mailContentDenied->desc = $proRequisition->req_desc;
                    $mailContentDenied->amount = $proRequisition->amount;

                    $update = Requisition::defaultUpdate('id',$reqId,$dbData);

                    if($update) {
                        Notify::sendMail('requisition.send_request', $mailContentDenied, $proRequisition->requestUser->email, $proRequisition->requestUser->firstname, 'Request Denied');
                        if ($proRequisition->request_user != $proRequisition->created_by) { //IF REQUEST WAS MADE FOR ANOTHER USER NOTIFY WHO MADE THE REQUEST
                            Notify::sendMail('requisition.send_request', $mailContentDenied, $proRequisition->user_c->email, $proRequisition->user_c->firstname, 'Request Denied');
                        }
                    }
                }

        }   //END OF DENY CODES

        }else{
            return  response()->json([
                'message2' => 'warning',
                'message' => 'The '.count($unused).' requests has been approved/denied and status cannot be changed'
            ]);

        }



       //END FOR NORMAL USER DELETE

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
        $idArray = json_decode($request->input('all_data'));

        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        if (in_array(Auth::user()->role,Utility::TOP_USERS) ) {

        $delete = Requisition::massUpdate('id', $idArray, $dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

        }else{  //END OF REMOVAL FOR THE TOP USERS

            $in_use = [];
            $unused = [];
            for($i=0;$i<count($idArray);$i++){
                $rowDataRequest = Requisition::firstRow('id', $idArray[$i]);
                if($rowDataRequest->complete_status == 1 || $rowDataRequest->deny_reason !=''){
                    $unused[$i] = $idArray[$i];
                }else{
                    $in_use[$i] = $idArray[$i];
                }
            }
            $message = (count($unused) > 0) ? ' and '.count($unused).
                ' has been approved/denied and cannot be deleted' : '';
            if(count($in_use) > 0){
                $delete = Requisition::massUpdate('id',$in_use,$dbData);

                return response()->json([
                    'message2' => 'deleted',
                    'message' => count($in_use).' data(s) has been deleted '.$message
                ]);

            }else{
                return  response()->json([
                    'message2' => 'warning',
                    'message' => 'The '.count($unused).' has been approved/denied and cannot be deleted'
                ]);

            }



        }   //END FOR NORMAL USER DELETE

    }

    public function filterData($dbData){
        foreach($dbData as $data) {
            if ($data->approved_users != '') {
                $jsonUsers = json_decode($data->approved_users,true);
                if (count($jsonUsers) > 0) {
                    $data->approved_by = User::massData('id', $jsonUsers);
                }
            }

            if ($data->complete_status != 1){
                $jsonLevels = json_decode($data->approval_level, true);
            $jsonApp = json_decode($data->approval_json, true);
            $leastLevel = min($jsonLevels);
            $nextUser = $jsonApp[$leastLevel];
                $data->next_user = $nextUser.Auth::user()->id;
            if ($nextUser == Auth::user()->id) {
                $data->approval_view = 1;
            } else {
                $data->approval_view = 0;
            }
         }

        }
        return $dbData;
    }   //END OF FILTERING DATA

}
