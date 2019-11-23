<?php

namespace App\Http\Controllers;

use App\model\AccountChart;
use App\model\PutAwayTemplate;
use App\model\AccountJournal;
use App\model\InventoryCategory;
use App\model\InventoryBom;
use App\model\Inventory;
use App\model\UnitMeasure;
use App\model\InventoryType;
use App\model\PhysicalInvCount;
use App\Helpers\Utility;
use App\model\TransferOrder;
use App\model\Stock;
use App\model\Warehouse;
use App\model\WarehouseInventory;
use App\model\WarehouseZone;
use App\model\WhsePickPutAway;
use App\model\ZoneBin;
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

class WarehouseInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $warehouse = Warehouse::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('inventory.reload',array('warehouse' => $warehouse))->render());

        }else{
                return view::make('warehouse_inventory.main_view')->with('warehouse',$warehouse);
        }


    }

    public function warehouseZone(Request $request)
    {
        //
        //$req = new Request();
        $mainData = WarehouseZone::specialColumns('warehouse_id',$request->input('dataId'));
        $warehouseId = $request->input('dataId');

        return view::make('warehouse_inventory.zones.reload')->with('mainData',$mainData)->with('warehouseId',$warehouseId);

    }

    public function warehouseZoneBin(Request $request)
    {
        //
        //$req = new Request();
        $mainData = ZoneBin::specialColumns('zone_id',$request->input('dataId'));
        $zoneId = $request->input('dataId');

        return view::make('warehouse_inventory.bins.reload')->with('mainData',$mainData)->with('zoneId',$zoneId);


    }

    public function binContents(Request $request)
    {
        //
        $zone = Zone::firstRow('id',$request->input('dataId'));
        $bin = Bin::getAllData();
        //return $zone; exit();
        return view::make('warehouse.bins.add_form')->with('edit',$zone)->with('bin',$bin);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),WarehouseInventory::$mainRules);
        if($validator->passes()){


            $itemId= json_decode($request->input('item_id'));
            $bomQty = json_decode($request->input('bom_qty'));
            $dbDATA = [];
            if (count($itemId) == count($bomQty)) {

                for ($i = 0; $i < count($itemId); $i++) {

                    $dbDATA = [
                        'item_id' => Utility::checkEmptyArrayItem($itemId,$i,0),
                        'quantity' => Utility::checkEmptyArrayItem($bomQty,$i,'0'),
                        'warehouse_id' => $request->input('warehouse'),
                        'zone_id' => $request->input('zone'),
                        'bin_id' =>$request->input('bin'),
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    WarehouseInventory::create($dbDATA);
                }

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

    public function warehouseInventoryContents(Request $request)
    {
        //
        $warehouse = WarehouseInventory::specialColumns2Qty('warehouse_id',$request->input('dataId'),'qty','1');
        return view::make('inventory.warehouse.items')->with('mainData',$warehouse)->with('itemId',$request->input('dataId'));

    }

    public function searchWarehouseInventoryItems(Request $request)
    {

        $item = $request->input('inventory_item');
        $warehouseIdArr = [];

        //PROCESS SEARCH REQUEST
            $mainData = WarehouseInventory::specialColumnsOneRow('item_id',$item,'warehouse_id');
            if($mainData->count() > 0){
                foreach($mainData as $data){
                    $warehouseIdArr[] = $data->warehouse_id;
                }
            }
            $warehouse = Warehouse::massData('id',$warehouseIdArr);

        //print_r($sourceType.$reportType.$startDate.$endDate);
        return view::make('warehouse_inventory.search_warehouse_inventory_items')->with('mainData',$warehouse)->with('itemId',$item);

    }

    public function searchWarehouseInventory(Request $request)
    {


        $warehouse = $request->input('warehouse');
        $zone = $request->input('zone');
        $bin = $request->input('bin');
        $mainData = [];

        //PROCESS SEARCH REQUEST
        if($warehouse != '') {

            if ($zone != '' && $bin != '') {
                $mainData = WarehouseInventory::specialColumns3('warehouse_id', $warehouse, 'zone_id', $zone, 'bin_id', $bin);
            }
            if ($zone != '' && $bin == '') {
                $mainData = WarehouseInventory::specialColumns2('warehouse_id', $warehouse, 'zone_id', $zone);
            }
            if ($zone == '' && $bin == '') {
                $mainData = WarehouseInventory::specialColumns('warehouse_id', $warehouse);
            }

            //print_r($sourceType.$reportType.$startDate.$endDate);
            return view::make('warehouse_inventory.search_warehouse_inventory')->with('mainData', $mainData);

        }

        return 'Please select a warehouse to continue search';

    }


}
