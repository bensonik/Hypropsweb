<?php

namespace App\Http\Controllers;

use App\model\UnitGoalSeries;
use App\model\UnitGoal;
use App\Helpers\Utility;
use App\User;
use Auth;
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

class UnitGoalSeriesController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = UnitGoalSeries::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('unit_goal_series.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('unit_goal_series.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),UnitGoalSeries::$mainRules);
        if($validator->passes()){

            $countData = UnitGoalSeries::countData('goal_name',$request->input('goal_set'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'goal_name' => ucfirst($request->input('goal_set')),
                    'start_date' => ucfirst($request->input('start_date')),
                    'end_date' => ucfirst($request->input('end_date')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                UnitGoalSeries::create($dbDATA);

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $position = UnitGoalSeries::firstRow('id',$request->input('dataId'));
        return view::make('unit_goal_series.edit_form')->with('edit',$position);

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
        $validator = Validator::make($request->all(),UnitGoalSeries::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'goal_name' => ucfirst($request->input('goal_set')),
                'start_date' => ucfirst($request->input('start_date')),
                'end_date' => ucfirst($request->input('end_date')),
                'updated_by' => Auth::user()->id
            ];
            $rowData = UnitGoalSeries::specialColumns('goal_name', $request->input('goal_set'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    UnitGoalSeries::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                UnitGoalSeries::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $in_use = [];
        $unused = [];
        for($i=0;$i<count($all_id);$i++){
            $rowDataSalary = UnitGoal::specialColumns('goal_set_id', $all_id[$i]);
            if(count($rowDataSalary)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' goal set has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = UnitGoalSeries::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'warning',
                'message' => 'The '.count($unused).' goal set has been used in another module and cannot be deleted'
            ]);

        }

    }

}
