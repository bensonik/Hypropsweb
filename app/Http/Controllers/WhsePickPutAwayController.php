<?php

namespace App\Http\Controllers;

use App\model\WhsePickPutAway;
use App\model\Warehouse;
use App\model\Inventory;
use App\model\PurchaseOrder;
use App\model\PoExtension;
use Illuminate\Http\Request;
use App\model\WarehouseReceipt;
use App\model\Zone;
use App\Helpers\Utility;
use App\Helpers\Notify;
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

class WhsePickPutAwayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = WhsePickPutAway::specialColumnsPage('pick_put_status',Utility::ZERO);

        if ($request->ajax()) {
            return \Response::json(view::make('warehouse_pick_put_away.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('warehouse_pick_put_away.main_view')->with('mainData',$mainData);

        }

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
        $mainData = WhsePickPutAway::firstRow('id',$request->input('dataId'));
        $poItems = WhsePickPutAway::specialColumns('po_ext_id',$mainData->po_ext_id);
        $zone = Zone::getAllData();
        return view::make('warehouse_pick_put_away.edit_form')->with('edit',$mainData)->with('zone',$zone)
            ->with('poItems',$poItems);

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

            $warehouseId = $request->input('warehouse');
            $holdEmpty = [];
            for($i=1; $i<= $request->input('count_po'); $i++) {
                if($request->input('zone'.$i) == '' || $request->input('bin'.$i) == '' ){
                    $holdEmpty[] = $i;
                }
            }

            if(count($holdEmpty) >0){
                return response()->json([
                    'message' => 'warning',
                    'message2' =>  'please ensure that all the items to put away have a selected zone and bin'  //json_encode($request->all())  //json_encode($arr)
                ]);
            }

            for($i=1; $i<= $request->input('count_po'); $i++) {
                $dbDATA = [
                    'assigned_user' => $request->input('user'),
                    'assigned_date' => Utility::standardDate($request->input('assigned_date')),
                    'to_whse' => $request->input('warehouse'),
                    'to_zone' => $request->input('zone'.$i),
                    'to_bin' => $request->input('bin'.$i),
                    'qty' => $request->input('qty' . $i),
                    'qty_to_handle' => $request->input('qty_to_handle' . $i),
                    'qty_handled' => $request->input('qty_handled' . $i),
                    'qty_outstanding' => $request->input('qty_outstanding' . $i),
                    'due_date' => Utility::standardDate($request->input('due_date' . $i)),
                    'pick_put_status' => Utility::STATUS_ACTIVE,
                    'updated_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                    WhsePickPutAway::defaultUpdate('id', $request->input('edit_id'.$i), $dbDATA);

            }

            //SEND OUT MAIL TO WAREHOUSE MANAGER IF WAREHOUSE IS NOT EMPTY
            $whseData = Warehouse::firstRow('id',$warehouseId);
            $whseMan = $whseData->whseManager->firstname.' '.$whseData->whseManager->lastname;
            $toMail = $whseData->whseManager->email;

            $messageBody = "Hello $whseMan, some Put-Away(s) were registered a while ago";

            $emailContent = [];
            $emailContent['subject'] = 'Warehouse Put-Away(s)';
            $emailContent['message'] = $messageBody;
            $emailContent['to_mail'] = $toMail;
            Notify::warehouseMail('mail.warehouse', $emailContent,$toMail,'', $emailContent['subject']);


            return response()->json([
                'message' => 'good',
                'message2' =>  'saved'  //json_encode($request->all())  //json_encode($arr)
            ]);


        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function searchWhsePickPutAway(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = WhsePickPutAway::searchWhsePickPutAway($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->assigned_user;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        print_r($search); exit();
        $receipt_ids = array_unique($obtain_array);
        $mainData =  WhsePickPutAway::massDataPaginate('assigned_user', $receipt_ids);
        //print_r($obtain_array); die();
        if (count($receipt_ids) > 0) {

            return view::make('warehouse_pick_put_away.receipt_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function putAway(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $status = $request->input('status');

        $allData = WhsePickPutAway::massData('id',$all_id);
        $updateData = [
            'pick_put_status' => Utility::STATUS_ACTIVE
        ];
        $whseId = [];

        foreach($allData as $data){
            WhsePickPutAway::defaultUpdate('id',$data->id,$updateData);
            $whseId[] = $data->to_whse;
        }

        $whse = array_unique($whseId);
        foreach($whse as $man){

            //SEND OUT MAIL TO WAREHOUSE MANAGER IF WAREHOUSE IS NOT EMPTY
            $whseData = Warehouse::firstRow('id',$man);
            $whseManager = $whseData->whseManager->firstname.' '.$whseData->whseManager->lastname;
            $toMail = $whseData->email;

            $messageBody = "Hello $whseManager, some Put-Away(s) were registered a while ago";

            $emailContent = [];
            $emailContent['subject'] = 'Warehouse Receipt';
            $emailContent['message'] = $messageBody;
            $emailContent['to_mail'] = $toMail;
            Notify::warehouseMail('mail.warehouse', $emailContent,$toMail,'', $emailContent['subject']);

        }

        return response()->json([
            'message' => 'deleted',
            'message2' => count($all_id).' Put-Away(s) has been processed for the selected items'
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
        $delete = WarehouseReceipt::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message' => 'deleted',
            'message2' => 'Data deleted successfully'
        ]);
    }
}

