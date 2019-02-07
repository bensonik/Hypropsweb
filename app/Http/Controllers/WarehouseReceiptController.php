<?php

namespace App\Http\Controllers;

use App\model\WhsePickPutAway;
use App\model\Warehouse;
use Illuminate\Http\Request;
use App\model\WarehouseReceipt;
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

class WarehouseReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = WarehouseReceipt::paginateAllData();
        $warehouse = Warehouse::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('warehouse_receipt.reload',array('mainData' => $mainData,
                'warehouse' => $warehouse))->render());

        }else{
            if(Utility::detectSelected('warehouse_employee',Auth::user()->id))
                return view::make('warehouse_receipt.main_view')->with('mainData',$mainData)->with('warehouse',$warehouse);
            else
                return view::make('errors.403');
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
        $item = $request->input('item');
        $dept = $request->input('department');
        $item_desc = $request->input('item_description');
        $serial_no = $request->input('serial_no');
        $condition = $request->input('item_condition');
        $warranty = $request->input('warranty_expiry');

        $validator = Validator::make($request->all(),WarehouseReceipt::$mainRules);
        if($validator->passes()){

            $dbDATA = [
                'item_id' => $item,
                'dept_id' => $dept,
                'item_desc' => $item_desc,
                'serial_no' => $serial_no,
                'item_condition' => $condition,
                'warranty_expiry_date' => $warranty,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            WarehouseReceipt::create($dbDATA);

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
        $mainData = WarehouseReceipt::paginateAllData();
        $warehouse = Warehouse::getAllData();
        return view::make('warehouse_receipt.edit_form')->with('edit',$mainData)->with('warehouse',$warehouse);

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

            $assignedUser = $request->input('user');
            $assignedDate= $request->input('assigned_date');
            $warehouse = $request->input('warehouse');
            $zone = $request->input('zone');
            $bin = $request->input('bin');
            $vendorShipNo = $request->input('vendor_ship_no');

            $receiptNo = $request->input('receipt_no');
            $postingDate= $request->input('posting_date');
            $itemId = $request->input('item_id');
            $itemDesc = $request->input('item_desc');
            $qty = $request->input('qty');
            $qtyToReceive = $request->input('qty_to_receive');
            $qtyToCrossDock = $request->input('qty_to_cross_dock');
            $qtyReceived= $request->input('qty_received');
            $qtyOutstanding = $request->input('qty_outstanding');
            $unitMeasure = $request->input('unit_measure');
            $dueDate = $request->input('due_date');

            $dbDATA = [
                'assigned_user' => $assignedUser,
                'assigned_date' => $assignedDate,
                'warehouse' => $warehouse,
                'zone' => $zone,
                'bin' => $bin,
                'vendor_ship_no' => $vendorShipNo,
                'receipt_no' => $receiptNo,
                'posting_date' => $postingDate,
                'qty' => $qty,
                'qty_to_receive' => $qtyToReceive,
                'qty_to_cross_dock' => $qtyToCrossDock,
                'qty_received' => $qtyReceived,
                'qty_outstanding' => $qtyOutstanding,
                'unit_measure' => $unitMeasure,
                'due_date' => $dueDate,
                'updated_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            WarehouseReceipt::defaultUpdate('id',$request->input('edit_id'),$dbDATA);

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

    public function searchWarehouseReceipt(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = Inventory::searchWarehouseReceipt($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->id;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        //print_r($search); exit();
        $user_ids = array_unique($obtain_array);
        $mainData =  WarehouseReceipt::massData('id', $user_ids);
        //print_r($obtain_array); die();
        if (count($user_ids) > 0) {

            return view::make('warehouse_receipt.inventory_search')->with('mainData',$mainData);
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
        $delete = WarehouseReceipt::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
