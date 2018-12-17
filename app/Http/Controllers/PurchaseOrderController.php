<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Helpers\Notify;
use App\model\Currency;
use App\model\Inventory;
use App\model\PoExtension;
use App\model\PurchaseOrder;
use App\model\VendorCustomer;
use App\model\Warehouse;
use App\model\Tax;
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

class PurchaseOrderController extends Controller
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
        $mainData = PoExtension::paginateAllData();
        $warehouse = Warehouse::getAllData();
        $tax = Tax::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('purchase_order.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('purchase_order.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);
        if($validator->passes()){

            $countData = PoExtension::countData('po_number',$request->input('po_number'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry(PO number) already exist, please try another entry'
                ]);

            }else{

                //ITEM VARIABLES
                $invClass = json_decode($request->input('inv_class')); $itemDesc = json_decode($request->input('item_desc'));
                $warehouse = json_decode($request->input('warehouse')); $quantity = json_decode($request->input('quantity'));
                $unitCost = json_decode($request->input('unit_cost')); $unitMeasure = json_decode($request->input('unit_measure'));
                $quantityReserved = json_decode($request->input('quantity_reserved')); $quantityReceived = json_decode($request->input('quantity_received'));
                $planned = json_decode($request->input('planned')); $expected = json_decode($request->input('expected'));
                $promised = json_decode($request->input('promised')); $bOrderNo = json_decode($request->input('b_order_no'));
                $bOrderLineNo = json_decode($request->input('b_order_line_no')); $shipStatus = json_decode($request->input('ship_status'));
                $statusComment = json_decode($request->input('status_comment')); $tax = json_decode($request->input('tax'));
                $taxPerct = json_decode($request->input('tax_perct')); $taxAmount = json_decode($request->input('tax_amount'));
                $discountPerct = json_decode($request->input('discount_perct')); $discountAmount = json_decode($request->input('discount_amount'));
                $subTotal = json_decode($request->input('sub_total'));

                //ACCOUNT VARIABLES
                $accClass = json_decode($request->input('acc_class')); $accDesc = json_decode($request->input('acc_desc'));
                $accRate = json_decode($request->input('acc_rate')); $accTax = json_decode($request->input('acc_tax'));
                $accTaxPerct = json_decode($request->input('acc_tax_perct')); $accTaxAmount = json_decode($request->input('acc_tax_amount'));
                $accDiscountPerct = json_decode($request->input('acc_discount_perct')); $accDiscountAmount = json_decode($request->input('acc_discount_amount'));
                $accSubTotal = json_decode($request->input('acc_sub_total'));

                //GENERAL VARIABLES
                $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
                $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no'); $purchaseOrderNo = $request->input('purchase_order_no');
                $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
                $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
                $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
                $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
                $message = $request->input('message'); $oneTimeDiscount = $request->input('one_time_discount'); $oneTimePerct = $request->input('one_time_perct');
                $oneTimeTaxAmount = $request->input('one_time_tax_amount'); $taxType = $request->input('tax_type');
                $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');

                $vendor = VendorCustomer::firstRow('id',$prefVendor);
                $curr = Currency::firstRow('id',$vendor->currency_id);
                $files = $request->file('file');
                $attachment = [];
                $mailFiles = [];

                if($files != ''){
                    foreach($files as $file){
                        //return$file;
                        $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                        //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                        //array_push($cdn_images,$file_name);
                        $attachment[] =  $file_name;
                        $mailFiles[] = Utility::FILE_URL($file_name);

                    }
                }

                $uid = Utility::generateUID('po_extention');

                $dbDATA = [
                    'po_uid' => $uid,
                    'assigned_user' => $user,
                    'po_number' => $purchaseOrderNo,
                    'vendor_invoice_no' => $vendorInvoiceNo,
                    'sum_total' => $grandTotal,
                    'trans_total' => $grandTotalVendorCurr,
                    'discount_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
                    'discount_trans' => $oneTimeDiscount,
                    'discount_perct' => $oneTimePerct,
                    'discount_type' => $discountType,
                    'tax_total' => Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
                    'tax_trans' => $oneTimeTaxAmount,
                    'tax_perct' => $oneTimeTaxPerct,
                    'tax_type' => $taxType,
                    'message' => $message,
                    'attachment' => $attachment,
                    'default_curr' => Utility::currencyArrayItem('id'),
                    'trans_curr' => $curr->id,
                    'vendor' => $prefVendor,
                    'due_date' => $dueDate,
                    'post_date' => $postingDate,
                    'ship_to_city' => $shipCity,
                    'ship_to_address' => $shipAddress,
                    'ship_to_country' => $shipCountry,
                    'ship_to_contact' => $shipContact,
                    'ship_method' => $shipMethod,
                    'ship_agent' => $shipAgent,
                    'purchase_status' => $shipStatus,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                $accDbData = [
                    'uid' => $uid
                ];
                $poDbData = [
                    'uid' => $uid
                ];

                    //LOOP THROUGH ACCOUNTS
                    if(count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)){
                        for($i=0;$i<count($accClass);$i++){
                            $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass[$i],0);
                            $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc[$i],'');
                            $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($accRate[$i],0);
                            $accDbData['unit_cost'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accRate[$i],0),$postingDate);
                            $accDbData['tax_id'] = Utility::checkEmptyArrayItem($accTax[$i],0);
                            $accDbData['tax_perct'] = Utility::checkEmptyArrayItem($accTaxPerct[$i],0);
                            $accDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($accTaxAmount[$i],0);
                            $accDbData['tax_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accTaxAmount[$i],0),$postingDate);
                            $accDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($accDiscountAmount[$i],0);
                            $accDbData['discount_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accDiscountAmount[$i],0),$postingDate);
                            $accDbData['discount_perct'] = Utility::checkEmptyArrayItem($accDiscountPerct[$i],0);
                            $accDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($accSubTotal[$i],0);
                            $accDbData['extended_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accSubTotal[$i],0),$postingDate);
                            $accDbData['status'] = Utility::STATUS_ACTIVE;

                        }

                    }

                    //LOOP THROUGH ITEMS
                    if(count($invClass) == count($subTotal)){
                        for($i=0;$i<count($accClass);$i++){
                            $binStock = Inventory::firstRow('id',$invClass);
                            $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass[$i],0);
                            $poDbData['bin_stock'] = $binStock->inventory_type;
                            $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity[$i],0);
                            $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc[$i],'');
                            $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost[$i],0);
                            $poDbData['unit_cost'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($unitCost[$i],0),$postingDate);
                            $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax[$i],0);
                            $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct[$i],0);
                            $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount[$i],0);
                            $poDbData['tax_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($taxAmount[$i],0),$postingDate);
                            $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount[$i],0);
                            $poDbData['discount_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($discountAmount[$i],0),$postingDate);
                            $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct[$i],0);
                            $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal[$i],0);
                            $poDbData['extended_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($subTotal[$i],0),$postingDate);

                            $statComHist = [];
                            if(Utility::checkEmptyArrayItem($shipStatus,0) != 0){
                                $statComHist[Utility::checkEmptyArrayItem($shipStatus,0)] = Utility::checkEmptyArrayItem($statusComment,'');

                            }

                            $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved,'');
                            $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived,'');
                            $poDbData['planned_receipt_date'] = Utility::checkEmptyArrayItem($planned,'');
                            $poDbData['promised_receipt_date'] = Utility::checkEmptyArrayItem($promised,'');
                            $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus,'');
                            $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment,'');
                            $poDbData['po_status_comment_history'] = json_encode($statComHist);
                            $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo,'');
                            $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo,'');
                            $poDbData['status'] = Utility::STATUS_ACTIVE;

                        }

                    }
                if(count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)) {
                   $mainPo = PoExtension::create($dbDATA);
                    PurchaseOrder::create($accDbData);
                    PurchaseOrder::create($poDbData);

                    //MOVE FILES TO FOLDER
                    if($files != ''){
                        foreach($files as $file){
                            //return$file;
                            $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                            $file->move(
                                Utility::FILE_URL(), $file_name
                            );
                        }
                    }

                    if($mailOption == Utility::STATUS_ACTIVE){
                        $poId = $mainPo->id;
                        $getPo = PoExtension::firstRow('id',$poId);
                        $getPoData = PurchaseOrder::specialColumns('uid',$getPo->po_uid);

                        $mailContent = [];
                        $mailContent['po']= $getPo;
                        $mailContent['poData'] = $getPoData;
                        $mailContent['attachment'] = $mailFiles;

                        //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                        if($emails != ''){
                            $mailToArray = explode(',',$emails);
                            if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                                foreach($mailToArray as $data) {
                                    Notify::poMail('mail_views.purchase_order', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                                }
                            }
                        }

                    }


                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                }else{

                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'Please ensure that all account selected has a rate'
                    ]);

                }



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
        $dept = Department::firstRow('id',$request->input('dataId'));
        return view::make('purchase_order.edit_form')->with('edit',$dept);

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
        $validator = Validator::make($request->all(),PurchaseOrder::$mainRules);
        if($validator->passes()){

            $countData = PoExtension::countData('po_number',$request->input('po_number'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry(PO number) already exist, please try another entry'
                ]);

            }else{

                //ITEM VARIABLES
                $invClass = json_decode($request->input('inv_class')); $itemDesc = json_decode($request->input('item_desc'));
                $warehouse = json_decode($request->input('warehouse')); $quantity = json_decode($request->input('quantity'));
                $unitCost = json_decode($request->input('unit_cost')); $unitMeasure = json_decode($request->input('unit_measure'));
                $quantityReserved = json_decode($request->input('quantity_reserved')); $quantityReceived = json_decode($request->input('quantity_received'));
                $planned = json_decode($request->input('planned')); $expected = json_decode($request->input('expected'));
                $promised = json_decode($request->input('promised')); $bOrderNo = json_decode($request->input('b_order_no'));
                $bOrderLineNo = json_decode($request->input('b_order_line_no')); $shipStatus = json_decode($request->input('ship_status'));
                $statusComment = json_decode($request->input('status_comment')); $tax = json_decode($request->input('tax'));
                $taxPerct = json_decode($request->input('tax_perct')); $taxAmount = json_decode($request->input('tax_amount'));
                $discountPerct = json_decode($request->input('discount_perct')); $discountAmount = json_decode($request->input('discount_amount'));
                $subTotal = json_decode($request->input('sub_total'));

                //ACCOUNT VARIABLES
                $accClass = json_decode($request->input('acc_class')); $accDesc = json_decode($request->input('acc_desc'));
                $accRate = json_decode($request->input('acc_rate')); $accTax = json_decode($request->input('acc_tax'));
                $accTaxPerct = json_decode($request->input('acc_tax_perct')); $accTaxAmount = json_decode($request->input('acc_tax_amount'));
                $accDiscountPerct = json_decode($request->input('acc_discount_perct')); $accDiscountAmount = json_decode($request->input('acc_discount_amount'));
                $accSubTotal = json_decode($request->input('acc_sub_total'));

                //GENERAL VARIABLES
                $postingDate = $request->input('posting_date'); $prefVendor = $request->input('pref_vendor'); $dueDate = $request->input('due_date');
                $poStatus = $request->input('po_status'); $vendorInvoiceNo = $request->input('vendor_invoice_no'); $purchaseOrderNo = $request->input('purchase_order_no');
                $user = $request->input('user'); $shipCountry = $request->input('ship_country'); $shipCity = $request->input('ship_city');
                $shipContact = $request->input('ship_contact'); $shipAgent = $request->input('ship_agent'); $shipMethod = $request->input('ship_method');
                $shipAddress = $request->input('ship_address'); $grandTotal = $request->input('grand_total'); $grandTotalVendorCurr = $request->input('grand_total_vendor_curr');
                $mailOption = $request->input('mail_option'); $emails = $request->input('emails'); $file = $request->input('file');
                $message = $request->input('message'); $oneTimeDiscount = $request->input('one_time_discount'); $oneTimePerct = $request->input('one_time_perct');
                $oneTimeTaxAmount = $request->input('one_time_tax_amount'); $taxType = $request->input('tax_type');
                $discountType = $request->input('discount_type'); $oneTimeTaxPerct = $request->input('one_time_tax_perct');

                $vendor = VendorCustomer::firstRow('id',$prefVendor);
                $curr = Currency::firstRow('id',$vendor->currency_id);
                $files = $request->file('file');
                $attachment = [];
                $mailFiles = [];

                if($files != ''){
                    foreach($files as $file){
                        //return$file;
                        $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                        //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                        //array_push($cdn_images,$file_name);
                        $attachment[] =  $file_name;
                        $mailFiles[] = Utility::FILE_URL($file_name);

                    }
                }

                $uid = Utility::generateUID('po_extention');

                $dbDATA = [
                    'po_uid' => $uid,
                    'assigned_user' => $user,
                    'po_number' => $purchaseOrderNo,
                    'vendor_invoice_no' => $vendorInvoiceNo,
                    'sum_total' => $grandTotal,
                    'trans_total' => $grandTotalVendorCurr,
                    'discount_total' => Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$oneTimeDiscount,$postingDate),
                    'discount_trans' => $oneTimeDiscount,
                    'discount_perct' => $oneTimePerct,
                    'discount_type' => $discountType,
                    'tax_total' => Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),$oneTimeTaxAmount,$postingDate),
                    'tax_trans' => $oneTimeTaxAmount,
                    'tax_perct' => $oneTimeTaxPerct,
                    'tax_type' => $taxType,
                    'message' => $message,
                    'attachment' => $attachment,
                    'default_curr' => Utility::currencyArrayItem('id'),
                    'trans_curr' => $curr->id,
                    'vendor' => $prefVendor,
                    'due_date' => $dueDate,
                    'post_date' => $postingDate,
                    'ship_to_city' => $shipCity,
                    'ship_to_address' => $shipAddress,
                    'ship_to_country' => $shipCountry,
                    'ship_to_contact' => $shipContact,
                    'ship_method' => $shipMethod,
                    'ship_agent' => $shipAgent,
                    'purchase_status' => $shipStatus,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                $accDbData = [
                    'uid' => $uid
                ];
                $poDbData = [
                    'uid' => $uid
                ];

                //LOOP THROUGH ACCOUNTS
                if(count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)){
                    for($i=0;$i<count($accClass);$i++){
                        $accDbData['account_id'] = Utility::checkEmptyArrayItem($accClass[$i],0);
                        $accDbData['po_desc'] = Utility::checkEmptyArrayItem($accDesc[$i],'');
                        $accDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($accRate[$i],0);
                        $accDbData['unit_cost'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accRate[$i],0),$postingDate);
                        $accDbData['tax_id'] = Utility::checkEmptyArrayItem($accTax[$i],0);
                        $accDbData['tax_perct'] = Utility::checkEmptyArrayItem($accTaxPerct[$i],0);
                        $accDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($accTaxAmount[$i],0);
                        $accDbData['tax_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accTaxAmount[$i],0),$postingDate);
                        $accDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($accDiscountAmount[$i],0);
                        $accDbData['discount_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accDiscountAmount[$i],0),$postingDate);
                        $accDbData['discount_perct'] = Utility::checkEmptyArrayItem($accDiscountPerct[$i],0);
                        $accDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($accSubTotal[$i],0);
                        $accDbData['extended_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($accSubTotal[$i],0),$postingDate);
                        $accDbData['status'] = Utility::STATUS_ACTIVE;

                    }

                }

                //LOOP THROUGH ITEMS
                if(count($invClass) == count($subTotal)){
                    for($i=0;$i<count($accClass);$i++){
                        $binStock = Inventory::firstRow('id',$invClass);
                        $poDbData['item_id'] = Utility::checkEmptyArrayItem($invClass[$i],0);
                        $poDbData['bin_stock'] = $binStock->inventory_type;
                        $poDbData['quantity'] = Utility::checkEmptyArrayItem($quantity[$i],0);
                        $poDbData['po_desc'] = Utility::checkEmptyArrayItem($itemDesc[$i],'');
                        $poDbData['unit_cost_trans'] = Utility::checkEmptyArrayItem($unitCost[$i],0);
                        $poDbData['unit_cost'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($unitCost[$i],0),$postingDate);
                        $poDbData['tax_id'] = Utility::checkEmptyArrayItem($tax[$i],0);
                        $poDbData['tax_perct'] = Utility::checkEmptyArrayItem($taxPerct[$i],0);
                        $poDbData['tax_amount_trans'] = Utility::checkEmptyArrayItem($taxAmount[$i],0);
                        $poDbData['tax_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($taxAmount[$i],0),$postingDate);
                        $poDbData['discount_amount_trans'] = Utility::checkEmptyArrayItem($discountAmount[$i],0);
                        $poDbData['discount_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($discountAmount[$i],0),$postingDate);
                        $poDbData['discount_perct'] = Utility::checkEmptyArrayItem($discountPerct[$i],0);
                        $poDbData['extended_amount_trans'] = Utility::checkEmptyArrayItem($subTotal[$i],0);
                        $poDbData['extended_amount'] = Utility::convertAmountToDate($vendor->code,Utility::currencyArrayItem('code'),Utility::checkEmptyArrayItem($subTotal[$i],0),$postingDate);

                        $statComHist = [];
                        if(Utility::checkEmptyArrayItem($shipStatus,0) != 0){
                            $statComHist[Utility::checkEmptyArrayItem($shipStatus,0)] = Utility::checkEmptyArrayItem($statusComment,'');

                        }

                        $poDbData['reserved_quantity'] = Utility::checkEmptyArrayItem($quantityReserved,'');
                        $poDbData['received_quantity'] = Utility::checkEmptyArrayItem($quantityReceived,'');
                        $poDbData['planned_receipt_date'] = Utility::checkEmptyArrayItem($planned,'');
                        $poDbData['promised_receipt_date'] = Utility::checkEmptyArrayItem($promised,'');
                        $poDbData['po_status'] = Utility::checkEmptyArrayItem($shipStatus,'');
                        $poDbData['po_status_comment'] = Utility::checkEmptyArrayItem($statusComment,'');
                        $poDbData['po_status_comment_history'] = json_encode($statComHist);
                        $poDbData['blanket_order_no'] = Utility::checkEmptyArrayItem($bOrderNo,'');
                        $poDbData['blanket_order_line_no'] = Utility::checkEmptyArrayItem($bOrderLineNo,'');
                        $poDbData['status'] = Utility::STATUS_ACTIVE;

                    }

                }
                if(count($accClass) == count($accRate) && count($accSubTotal) == count($accClass)) {
                    $mainPo = PoExtension::create($dbDATA);
                    PurchaseOrder::create($accDbData);
                    PurchaseOrder::create($poDbData);

                    //MOVE FILES TO FOLDER
                    if($files != ''){
                        foreach($files as $file){
                            //return$file;
                            $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                            $file->move(
                                Utility::FILE_URL(), $file_name
                            );
                        }
                    }

                    if($mailOption == Utility::STATUS_ACTIVE){
                        $poId = $mainPo->id;
                        $getPo = PoExtension::firstRow('id',$poId);
                        $getPoData = PurchaseOrder::specialColumns('uid',$getPo->po_uid);

                        $mailContent = [];
                        $mailContent['po']= $getPo;
                        $mailContent['poData'] = $getPoData;
                        $mailContent['attachment'] = $mailFiles;

                        //CHECK IF MAIL IS EMPTY ELSE CONTINUE TO SEND MAIL
                        if($emails != ''){
                            $mailToArray = explode(',',$emails);
                            if(count($mailToArray) >0){ //SEND MAIL TO ALL INVOLVED IN THE PURCHASE ORDER
                                foreach($mailToArray as $data) {
                                    Notify::poMail('mail_views.purchase_order', $mailContent, $data, Auth::user()->firstname.' '.Auth::user()->lastname, 'Purchase Order');
                                }
                            }
                        }

                    }


                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                }else{

                    return response()->json([
                        'message' => 'warning',
                        'message2' => 'Please ensure that all account selected has a rate'
                    ]);

                }



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
            $rowDataSalary = User::specialColumns('dept_id', $all_id[$i]);
            if(count($rowDataSalary)>0){
                $unused[$i] = $all_id[$i];
            }else{
                $in_use[$i] = $all_id[$i];
            }
        }
        $message = (count($unused) > 0) ? ' and '.count($unused).
            ' tax(es) has been used in another module and cannot be deleted' : '';
        if(count($in_use) > 0){
            $delete = Department::massUpdate('id',$in_use,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($in_use).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($unused).' department(s) has been used in another module and cannot be deleted',
                'message' => 'warning'
            ]);

        }
    }

}
