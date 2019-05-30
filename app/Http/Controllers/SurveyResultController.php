<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\Helpers\Utility;
use App\model\Survey;
use App\model\SurveyAnsCat;
use App\model\SurveyQuest;
use App\model\SurveyQuestAns;
use App\model\SurveyQuestCat;
use App\model\SurveySession;
use App\model\SurveyTempUserAns;
use App\model\SurveyUserAns;
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

class SurveyResultController extends Controller
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
        $mainData = SurveySession::getAllData();

        if ($request->ajax()) {

            return \Response::json(view::make('survey_result.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('survey_result.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),SurveyQuest::$mainRules);
        if($validator->passes()){


            $dbDATAQUEST = [
                'survey_id' => $request->input('survey'),
                'dept_id' => $request->input('department'),
                'cat_id' => $request->input('question_category'),
                'question' => $request->input('question'),
                'text_type' => $request->input('text_type'),
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $saveQuest = SurveyQuest::create($dbDATAQUEST);

            if($request->input('text_type') == '0') {   //DO FOLLOWING IF QUESTION HAVE ANSWER OPTIONS
                for ($i = 0; $i <= 5; $i++) {
                    if ($request->input('answer' . $i) != '') {
                        $dbDATA = [
                            'survey_id' => $request->input('survey'),
                            'dept_id' => $request->input('department'),
                            'quest_id' => $saveQuest->id,
                            'ans_cat_id' => $request->input('answer' . $i),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        SurveyQuestAns::create($dbDATA);
                    }
                }
            }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $validator = Validator::make($request->all(),SurveyQuestAns::$mainRules);
        if($validator->passes()) {

            $countAns = $request->input('countAns');
            $countExtraAns = $request->input('countExtraAns');
            $survey = $request->input('survey');
            $questionId = $request->input('question_id');
            $textType = $request->input('text_type');
            $dept = $request->input('department');

            $dbDATAQUEST = [
                'cat_id' => $request->input('question_category'),
                'question' => $request->input('question'),
                'updated_by' => Auth::user()->id,
            ];
            $saveQuest = SurveyQuest::defaultUpdate('id', $questionId, $dbDATAQUEST);


            if($textType == '0') {

                for ($i = 0; $i <= $countAns; $i++) {   //DO FOLLOWING FOR EXISTING ANSWER OPTIONS
                    if ($request->input('answer' . $i) != '') {
                        $dbDATA = [
                            'ans_cat_id' => $request->input('answer' . $i),
                            'updated_by' => Auth::user()->id,
                        ];
                        SurveyQuestAns::defaultUpdate('id', $request->input('answer_id' . $i), $dbDATA);
                    }else{
                        SurveyQuestAns::destroy($request->input('answer_id' . $i));
                    }
                }

                for ($i = 0; $i <= $countExtraAns; $i++) {   //DO FOLLOWING IF QUESTION HAVE EXTRA ANSWER OPTIONS
                    if ($request->input('new_answer' . $i) != '') {
                        $dbDATANEW = [
                            'survey_id' => $survey,
                            'dept_id' => $dept,
                            'quest_id' => $request->input('question_id'),
                            'ans_cat_id' => $request->input('new_answer' . $i),
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        SurveyQuestAns::create($dbDATANEW);
                    }
                }
            }

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
     * ADD/REMOVE FOR SURVEY DEPARTMENTS the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchSurvey(Request $request)
    {
        //
       $searchResultRules = [

    ];
        $validator = Validator::make($request->all(),$searchResultRules);
        if($validator->passes()) {

            $surveyId = $request->input('survey');
            $sessionId = $request->input('session');
            $participant = $request->input('participant');

            $session = SurveySession::firstRow('id',$sessionId);
            $mainData = Survey::firstRow('id',$session->survey_id);
            if($participant == 'external'){
                $this->processItemDataExt($mainData,$sessionId);
            }else{
                $this->processItemData($mainData,$sessionId);
            }


            return view::make('survey_result.reload')->with('mainData',$mainData)
                ->with('type','data');

        }else{
            $mainData = $validator->errors();
            return view::make('survey_result.reload')->with('mainData',$mainData)->with('type','error');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function processItemData($val,$session){
        $surveyDept = json_decode($val->all_dept,true);
        $questCatArr = [];
        $questCatArr2 = [];
        $ansCatArr = [];

        if(!empty($surveyDept)){
            $fetchDept = Department::massData('id',$surveyDept);
            $fetchDept2 = Department::massData('id',$surveyDept);

            foreach($fetchDept as $dept){

                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$dept->id);
                foreach($deptQuest as $questCat){
                    $questCatArr[] = $questCat->cat_id;
                }

                $questNum = 0;
                $questCatId = array_unique($questCatArr);
                $questionCategory = SurveyQuestCat::massData('id',$questCatId);
                foreach($questionCategory as $catId){

                    $question = SurveyQuest::specialColumnsAsc3('survey_id',$val->id,'cat_id',$catId->id,'dept_id',$dept->id);
                    //LOOP THROUGH QUESTIONS TO GET ANSWERS
                    foreach($question as $quest){

                        $questNum++;

                        $quest->quest_number = $questNum;   //GET THE QUESTION NUMBER FOR DISPLAY
                        //LOOP THROUGH ANSWERS AND CHECK FOR ADDITIONAL ANSWER COLUMNS BASED ON TEXT TYPE
                        $questAns = SurveyQuestAns::specialColumnsAsc('quest_id',$quest->id);


                            if($quest->text_type == 0){
                                $people = Utility::countData3('survey_user_ans','session_id',$session,'quest_id',$quest->id,'dept_id',$dept->id);
                                $quest->countPeople = $people;

                                foreach($questAns as $ans){
                                $countUserAns = Utility::countData3(Utility::authSurveyTable('temp_user'),'ans_id',$ans->id,'session_id',$session,'dept_id',$dept->id);
                                $userAnsPerct = ($people == 0) ? $countUserAns*100 : round(($countUserAns/$people)*100);
                                $ans->userAnsPerct = $userAnsPerct;
                                $ans->countUserAns = $countUserAns;
                                $ans->userAnsRatioToPeople = $countUserAns.'/'.$people;
                                }
                            }else{

                            }

                        $quest->ans = $questAns;    //ADD ANSWERS TO EACH QUESTION

                    }

                    $catId->question = $question;

                }

                $dept->questionCategory = $questionCategory;  //ADD SELECTED PROCESSED QUESTIONS TO EACH DEPARTMENT

            }

            $val->dept = $fetchDept;

            foreach($fetchDept2 as $deptAns){

                $deptQuest =  SurveyQuestAns::specialColumns2('survey_id',$val->id,'dept_id',$deptAns->id);
                foreach($deptQuest as $questCat){
                    $ansCatArr[] = $questCat->ans_cat_id;
                }
                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$deptAns->id);
                foreach($deptQuest as $questCat){
                    $questCatArr[] = $questCat->cat_id;
                }

                $questCatId = array_unique($questCatArr);
                $questionCategory = SurveyQuestCat::massData('id',$questCatId);

                $ansCatId = array_unique($ansCatArr);
                $answerCategory = SurveyAnsCat::massData('id',$ansCatId);
                foreach($questionCategory as $catId){

                    //$question = SurveyQuest::massDataConditionAsc('survey_id',$val->id,'cat_id',$catId->id);
                    //$countQuestCatAns = Utility::countData3(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_cat_id',$catId->id,'dept_id',$deptAns->id);
                    $countQuestCat = Utility::specialColumns3(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_cat_id',$catId->id,'dept_id',$deptAns->id);
                    //$countQuestCatAns = $countQuestCat->count();
                    $quCat = [];
                    $quCatOptionType = [];
                    $quOptionType = [];
                    foreach($countQuestCat as $qu){
                        if($qu->text_type == '0'){
                            $quCatOptionType[] = $qu->quest_id;
                        }
                        if($qu->text_type == '0'){
                            $quOptionType[] = $qu->quest_id;
                        }

                        $quCat[] = $qu->quest_id;
                    }
                    $countQuestCatAns = count($quOptionType);  //COUNT ALL ANSWERS FROM USERS FOR THIS QUESTION CATEGORY WITH OPTION TYPE
                    $questCatNum = array_unique($quCat);    //COUNT NUMBER OF QUESTIONS IN CATEGORY
                    $questCatNumOption = array_unique($quCatOptionType);    //COUNT NUMBER OF QUESTIONS WITH OPTIONS IN CATEGORY

                    $catId->questCatNum = count($questCatNum);
                    $catId->questCatNumOption = count($questCatNumOption);
                    $catId->countQuestCatAns = $countQuestCatAns;

                    //LOOP THROUGH QUESTIONS TO GET ANSWERS
                    foreach($answerCategory as $ansCat){
                        $countQuestCatAnsCat = Utility::countData4(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_cat_id',$catId->id,'dept_id',$deptAns->id,'ans_cat_id',$ansCat->id);

                        $ansCat->ansCatPerct = ($countQuestCatAnsCat == 0) ? 0 : round(($countQuestCatAnsCat/$countQuestCatAns)*100);
                        $ansCat->countQuestCatAnsCat = $countQuestCatAnsCat; //COUNT THE NUMBER OF ANSWER CATEGORY
                    }

                    $catId->answerCategory = $answerCategory;
                }

                $deptAns->questionCategory = $questionCategory;  //ADD SELECTED PROCESSED QUESTION CATEGORIES TO EACH DEPARTMENT
            }
            $val->dept2 = $fetchDept2;

        }else{
            $val->dept = [];
        }
    }

    public function processItemDataExt($val,$session){
        $surveyDept = json_decode($val->all_dept,true);
        $questCatArr = [];
        $questCatArr2 = [];
        $ansCatArr = [];

        if(!empty($surveyDept)){
            $fetchDept = Department::massData('id',$surveyDept);
            $fetchDept2 = Department::massData('id',$surveyDept);

            foreach($fetchDept as $dept){

                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$dept->id);
                foreach($deptQuest as $questCat){
                    $questCatArr[] = $questCat->cat_id;
                }

                $questNum = 0;
                $questCatId = array_unique($questCatArr);
                $questionCategory = SurveyQuestCat::massData('id',$questCatId);
                foreach($questionCategory as $catId){

                    $question = SurveyQuest::massDataConditionAsc('survey_id',$val->id,'cat_id',$catId->id);
                    //LOOP THROUGH QUESTIONS TO GET ANSWERS
                    foreach($question as $quest){
                        $people = Utility::countData3(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_id',$quest->id,'dept_id',$dept->id);

                        $questNum++;
                        $quest->countPeople = $people;
                        $quest->quest_number = $questNum;   //GET THE QUESTION NUMBER FOR DISPLAY
                        //LOOP THROUGH ANSWERS AND CHECK FOR ADDITIONAL ANSWER COLUMNS BASED ON TEXT TYPE
                        $questAns = SurveyQuestAns::specialColumnsAsc('quest_id',$quest->id);

                        foreach($questAns as $ans){
                            if($quest->text_type == 0){
                                $countUserAns = Utility::countData3(Utility::authSurveyTable('temp_user'),'ans_id',$ans->id,'session_id',$session,'dept_id',$dept->id);
                                $userAnsPerct = round(($countUserAns/$people)*100);
                                $ans->userAnsPerct = $userAnsPerct;
                                $ans->countUserAns = $countUserAns;
                                $ans->userAnsRatioToPeople = $countUserAns.'/'.$people;

                            }else{

                            }
                        }
                        $quest->ans = $questAns;    //ADD ANSWERS TO EACH QUESTION

                    }

                    $catId->question = $question;

                }

                $dept->questionCategory = $questionCategory;  //ADD SELECTED PROCESSED QUESTIONS TO EACH DEPARTMENT
            }

            $val->dept = $fetchDept;

            foreach($fetchDept2 as $deptAns){

                $deptQuest =  SurveyQuestAns::specialColumns2('survey_id',$val->id,'dept_id',$deptAns->id);
                foreach($deptQuest as $questCat){
                    $ansCatArr[] = $questCat->ans_cat_id;
                }
                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$dept->id);
                foreach($deptQuest as $questCat){
                    $questCatArr[] = $questCat->cat_id;
                }

                $questCatId = array_unique($questCatArr);
                $questionCategory = SurveyQuestCat::massData('id',$questCatId);

                $ansCatId = array_unique($ansCatArr);
                $answerCategory = SurveyAnsCat::massData('id',$ansCatId);
                foreach($questionCategory as $catId){

                    //$question = SurveyQuest::massDataConditionAsc('survey_id',$val->id,'cat_id',$catId->id);
                    $countQuestCatAns = Utility::countData3(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_cat_id',$catId->id,'dept_id',$dept->id);

                    //LOOP THROUGH QUESTIONS TO GET ANSWERS
                    foreach($answerCategory as $ansCat){
                        $countQuestCatAnsCat = Utility::countData4(Utility::authSurveyTable('temp_user'),'session_id',$session,'quest_cat_id',$catId->id,'dept_id',$dept->id,'ans_cat_id',$ansCat->id);

                        $ansCat->ansCatPerct = round(($countQuestCatAnsCat/$countQuestCatAns)*100);

                    }

                    $catId->answerCategory = $answerCategory;
                }

                $deptAns->questionCategory = $questionCategory;  //ADD SELECTED PROCESSED QUESTION CATEGORIES TO EACH DEPARTMENT
            }
            $val->dept2 = $fetchDept2;

        }else{
            $val->dept = [];
        }
    }

}
