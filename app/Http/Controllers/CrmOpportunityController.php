<?php

namespace App\Http\Controllers;

use App\model\CrmActivity;
use App\model\CrmActivityType;
use App\model\CrmNotes;
use App\model\CrmStages;
use Illuminate\Http\Request;
use App\model\CrmOpportunity;
use App\model\SalesTeam;
use App\Helpers\Utility;
use App\User;
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

class CrmOpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = CrmOpportunity::paginateAllData();
        $salesTeam = SalesTeam::getAllData();
        $opportunityStage = CrmStages::getAllData();
        $activityType = CrmActivityType::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('crm_opportunity.reload',array('mainData' => $mainData,
               ))->render());

        }else{
                return view::make('crm_opportunity.main_view')->with('mainData',$mainData)
                    ->with('salesTeam',$salesTeam)->with('opportunityStage',$opportunityStage)
                    ->with('activityType',$activityType);

        }

    }

    public function opportunityItem(Request $request,$id)
    {

        $mainData = CrmOpportunity::firstRow('id',$id);
        $salesTeam = SalesTeam::getAllData();
        $opportunityStage = CrmStages::getAllDataGroupByStage();
        $activityType = CrmActivityType::getAllData();
        $this->sortOpportunityStages($opportunityStage,$mainData);
        //return $opportunityStage;exit();

            return view::make('crm_opportunity.opportunity_item')->with('mainData',$mainData)
                ->with('salesTeam',$salesTeam)->with('opportunityStage',$opportunityStage)
                ->with('activityType',$activityType);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $lead = $request->input('lead');
        $stage = $request->input('opportunity_stage');
        $opportunityName = $request->input('opportunity_name');
        $amount = $request->input('amount');
        $expectedRevenue = $request->input('expected_revenue');
        $closingDate = Utility::standardDate($request->input('closing_date'));
        $salesTeam = $request->input('sales_team');

        $validator = Validator::make($request->all(),CrmOpportunity::$mainRules);
        if($validator->passes()){

            $uid = Utility::generateUID('crm_opportunity');

            $dbDATA = [
                'uid' => $uid,
                'lead_id' => $lead,
                'opportunity_name' => $opportunityName,
                'stage_id' => $stage,
                'sales_team_id' => $salesTeam,
                'amount' => $amount,
                'expected_revenue' => $expectedRevenue,
                'closing_date' => $closingDate,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            CrmOpportunity::create($dbDATA);

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
        $data = CrmOpportunity::firstRow('id',$request->input('dataId'));
        $salesTeam = SalesTeam::getAllData();
        $opportunityStage = CrmStages::getAllData();
        return view::make('crm_opportunity.edit_form')->with('edit',$data)->with('salesTeam',$salesTeam)
            ->with('opportunityStage',$opportunityStage);

    }

    public function fetchPossibility(Request $request)
    {
        //
        $data = CrmStages::firstRow('id',$request->input('dataId'));
        $probability = (empty($data)) ? 0 : $data->probability;
       return $probability;

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
        $mainRules = [];

        $validator = Validator::make($request->all(),$mainRules);
        if($validator->passes()) {

            $lead = $request->input('lead');
            $stage = $request->input('opportunity_stage');
            $opportunityName = $request->input('opportunity_name');
            $amount = $request->input('amount');
            $expectedRevenue = $request->input('expected_revenue');
            $closingDate = Utility::standardDate($request->input('closing_date'));
            $salesTeam = $request->input('sales_team');

            $dbDATA = [
                'lead_id' => $lead,
                'opportunity_name' => $opportunityName,
                'stage_id' => $stage,
                'sales_team_id' => $salesTeam,
                'amount' => $amount,
                'expected_revenue' => $expectedRevenue,
                'closing_date' => $closingDate,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            CrmOpportunity::defaultUpdate('id',$request->input('edit_id'),$dbDATA);

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

    public function searchOpportunity(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = CrmOpportunity::searchData($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }

        $dataIds = array_unique($obtain_array);
        $mainData =  CrmOpportunity::massDataPaginate('uid', $dataIds);
        //print_r($dataIds); die();
        if (count($dataIds) > 0) {

            return view::make('crm_opportunity.search')->with('mainData',$mainData);
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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = CrmOpportunity::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }

    public function sortOpportunityStages($stages,$opportunityData){

        foreach($stages as $data){
            $stageActivity = CrmActivity::specialColumns2('opportunity_id',$opportunityData->id,'stage_id',$data->id);
            $data->stageActivity = $stageActivity;
            $stageNotes = CrmNotes::specialColumns2('opportunity_id',$opportunityData->id,'stage_id',$data->id);
            $data->stageNotes = $stageNotes;

        }
        return $stages;

    }

}
