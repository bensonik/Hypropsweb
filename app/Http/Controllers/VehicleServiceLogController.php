<?php

namespace App\Http\Controllers;

use App\model\Vehicle;
use App\model\VehicleServiceLog;
use App\Helpers\Utility;
use App\model\VehicleCategory;
use App\model\VehicleServiceType;
use App\model\VehicleWorkshop;
use App\User;
use Auth;
use Monolog\Handler\Curl\Util;
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

class VehicleServiceLogController extends Controller
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
        $mainData = VehicleServiceLog::specialColumnsPage('created_by',Auth::user()->id);
        $serviceType = VehicleServiceType::getAllData();
        $workshop = VehicleWorkshop::getAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_service_log.reload',array('mainData' => $mainData,
                'serviceType' => $serviceType,'workshop' => $workshop))->render());

        }else{
            return view::make('vehicle_service_log.main_view')->with('mainData',$mainData)
                ->with('serviceType',$serviceType)->with('workshop',$workshop);
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
        $validator = Validator::make($request->all(),VehicleServiceLog::$mainRules);
        if($validator->passes()){

            $files = $request->file('attachment');
            $attachment = [];

            if($files != ''){
                foreach($files as $file){

                    $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalName() . $file->getClientOriginalExtension();

                    $file->move(
                        Utility::FILE_URL(), $file_name
                    );
                    //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A TEXT TYPE MYSQL COLUMN
                    $attachment[] =  $file_name;

                }
            }

            $vehicleData = Vehicle::firstRow('id',$request->input('vehicle'));
            $dbDATA = [
                'vehicle_id' => $request->input('vehicle'),
                'mileage_in' => $request->input('mileage_in'),
                'mileage_out' => $request->input('mileage_out'),
                'driver_id' => $vehicleData->driver_id,
                'invoice_reference' => $request->input('invoice_reference'),
                'workshop' => ucfirst($request->input('workshop')),
                'location' => ucfirst($request->input('location')),
                'total_price' => $request->input('total_bill'),
                'service_date' => Utility::standardDate($request->input('service_date')),
                'comment' => ucfirst($request->input('comment')),
                'service_type' => $request->input('service_type'),
                'docs' => json_encode($attachment),
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            VehicleServiceLog::create($dbDATA);

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
        $request = VehicleServiceLog::firstRow('id',$request->input('dataId'));
        $serviceType = VehicleServiceType::getAllData();
        $workshop = VehicleWorkshop::getAllData();
        return view::make('vehicle_service_log.edit_form')->with('edit',$request)
            ->with('serviceType',$serviceType)->with('workshop',$workshop);

    }

    public function attachmentForm(Request $request)
    {
        //
        $request = VehicleServiceLog::firstRow('id',$request->input('dataId'));
        return view::make('vehicle_service_log.attach_form')->with('edit',$request);
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
        $validator = Validator::make($request->all(),VehicleServiceLog::$mainRules);
        if($validator->passes()) {
            $dbDATA = [
                'vehicle_id' => $request->input('vehicle'),
                'mileage_in' => $request->input('mileage_in'),
                'mileage_out' => $request->input('mileage_out'),
                'invoice_reference' => $request->input('invoice_reference'),
                'workshop' => ucfirst($request->input('workshop')),
                'location' => ucfirst($request->input('location')),
                'total_price' => $request->input('total_bill'),
                'service_date' => Utility::standardDate($request->input('service_date')),
                'comment' => ucfirst($request->input('comment')),
                'service_type' => $request->input('service_type'),
                'updated_by' => Auth::user()->id
            ];

            VehicleServiceLog::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function editAttachment(Request $request){
        $files = $request->file('attachment');

        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = VehicleServiceLog::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs);

        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                $file->move(
                    Utility::FILE_URL(), $file_name
                );
                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                array_push($oldAttachment,$file_name);

            }
        }

        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson
        ];
        $save = VehicleServiceLog::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'saved'
        ]);

    }

    public function removeAttachment(Request $request){
        $file_name = $request->input('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = VehicleServiceLog::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs,true);


        //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
        if (($key = array_search($file_name, $oldAttachment)) !== false) {
            $fileUrl = Utility::FILE_URL($file_name);
            unset($oldAttachment[$key]);
            unlink($fileUrl);
        }


        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson
        ];
        $save = VehicleServiceLog::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'File have been removed'
        ]);

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
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

        $delete = VehicleServiceLog::massUpdate('id', $idArray, $dbData);

        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);

        //END FOR VEHICLE Service LOG DELETE

    }

    public function processData($mainData){
        foreach($mainData as $data){
            $vehicle = Vehicle::firstRow('id',$data->vehicle_id);
            $data->vehicle_make = $vehicle->make->make_name;
            $data->vehicle_model = $vehicle->model->model_name;

        }
    }

}
