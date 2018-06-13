<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\RequestAccess;
use App\Helpers\Utility;
use App\model\ApprovalSys;
use App\model\Department;
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
class RequestAccessController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = RequestAccess::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('request_access.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('request_access.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),RequestAccess::$mainRules);
        if($validator->passes()){

            $countData = RequestAccess::countData('user_id',$request->input('user'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'user_id' => $request->input('user'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                RequestAccess::create($dbDATA);

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
        $requestAccess = RequestAccess::firstRow('id',$request->input('dataId'));
        return view::make('request_access.edit_form')->with('edit',$requestAccess);

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
        $validator = Validator::make($request->all(),RequestAccess::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'user_id' => $request->input('user'),
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            $rowData = RequestAccess::specialColumns('user_id', $request->input('user'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    RequestAccess::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                RequestAccess::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $delete = RequestAccess::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }


}
