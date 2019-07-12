<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\Helpers\Utility;
use App\model\Test;
use App\model\TestCategory;
use App\model\TestQuest;
use App\model\TestQuestAns;
use App\model\TestSession;
use App\model\TestTempUserAns;
use App\model\TestUserAns;
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

class TestSessionController extends Controller
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
        $mainData = TestSession::paginateAllData();
        $test = Test::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('test_session.reload',array('mainData' => $mainData,
                'test' => $test))->render());

        }else{
            return view::make('test_session.main_view')->with('mainData',$mainData)->with('test',$test);
        }

    }

    public function testList(Request $request)
    {
        //
        //$req = new Request();
        $mainData = TestSession::specialColumns('user_status',Utility::STATUS_ACTIVE);

        return view::make('test_session.list')->with('mainData',$mainData);

    }

    public function testListTemp(Request $request)
    {
        //
        //$req = new Request();
        $mainData = TestSession::specialColumns('temp_user_status',Utility::STATUS_ACTIVE);

        return view::make('test_session.list_temp')->with('mainData',$mainData);

    }

    public function testForm(Request $request, $id, $session)
    {
        //
        //$req = new Request();
        $mainData = Test::firstRow('id',$id);
        $testSession = TestSession::firstRow('id',$session);
        $this->processItemData($mainData,$session);

        return view::make('test_session.test_form')->with('mainData',$mainData)
            ->with('testSession',$testSession);

    }

    public function testFormTemp(Request $request, $id, $session)
    {
        //
        //$req = new Request();
        $mainData = Test::firstRow('id',$id);
        $testSession = TestSession::firstRow('id',$session);
        $this->processItemData($mainData,$session);

        return view::make('test_session.test_form_temp')->with('mainData',$mainData)
            ->with('testSession',$testSession);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),TestSession::$mainRules);
        if($validator->passes()){


            $countData = TestSession::countData('session_name',$request->input('session_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'session_name' => ucfirst($request->input('session_name')),
                    'test_id' => $request->input('test'),
                    'user_status' => $request->input('internal_participant'),
                    'temp_user_status' => $request->input('external_participant'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                TestSession::create($dbDATA);

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


    public function submitTestForm(Request $request){

        $countQuest = $request->input('countQuest');
        $survey = $request->input('survey');
        $session = $request->input('session');
        $dept = $request->input('department');

        $mainRules = [];
        for($k=1;$k<=$countQuest;$k++){
            if ($request->input('text_type' . $k) != '1') {
                $mainRules['answer' . $k] = 'required';
            }
        }

        $validator = Validator::make($request->all(),$mainRules);
        if($validator->passes()) {

            for ($i = 1; $i <= $countQuest; $i++) {   //DO FOLLOWING IF QUESTION HAVE EXTRA ANSWER OPTIONS
                if ($request->input('text_type' . $i) != '1') {
                    $explodeAnswer = explode('|', $request->input('answer' . $i));
                    $ansId = $explodeAnswer[0];
                    $ansCatId = $explodeAnswer[1];
                    $dbDATANEW = [
                        'survey_id' => $survey,
                        'session_id' => $session,
                        'dept_id' => $dept,
                        'quest_id' => $request->input('question' . $i),
                        'text_type' => $request->input('text_type' . $i),
                        'ans_id' => $ansId,
                        'quest_cat_id' => $request->input('question_cat' . $i),
                        'ans_cat_id' => $ansCatId,
                        'user_id' => Utility::checkAuth('temp_user')->id,
                        'created_by' => Utility::checkAuth('temp_user')->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    $create = Utility::createData(Utility::authSurveyTable('temp_user'),$dbDATANEW);
                } else {

                    $dbDATANEW = [
                        'survey_id' => $survey,
                        'session_id' => $session,
                        'dept_id' => $dept,
                        'quest_id' => $request->input('question' . $i),
                        'text_type' => $request->input('text_type' . $i),
                        'text_answer' => $request->input('answer' . $i),
                        'quest_cat_id' => $request->input('question_cat' . $i),
                        'user_id' => Utility::checkAuth('temp_user')->id,
                        'created_by' => Utility::checkAuth('temp_user')->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    $create = Utility::createData(Utility::authSurveyTable('temp_user'),$dbDATANEW);

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $survey = TestSession::firstRow('id',$request->input('dataId'));
        return view::make('test_session.edit_form')->with('edit',$survey);

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
        $validator = Validator::make($request->all(),TestSession::$mainRulesEdit);
        if($validator->passes()) {

            $dbDATA = [
                'session_name' => ucfirst($request->input('session_name')),
                'user_status' => $request->input('internal_participant'),
                'temp_user_status' => $request->input('external_participant'),
                'updated_by' => Auth::user()->id,
            ];
            $rowData = TestSession::specialColumns('session_name', $request->input('session_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    TestSession::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{
                TestSession::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $request = TestUserAns::firstRow('session_id',$all_id[$i]);
            $requestTemp = TestTempUserAns::firstRow('session_id',$all_id[$i]);
            if(empty($request) && empty($requestTemp)){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }


        $message = (count($in_use) > 0) ? ' and '.count($in_use).
            ' test session(s) has been used to conduct a test session and cannot be deleted' : '';

        $delete = TestSession::destroy($unused);

        return response()->json([
            'message2' => 'deleted',
            'message' => count($unused).' data(s) has been deleted'.$message
        ]);


    }

    public function processItemData($val,$session){
        $surveyDept = json_decode($val->all_dept,true);
        if(!empty($surveyDept)){
            $fetchDept = Department::massData('id',$surveyDept);

            foreach($fetchDept as $dept){
                $deptQuest =  SurveyQuest::specialColumnsAsc2('survey_id',$val->id,'dept_id',$dept->id);
                $questCount = $deptQuest->count();
                $surveyAnsTable = Utility::authSurveyTable('temp_user');
                $surveyResult = Utility::countData3($surveyAnsTable,'session_id',$session,'dept_id',$dept->id,'user_id',Utility::checkAuth('temp_user')->id);
                $resultCheck = ($surveyResult >0) ? 1 : 0;
                $questNum = 0;
                //LOOP THROUGH QUESTIONS TO GET ANSWERS AND NUMBER OF ADDITIONAL ANSWER COLUMNS NEEDED
                foreach($deptQuest as $quest){
                    $questNum++;
                    $quest->quest_number = $questNum;   //GET THE QUESTION NUMBER FOR DISPLAY
                    //LOOP THROUGH ANSWERS AND CHECK FOR ADDITIONAL ANSWER COLUMNS BASED ON TEXT TYPE
                    $questAns = SurveyQuestAns::specialColumnsAsc('quest_id',$quest->id);

                    if($quest->text_type == 0){
                        //$countAns = SurveyQuestAns::countData('quest_id', $quest->id);
                        $countAns = $questAns->count();
                        $moreAnsColumnCount = ($countAns > 2) ? 2 : 3;
                        $quest->moreAnsColumnCount = $moreAnsColumnCount;   //ADD TO QUESTION NUMBER OF MORE ANSWER COLUMN OPTIONS
                        $quest->ans = $questAns;    //ADD ANSWERS TO EACH QUESTION
                        $quest->count_ans = $countAns;

                    }else{
                        $quest->ans = '';
                        $quest->moreAnsColumnCount = 0;
                    }
                }
                $dept->resultCheck = $resultCheck;
                $dept->questCount = $questCount;
                $dept->questions = $deptQuest;  //ADD SELECTED PROCESSED QUESTIONS TO EACH DEPARTMENT
            }

            $val->dept = $fetchDept;
        }else{
            $val->dept = '';
        }
    }

}
