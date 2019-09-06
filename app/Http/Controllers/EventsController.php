<?php

namespace App\Http\Controllers;

use App\model\Events;
use App\model\Department;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class EventsController extends Controller
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
        $mainData = Events::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('events.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('events.main_view')->with('mainData',$mainData);
        }

    }

    public function myCalendar(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Events::specialColumnsPage('user_id',Auth::user()->id);
        $dataArray = [];
        foreach($mainData as $data){
            $dataArray[] = [
                'title' => $data->event_title,
                'start' => $data->start_event,
                'end' => $data->end_event,
                'id' => $data->id,
            ];
        }
        $dataJson = json_encode($dataArray);

            return view::make('events.my_calendar');

    }

    public function loadMyCalendar(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Events::specialColumnsPage('user_id',Auth::user()->id);
        $dataArray = [];
        foreach($mainData as $data){
            $dataArray[] = [
                'title' => $data->event_title,
                'start' => $data->start_event,
                'end' => $data->end_event,
                'id' => $data->id,
            ];
        }
        $dataJson = json_encode($dataArray);

        return $dataJson;

    }

    public function generalCalendar(Request $request)
    {
        //
        //$req = new Request();

        return view::make('events.general_calendar');

    }

    public function loadGeneralCalendar(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Events::specialColumnsPage('event_type',Utility::GENERAL_SCHEDULE);
        $dataArray = [];
        foreach($mainData as $data){
            $dataArray[] = [
                'title' => $data->event_title,
                'start' => $data->start_event,
                'end' => $data->end_event,
                'id' => $data->id,
            ];
        }
        $dataJson = json_encode($dataArray);

        echo $dataJson;

    }

    public function changeCalendar(Request $request)
    {
        //
        $type = $request->input('type');
        $title = $request->input('title');
        $start = $request->input('start');
        $end = $request->input('end');
        $id = $request->input('id');
        if($type == 'create'){
            $dbData = [
                'event_title' => $title.$start,
                'start_event' => $start,
                'end_event' => $end,
                'user_id' => Auth::user()->id,
                'event_type' => Utility::GENERAL_SCHEDULE,
                'status' => Utility::STATUS_ACTIVE,
            ];
            Events::create($dbData);

        }
        if($type == 'edit'){
            $dbData = [
                'event_title' => $title,
                'start_event' => $start,
                'end_event' => $end,
            ];
            Events::defaultUpdate('id',$id,$dbData);

        }
        if($type == 'delete'){
            $dbData = [
                'status' => Utility::STATUS_DELETED,
            ];
            Events::defaultUpdate('id',$id,$dbData);

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
        $validator = Validator::make($request->all(),Events::$mainRules);
        if($validator->passes()){
            $startEvent = Utility::standardDate($request->input('start_date')).' '.$request->input('start_time');
            $endEvent = Utility::standardDate($request->input('end_date')).' '.$request->input('end_time');

            $countData = Events::countData('event_title',$request->input('event_title'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'event_title' => ucfirst($request->input('event_title')),
                    'event_type' => $request->input('schedule_type'),
                    'start_event' => $startEvent,
                    'end_event' => $endEvent,
                    'event_desc' => $request->input('detail'),
                    'user_id' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Events::create($dbDATA);

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
        $request = Events::firstRow('id',$request->input('dataId'));
        return view::make('events.edit_form')->with('edit',$request);

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
        $validator = Validator::make($request->all(),Events::$mainRules);
        if($validator->passes()) {

            $startEvent = Utility::standardDate($request->input('start_date')).' '.$request->input('start_time');
            $endEvent = Utility::standardDate($request->input('end_date')).' '.$request->input('end_time');

            $dbDATA = [
                'event_title' => ucfirst($request->input('event_title')),
                'event_type' => $request->input('event_type'),
                'start_event' => $startEvent,
                'end_event' => $endEvent,
                'event_desc' => $request->input('detail'),
            ];
            $rowData = Events::specialColumns('event_title', $request->input('event_title'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Events::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Events::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = Events::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);


    }

}
