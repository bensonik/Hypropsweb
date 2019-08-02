<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectStatusController extends Controller
{
    //
    public function index(Request $request, $id)
    {
        //
        //$req = new Request();
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        return view::make(Utility::authBlade('temp_user','project_status.main_view','issues.main_view_temp'))
            ->with('item',$project);

    }

    public function indexTemp(Request $request, $id)
    {
        //
        //$req = new Request();
        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        return view::make(Utility::authBlade('temp_user','project_status.main_view','issues.main_view_temp'))
            ->with('item',$project);

    }

    public function arrangeStatus($status,$holdArr,$mainArr){

        foreach(Utility::TASK_STATUS as $key => $var){
            if(!empty($holdArr)){
                if($holdArr[$key] == $status){
                    $holdArr[$key][] = $status;
                    $mainArr[$var][] = $status;
                }
            }else{
                $mainArr[$var][] = $status;
                $holdArr[$key][] = $status;
            }
        }
        return $mainArr;
    }

    public function countStatus($statusArr){
        $newArr = [];
        foreach($statusArr as $key => $val){
            $newArr[$key] = count($val);
        }
        return $newArr;
    }

    public function report($project){

        $task = Task::specialColumns('project_id',$project->id);
        $taskList = TaskList::specialColumns('project_id',$project->id);
        $milestone = Milestone::specialColumns('project_id',$project->id);

        $openTask = []; $closedTask = []; $overdueTask = []; $todayTask = []; $taskStatus = [];
        $openMilestone = []; $closedMilestone = []; $overdueMilestone = []; $todayMilestone = []; $milestoneStatus = [];
        $openList = []; $closedList = []; $overdueList = []; $todayList = []; $listStatus = [];

        $statusOpen = [Utility::TASK_STATUS[1],Utility::TASK_STATUS[2],Utility::TASK_STATUS[5]];
        $statusClosed = Utility::TASK_STATUS[3]; $currDate = date('Y-m-d');

        $taskHoldArr = []; $taskMainArr = []; $listHoldArr = []; $listMainArr = []; $milestoneHoldArr = []; $milestoneMainArr = [];

        foreach($task as $val){

            $openTask[] = (in_array($val->task_status,$statusOpen)) ? $val->task_status : '';
            $closedTask[] = ($val->task_status == $statusClosed) ? $val->task_status : '';
            $taskStatus = $this->arrangeStatus($val->task_status,$taskHoldArr,$taskMainArr);
            $overdueTask[] = ($currDate > $val->end_date) ? $val->end_date : '';
            $todayTask[] = ($currDate <= $val->end_date) ? $currDate : '';

        }

        foreach($taskList as $val){

            $openList[] = (in_array($val->list_status,$statusOpen)) ? $val->list_status : '';
            $closedList[] = ($val->list_status == $statusClosed) ? $val->list_status : '';
            $listStatus = $this->arrangeStatus($val->list_status,$listHoldArr,$listMainArr);
            $overdueList[] = ($currDate > $val->end_date) ? $val->end_date : '';
            $todayList[] = ($currDate <= $val->end_date) ? $currDate : '';

        }

        foreach($milestone as $val){

            $openMilestone[] = (in_array($val->milestone_status,$statusOpen)) ? $val->milestone_status : '';
            $closedMilestone[] = ($val->milestone_status == $statusClosed) ? $val->milestone_status : '';
            $milestoneStatus = $this->arrangeStatus($val->milestone_status,$milestoneHoldArr,$milestoneMainArr);
            $overdueMilestone[] = ($currDate > $val->end_date) ? $val->end_date : '';
            $todayMilestone[] = ($currDate <= $val->end_date) ? $currDate : '';

        }

            $project->openTask = count($openTask);
            $project->closedTask = count($closedTask);
            $project->taskStatus = $this->countStatus($taskStatus);
            $project->overdueTask = count($overdueTask);
            $project->todayTask = count($todayTask);
            $project->totalTask = $task->count();

            $project->openList = count($openList);
            $project->closedList = count($closedList);
            $project->listStatus = $this->countStatus($listStatus);
            $project->overdueList = count($overdueList);
            $project->todayList = count($todayList);
            $project->totalList = $taskList->count();

            $project->openMilestone = count($openMilestone);
            $project->closedMilestone = count($closedMilestone);
            $project->milestoneStatus = $this->countStatus($milestoneStatus);
            $project->overdueMilestone = count($overdueMilestone);
            $project->todayMilestone = count($todayMilestone);
            $project->totalList = $milestone->count();


    }


}
