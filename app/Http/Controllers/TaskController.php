<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\Inventory;
use Illuminate\Http\Request;
use App\model\AssumpConstraint;
use App\model\BillMethod;
use App\model\ChangeLog;
use App\model\Decision;
use App\model\Deliverable;
use App\model\Issues;
use App\model\LessonsLearnt;
use App\model\Milestone;
use App\model\Project;
use App\model\ProjectDocs;
use App\model\ProjectMemberRequest;
use App\model\ProjectTeam;
use App\Helpers\Utility;
use App\model\Risk;
use App\model\TaskList;
use App\model\Timesheet;
use App\User;
use App\model\Task;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class TaskController extends Controller
{

    function __contstuct(){
        $this->middleware('auth');
        $this->middleware('auth:temp_user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {


        $mainData = Task::specialColumnsPage('project_id',$id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','task.main_view','task.main_view_temp'),array('mainData' => $mainData,
                'project' => project))->render());

        }
        return view::make(Utility::authBlade('temp_user','task.main_view','task.main_view_temp'))->with('mainData',$mainData)->with('item',$project);

    }

    public function index_temp(Request $request,$id)
    {

        $mainData = Task::specialColumnsPage('project_id',$id);
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        if ($request->ajax()) {
            return \Response::json(view::make('task.main_view',array('mainData' => $mainData,
                'project' => project))->render());

        }
        return view::make('task.main_view')->with('mainData',$mainData)->with('item',$project);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $taskTitle = Utility::jsonUrlDecode($request->input('task_title'));
        $user= Utility::jsonUrlDecode($request->input('user_class'));
        $taskDetails = Utility::jsonUrlDecode($request->input('task_details'));
        $taskStatus = Utility::jsonUrlDecode($request->input('task_status'));
        $startDate = Utility::jsonUrlDecode($request->input('start_date'));
        $endDate = Utility::jsonUrlDecode($request->input('end_date'));
        $taskPriority = Utility::jsonUrlDecode($request->input('task_priority'));
        $timePlanned = Utility::jsonUrlDecode($request->input('time_planned'));
        $changeUser = Utility::jsonUrlDecode($request->input('change_user'));
        $projectId = $request->input('project_id');

        /*return response()->json([
            'message' => 'warning',
            'message2' => json_encode($user).'taskTitle='.json_encode($changeUser)
        ]);*/

        if(!empty($taskTitle) && !empty($taskDetails) && !empty($taskStatus) && !empty($startDate) && !empty($endDate)){

            for($i=0;$i<count($taskTitle);$i++) {
                $changeUserTbl = ($changeUser[$i] == '1') ? 'assigned_user' : 'temp_user' ;
                $changeUserDbTbl = ($changeUser[$i] == '1') ? 'users' : 'temp_users' ;
                $dbDATA = [
                    'project_id' => $projectId,
                    'task' => $taskTitle[$i],
                    'task_desc' => $taskDetails[$i],
                    $changeUserTbl => Utility::checkEmptyArrayItem($user,$i,''),
                    'task_status' => $taskStatus[$i],
                    'start_date' => Utility::standardDate($startDate[$i]),
                    'end_date' => Utility::standardDate($endDate[$i]),
                    'task_priority' => Utility::checkEmptyArrayItem($taskPriority,$i,''),
                    'work_hours' => Utility::checkEmptyArrayItem($timePlanned,$i,''),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                Task::create($dbDATA);
                $projDetails = Project::firstRow('id',$projectId);
                if(Utility::checkEmptyArrayItem($taskPriority,$i,'0') != '0'){
                    $userData = Utility::firstRow($changeUserDbTbl,'id',$user[$i]);
                    $userEmail = $userData->email;

                    $mailContent = [];

                    $messageBody = "Hello '.$userData->firstname.', a task ".$taskTitle[$i]." have been
                    assigned to you on the project ".$projDetails->project_name." please visit the portal to view";

                    $mailContent['message'] = $messageBody;
                    Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);

                }


            }

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);


        }else{
            return response()->json([
                'message' => 'warning',
                'message2' => 'Please fill in all required fields, only task priority and time planned are optional'
            ]);
        }


        /* $errors = $validator->errors();
         return response()->json([
             'message2' => 'fail',
             'message' => $errors
         ]);*/


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
        $skill = Task::firstRow('id',$request->input('dataId'));
        return view::make('task.edit_form')->with('edit',$skill);

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

        $validator = Validator::make($request->all(),Task::$mainRules);
        if($validator->passes()) {

            $taskTitle = $request->input('task_title');
            $user= $request->input('user');
            $taskDetails = $request->input('task_details');
            $taskStatus = $request->input('task_status');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $taskPriority = $request->input('task_priority');
            $timePlanned = $request->input('time_planned');
            $changeUser = $request->input('change_user');

            $changeUserTbl = ($changeUser == 1) ? 'assigned_user' : 'temp_user' ;
            $changeUserDbTbl = ($changeUser == 1) ? 'users' : 'temp_users' ;
            $dbDATA = [
                'task' => $taskTitle,
                'task_desc' => $taskDetails,
                $changeUserTbl => $user,
                'task_status' => $taskStatus,
                'start_date' => Utility::standardDate($startDate),
                'end_date' => Utility::standardDate($endDate),
                'work_hours' => $timePlanned,
                'task_priority' => $taskPriority,
                'updated_by' => Auth::user()->id,
            ];


            Task::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = Task::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
