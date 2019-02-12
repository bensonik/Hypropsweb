<?php

namespace App\Http\Controllers;

use App\model\WhsePickPutAway;
use App\model\Warehouse;
use App\model\Inventory;
use App\model\PurchaseOrder;
use App\model\PoExtension;
use Illuminate\Http\Request;
use App\model\WarehouseReceipt;
use App\model\WarehouseEmployee;
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

        if ($request->ajax()) {
            return \Response::json(view::make('warehouse_receipt.reload',array('mainData' => $mainData,))->render());

        }else{
                return view::make('warehouse_receipt.main_view')->with('mainData',$mainData);

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
        $mainData = WarehouseReceipt::firstRow('id',$request->input('dataId'));
        $poItems = WarehouseReceipt::specialColumns('po_id',$mainData->poItem->po_id);
        $warehouse = Warehouse::getAllData();
        return view::make('warehouse_receipt.edit_form')->with('edit',$mainData)->with('warehouse',$warehouse)
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

        $validator = Validator::make($request->all(),WarehouseReceipt::$mainRulesEdit);
        if($validator->passes()) {

            $holdEmpty = [];
            for($i=1; $i<= $request->input('count_po'); $i++) {
                if( $request->input('qty_to_receive' . $i) == '' ){
                    $holdEmpty[] = $i;
                }
            }

            if(count($holdEmpty) >0){
                return response()->json([
                    'message' => 'warning',
                    'message2' =>  'please ensure that all the items have quantity to receive'  //json_encode($request->all())  //json_encode($arr)
                ]);
            }

            for($i=1; $i<= $request->input('count_po'); $i++) {
                $dbDATA = [
                    'assigned_user' => $request->input('user'),
                    'assigned_date' => Utility::standardDate($request->input('assigned_date')),
                    'whse_id' => $request->input('warehouse'),
                    'zone_id' => $request->input('zone'),
                    'bin_id' => $request->input('bin'),
                    'vendor_ship_no' => $request->input('vendor_ship_no'),
                    'receipt_no' => $request->input('receipt_no'),
                    'post_date' => Utility::standardDate($request->input('posting_date')),
                    'qty' => $request->input('qty' . $i),
                    'qty_to_receive' => $request->input('qty_to_receive' . $i),
                    'qty_to_cross_dock' => $request->input('qty_to_cross_dock' . $i),
                    'qty_received' => $request->input('qty_received' . $i),
                    'qty_outstanding' => $request->input('qty_outstanding' . $i),
                    'due_date' => Utility::standardDate($request->input('due_date' . $i)),
                    'updated_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                WarehouseReceipt::defaultUpdate('id', $request->input('edit_id'.$i), $dbDATA);

            }
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

    public function searchWarehouseReceipt(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = WarehouseReceipt::searchWarehouseReceipt($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->id;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/
        //print_r($search); exit();
        $receipt_ids = array_unique($obtain_array);
        $mainData =  WarehouseReceipt::massDataPaginate('id', $receipt_ids);
        //print_r($obtain_array); die();
        if (count($receipt_ids) > 0) {

            return view::make('warehouse_receipt.receipt_search')->with('mainData',$mainData);
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
    public function postCreateReceipt(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $status = $request->input('status');

        $createPost = PurchaseOrder::massData('id',$all_id);
        $updateData = [
            'receipt_status' => $status
        ];
        $checkStock = [];
        $noWhse = [];
        if(!empty($createPost)) {
            foreach ($createPost as $data) {

                $poQty = ($data->received_quantity == '') ? $data->qty : $data->received_quantity;

                //PROCESS IF USER IS POSTING RECEIPT
                if ($status == Utility::POST_RECEIPT) {
                    //PROCESS IF ITEM IS IN A WAREHOUSE
                    if ($data->inventory->whse_status == 1) {
                        $receiptBin = Warehouse::where('id',$data->ship_to_whse)->where('status',Utility::STATUS_ACTIVE)->first(['receipt_bin_code']);
                        $checkPo = WarehouseReceipt::firstRow('po_id',$data->id); //CHECK IF ITEM EXIST IN WAREHOUSE RECEIPT

                        $realWhse = (empty($checkPo)) ? $data->ship_to_whse : $checkPo->whse_id;
                        $realZone = (empty($checkPo)) ? '0' : $checkPo->zone_id;
                        $realBin = (empty($checkPo)) ? $receiptBin->receipt_bin_code : $checkPo->bin_id;

                        $qty = (empty($checkPo)) ? $poQty : $checkPo->qty_to_receive;

                        $dbData = [
                            'item_id' => $data->item_id,
                            'po_id' => $data->id,
                            'pick_put_type' => Utility::PUT_AWAY,
                            'to_whse' => $realWhse,
                            'to_zone' => $realZone,
                            'to_bin' => $realBin,
                            'qty' => $qty,
                            'qty_to_handle' => $qty,
                            'qty_handled' => '',
                            'pick_put_status' => Utility::ZERO,
                            'status' => Utility::STATUS_ACTIVE,
                            'created_by' => Auth::user()->id
                        ];

                        $dbDataWhseReceipt = [
                            'status' => Utility::STATUS_DELETED
                        ];

                        $checkData = WhsePickPutAway::firstRow('po_id',$data->id);

                        $updateWhseReceipt = (!empty($checkPo)) ? WarehouseReceipt::defaultUpdate('po_id',$data->id,$dbDataWhseReceipt) : ''; //IF ITEM EXIST REMOVE ITEM

                        if(empty($checkData) ){
                            if($data->ship_to_whse != '' && $data->ship_to_whse != 0){
                                WhsePickPutAway::create($dbData);
                                PurchaseOrder::defaultUpdate('id',$data->id,$updateData);

                                $whseEmployee = WarehouseEmployee::specialColumns('warehouse_id',$data->ship_to_whse);


                                $emailContent1 = [];
                                $emailContent1['subject'] = 'Warehouse Put-Away';

                                if(!empty($whseEmployee)){
                                    foreach($whseEmployee as $user){
                                        $toMail = $user->access_user->email;
                                        $name = $user->access_user->firstname.' '.$user->access_user->lastname;
                                        $messageBody = "Hello $name, a new warehouse receipt was posted a while ago and are ready for put-away";
                                        $emailContent1['message'] = $messageBody;
                                        $emailContent1['to_mail'] = $toMail;

                                        Notify::warehouseMail('mail.warehouse', $emailContent1,$toMail,'', $emailContent1['subject']);


                                    }
                                }

                            }else{
                                $noWhse[] = $data->inventory->item_name;
                            }

                        }

                    }
                    //PROCESS IF ITEM IS NOT IN A WAREHOUSE ITEM BUT A STOCK ITEM
                    if ($data->inventory->whse_status == 0) {
                        $dbData3 = [
                            'item_id' => $data->item_id,
                            'po_id' => $data->id,
                            'qty' => $data->qty,
                            'purchase_date' => $data->post_date,
                            'status' => Utility::STATUS_ACTIVE,
                            'created_by' => Auth::user()->id
                        ];
                        $checkData = Stock::where('po_id',$data->id)->where('status',Utility::STATUS_ACTIVE)->first();
                        if(empty($checkData)){
                            Stock::create($dbData3);
                            PurchaseOrder::defaultUpdate('id',$data->id,$updateData);
                            //UPDATE QUANTITY OF INVENTORY
                            $itemQty = Inventory::where('id',$data->item_id)->where('status',Utility::STATUS_ACTIVE)->first(['qty']);
                            $newQty = $itemQty->qty + $data->quantity;
                            $changeQty = ['qty' => $newQty];
                            Inventory::defaultUpdate('id',$data->item_id,$changeQty);
                        }

                    }
                }   //END OF POST RECEIPT

                if($status == Utility::CREATE_RECEIPT){

                }

            }
        }

        $displayMessage1 = (count($checkStock) >0) ? 'and '.implode(',',$checkStock).
            ' items were stock items and cannot be created for warehouse receipt' : '';

        $displayMessage2 = (count($noWhse) >0) ? ' also '.implode(',',$noWhse).
            ' items have not been assigned to a warehouse,zone and bin and therefore receipt cannot be posted' : '';

        return response()->json([
            'message' => 'deleted',
            'message2' => 'receipt has been processed for the selected items'.$displayMessage1.$displayMessage2
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
