<?php

namespace App\Http\Controllers;

use App\model\Project;
use App\model\ProjectTeam;
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

class ProjectController extends Controller
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
        $mainData = Project::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('project.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('project.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),Project::$mainRules);
        if($validator->passes()){

            $countData = Project::countData('project_name',$request->input('project_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'project_name' => ucfirst($request->input('project_name')),
                    'project_desc' => ucfirst($request->input('project_description')),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                $pro = Project::create($dbDATA);

                $dbDATA2 = [
                    'project_id' => $pro->id,
                    'user_id' => Auth::user()->id,
                    'project_access' => Utility::STATUS_ACTIVE,
                    'team_lead' => 0,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                ProjectTeam::create($dbDATA2);


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
        $dept = Project::firstRow('id',$request->input('dataId'));
        return view::make('project.edit_form')->with('edit',$dept);

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
        $validator = Validator::make($request->all(),Project::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'project_name' => ucfirst($request->input('project_name')),
                'project_desc' => $request->input('project_description'),
                'updated_by' => Auth::user()->id
            ];
            $rowData = Project::specialColumns('project_name', $request->input('project_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Project::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Project::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = Project::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

}
