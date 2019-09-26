<?php
/**
 * Created by PhpStorm.
 * User: snweze
 * Date: 3/12/2018
 * Time: 2:56 PM
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

class Approve
{

    public static function sanitizeArray(&$data = []){
        $holdArray = [];
        foreach($data as $da){
            $holdArray[] = $da;
        }
        return $holdArray;
    }

    public static function getArrayValue($dkey,$data = []){
        $hold = '';
        foreach($data as $key => $val){
            if($key == $dkey){
                $hold = $val;
            }
        }
        return $hold;
    }

    public static function getArrayVal($arr=[]){
        $hold = '';
        foreach($arr as $key => $val){
            $hold = $val;
        }
        return $hold;
    }

    public static function processApproval(&$appArr,&$nAppLevels,&$nAppUsers,&$appUsers,&$appLevels,$newLevels,$newUsers,&$approvalUser){
        if(in_array(Auth::user()->id,$nAppUsers)){

            $holdMyLevel = array_search(Auth::user()->id,$appArr);
            foreach($appArr as $key => $var){
                if($holdMyLevel >= $key ){
                    unset($appArr[$key]);

                }else{
                    $newLevels[] = $key;
                    $newUsers[] = $var;
                }
            }
            $nAppLevelsNew = []; $nAppUsersNew = [];
            if(count($appArr) > 0) {
                foreach ($appArr as $key => $val) {
                    $nAppLevelsNew[] = $key;
                    $nAppUsersNew[] = $val;
                }
            }
            $nAppLevels = $nAppLevelsNew; $nAppUsers = $nAppUsersNew;


            $appUsers = json_encode($newUsers); $appLevels = json_encode($newLevels);
        }
        if(count($appArr)>0) {
            $firstApprovalLevel = min($nAppLevels);

            $approvalUser = $appArr[$firstApprovalLevel];
        }else{
            $approvalUser = '';
        }
        $appArr = json_encode($appArr);

    }

    public static function approvalCheck($curr_status,&$appUsers,&$appLevels,&$appJson,&$appStatus,&$compStatus,&$nextUser){

        $appLevelKey = array_search(Auth::user()->id,$appJson);
        $appUserKey = array_search(Auth::user()->id,$appUsers);
        $appLevelKey1 = array_search($appLevelKey,$appLevels);
        $appStatus = $curr_status;
        unset($appJson[$appLevelKey]);
        unset($appUsers[$appUserKey]);
        unset($appLevels[$appLevelKey1]);
        if(count($appLevels) > 0) {
            $leastLevel = min($appLevels);
            $nextUser = $appJson[$leastLevel];
        }
        json_encode($appJson);
        json_encode($appUsers);
        json_encode($appLevels);
        if(count($appLevels) <1 && count($appUsers) <1 && count($appJson) <1) {
            $appStatus = Utility::APPROVED;
        }
        $compStatus = (count($appUsers) <1) ? 1 : 0;

    }

    public static function approveAccess($dbData){
        $appButton = 0;
        foreach($dbData as $app){
            $users = json_decode($app->users,TRUE);
            foreach($users as $var){
                if($var == Auth::user()->id){
                    $appButton = 1;
                }
            }
        }
        return $appButton;
    }


    public static function actionOnModifyingApprovalSys($approvalTable,$requestTable,$approvalId,$userArr,$stageArr,$userJson,$stageJson,$levelToUserPairJson){
        $approvalSys = DB::table($approvalTable)
            ->where('status', Utility::STATUS_ACTIVE)->where('id', $approvalId)->first();   //FETCH EXISTING APPROVAL TO BE MODIFIED FROM DB

        $currentUserArr = json_decode($approvalSys->users,true);    //CONVERT TO ARRAY
        $currentStageArr = json_decode($approvalSys->levels,true);  //CONVERT TO ARRAY
        sort($userArr); sort($stageArr); sort($currentUserArr); sort($currentStageArr); //SORT TO ALLOW MATCHING OF THE ARRAY
        if($userArr == $currentUserArr && $stageArr == $currentStageArr){

        }else{ //UPDATE ALL APPROVAL SYS IN THE REQUISITION TABLE THAT HAVE NOT BEEN APPROVED OR DENIED
            $requestData = DB::table($requestTable)
                ->where('status', Utility::STATUS_ACTIVE)->where('approval_id', $approvalId)
                ->where('complete_status', Utility::ZERO)->get();   //REQUESTS STILL AWAITING APPROVAL

            if(!empty($requestData)){
                $dbData = [
                    'approval_json' => $levelToUserPairJson,
                    'approval_level' => $stageJson,
                    'approval_user' => $userJson,
                    'approved_users' => '',
                ];

                foreach($requestData as $data){
                    Utility::defaultUpdate($requestTable,'id',$data->id,$dbData);
                }
            }

        }

    }

    public static function actionOnChangingApprovalSysForDept($deptApprovalTable,$requestTable,$approvalTable,$deptApprovalId,$newApprovalId,$deptId){
        $deptApproval = DB::table($deptApprovalTable)
            ->where('status', Utility::STATUS_ACTIVE)->where('id', $deptApprovalId)->first();   //FETCH EXISTING APPROVAL TO BE MODIFIED FROM DB

        if($deptApproval->approval_id == $newApprovalId){

        }else{ //UPDATE ALL DEPT APPROVAL SYS IN THE REQUISITION TABLE THAT HAVE NOT BEEN APPROVED OR DENIED
            $requestData = DB::table($requestTable)
                ->where('status', Utility::STATUS_ACTIVE)->where('dept_id', $deptId)
                ->where('complete_status', Utility::ZERO)->get();   //REQUESTS STILL AWAITING APPROVAL

            $approvalSys = DB::table($approvalTable)
                ->where('status', Utility::STATUS_ACTIVE)->where('id', $newApprovalId)->first(); //NEW SELECTED APPROVAL SYSTEM DATA

            if(!empty($requestData)){
                $dbData = [
                    'approval_json' => $approvalSys->level_users,
                    'approval_level' => $approvalSys->levels,
                    'approval_user' => $approvalSys->users,
                    'approved_users' => '',
                ];

                foreach($requestData as $data){
                    Utility::defaultUpdate($requestTable,'id',$data->id,$dbData);
                }
            }

        }

    }

}