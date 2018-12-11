<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\PoExtension;
use App\model\PurchaseOrder;
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


                $dbDATA = [
                    'dept_name' => ucfirst($request->input('department_name')),
                    'status' => Utility::STATUS_ACTIVE
                ];
                Department::create($dbDATA);

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
        $validator = Validator::make($request->all(),Department::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'dept_name' => ucfirst($request->input('department_name')),
                'dept_hod' => $request->input('department_hod')
            ];
            $rowData = Department::specialColumns('dept_name', $request->input('department_name'));

            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Department::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Department::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
