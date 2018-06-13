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

}