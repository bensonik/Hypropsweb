<?php

namespace App\Http\Controllers;

use App\model\AccountCategory;
use App\model\AccountChart;
use App\model\AccountDetailType;
use App\model\AccountJournal;
use App\model\CompetencyFramework;
use App\model\Currency;
use App\model\PoExtension;
use App\model\PurchaseOrder;
use App\model\SalaryComponent;
use App\model\SkillCompCat;
use App\model\Inventory;
use App\model\UnitMeasure;
use App\model\Warehouse;
use App\model\Tax;
use View;
use Validator;
use Input;
use Hash;
use DB;
use App\User;
use App\model\VendorCustomer;
use App\model\ExchangeRate;
use App\model\Department;
use App\model\Zone;
use App\model\Bin;
use App\model\Position;
use App\model\SkillCompFrame;
use Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

use App\Helpers\Utility;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //FETCH SELECT OPTIONS METHOD
    public function selectOptions(){
        $pickedVal = $_GET['pickedVal'];
        $type = $_GET['type'];

        if($type == 'default_search'){

            $searchId = $_GET['searchId'];
            $hiddenId = $_GET['hiddenId'];
            $listId = $_GET['listId'];

            if($pickedVal != '') {
                $search = User::searchUser($pickedVal);
                $obtain_array = [];

                foreach ($search as $data) {

                    $obtain_array[] = $data->uid;
                }
                $user_ids = array_unique($obtain_array);
                $fetchData = (Auth::user()->id == 3) ? User::massDataMassCondition('uid', $user_ids, 'role', Utility::USER_ROLES_ARRAY)
                    : User::massData('uid', $user_ids);
            }else{

                $fetchData = User::getAllData();
                return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                    ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
            }

            return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
        }

        //SEARCH CUSTOMER
        if($type == 'search_customer'){

            $searchId = $_GET['searchId'];
            $hiddenId = $_GET['hiddenId'];
            $listId = $_GET['listId'];

            if($pickedVal != '') {
                $search = VendorCustomer::searchCustomer($pickedVal);
                $obtain_array = [];

                foreach ($search as $data) {

                    $obtain_array[] = $data->id;
                }
                $user_ids = array_unique($obtain_array);
                $fetchData = VendorCustomer::massData('id', $user_ids);
            }else{

                $fetchData = VendorCustomer::specialColumns('company_type', Utility::CUSTOMER);
                return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                    ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
            }

            return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
        }

        //SEARCH VENDOR
        if($type == 'search_vendor'){

            $searchId = $_GET['searchId'];
            $hiddenId = $_GET['hiddenId'];
            $listId = $_GET['listId'];

            if($pickedVal != '') {
                $search = VendorCustomer::searchVendor($pickedVal);
                $obtain_array = [];

                foreach ($search as $data) {

                    $obtain_array[] = $data->id;
                }
                $user_ids = array_unique($obtain_array);
                $fetchData = VendorCustomer::massData('id', $user_ids);
            }else{

                $fetchData = VendorCustomer::specialColumns('company_type', Utility::VENDOR);
                return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                    ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
            }

            return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
        }

        //SEARCH VENDOR FOR TRANSACTIONS
        if($type == 'search_vendor_transact'){

            $searchId = $_GET['searchId'];
            $hiddenId = $_GET['hiddenId'];
            $listId = $_GET['listId'];
            $overallSumId = $_GET['overallSumId'];

            if($pickedVal != '') {
                $search = VendorCustomer::searchVendor($pickedVal);
                $obtain_array = [];

                foreach ($search as $data) {

                    $obtain_array[] = $data->id;
                }
                $user_ids = array_unique($obtain_array);
                $fetchData = VendorCustomer::massData('id', $user_ids);
            }else{

                $fetchData = VendorCustomer::specialColumns('company_type', Utility::VENDOR);
                return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                    ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type)->with('overallSumId',$overallSumId);
            }

            return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type)->with('overallSumId',$overallSumId);
        }

        //SEARCH INVENTORY
        if($type == 'search_inventory'){

            $searchId = $_GET['searchId'];
            $hiddenId = $_GET['hiddenId'];
            $listId = $_GET['listId'];

            if($pickedVal != '') {
                $search = Inventory::searchInventory($pickedVal);
                $obtain_array = [];

                foreach ($search as $data) {

                    $obtain_array[] = $data->id;
                }
                $user_ids = array_unique($obtain_array);
                $fetchData = Inventory::massData('id', $user_ids);
            }else{

                $fetchData = Inventory::getAllData();
                return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                    ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
            }

            return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
        }

        //SEARCH INVENTORY TRANSACT
        if($type == 'search_inventory_transact'){

            $searchId = $_GET['searchId'];
            $hiddenId = $_GET['hiddenId'];
            $listId = $_GET['listId'];

            $descId = $_GET['descId'];
            $rateId = $_GET['rateId'];
            $unitMId = $_GET['unitMId'];
            $subTotalId = $_GET['subTotalId'];

            $sharedSubTotal = $_GET['sharedSubTotal'];
            $overallSum = $_GET['overallSum'];
            $foreignOverallSum = $_GET['foreignOverallSum'];
            $qtyId = $_GET['qtyId'];
            $vendCustId = $_GET['vendCustId'];
            $postDateId = $_GET['postDateId'];
            $totalTaxId = $_GET['totalTaxId'];

            if($pickedVal != '') {
                $search = Inventory::searchInventory($pickedVal);
                $obtain_array = [];

                foreach ($search as $data) {

                    $obtain_array[] = $data->id;
                }
                $user_ids = array_unique($obtain_array);
                $fetchData = Inventory::massData('id', $user_ids);
            }else{

                $fetchData = Inventory::getAllData();
                return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                    ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type)
                    ->with('descId',$descId)->with('rateId',$rateId)->with('unitMId',$unitMId)->with('subTotalId',$subTotalId)
                    ->with('sharedSubTotal',$sharedSubTotal)->with('overallSum',$overallSum)->with('foreignOverallSum',$foreignOverallSum)
                    ->with('qtyId',$qtyId)->with('vendCustId',$vendCustId)->with('postDateId',$postDateId)->with('totalTaxId',$totalTaxId);
            }

            return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type)
                ->with('descId',$descId)->with('rateId',$rateId)->with('unitMId',$unitMId)->with('subTotalId',$subTotalId)
                ->with('sharedSubTotal',$sharedSubTotal)->with('overallSum',$overallSum)->with('foreignOverallSum',$foreignOverallSum)
                ->with('qtyId',$qtyId)->with('vendCustId',$vendCustId)->with('postDateId',$postDateId)->with('totalTaxId',$totalTaxId);
        }

        //FOR COMPETENCY CATEGORY
        if($type == 'search_comp_cat'){
            $pro_qual = [];
            $cat = SkillCompCat::specialColumns2('skill_comp_id',$pickedVal,'dept_id',Auth::user()->dept_id);
            $category = (count($cat) > 0) ? $cat : $pro_qual;
            //print_r($category.'adsofaijofera');exit();
            return view::make('general.selectOptions')->with('optionArray',$category)->with('type',$type);

        }


        //FOR COMPETENCY FRAMEWORK
        if($type == 'dept_frame_tech'){
            $pro_qual = [];
            $category = SkillCompCat::specialColumns2('skill_comp_id',Utility::TECH_COMP,'dept_id',$pickedVal);
            //print_r(('skill_comp_id'.Utility::TECH_COMP.'dept_id'.$pickedVal));exit();
            return view::make('general.selectOptions')->with('optionArray',$category)->with('type',$type);

        }

        if($type == 'dept_frame_behav'){
            $pro_qual = [];
            $category = SkillCompCat::specialColumns2('skill_comp_id',Utility::BEHAV_COMP,'dept_id',$pickedVal);
            return view::make('general.selectOptions')->with('optionArray',$category)->with('type',$type);

        }

        //FOR SELECTING USERS ACCORDING TO DEPARTMENT
        if($type == 'dept_users'){
            //print_r($pickedVal);exit();
            $optionArray = User::specialColumns('dept_id',$pickedVal);
            return view::make('general.selectOptions')->with('optionArray',$optionArray)->with('type',$type);

        }

        //FOR INDIVIDUAL GOALS
        if($type == 'core_behav_comp'){
            $optionArray = CompetencyFramework::specialColumns4('dept_id',Auth::user()->dept_id,'position_id',Auth::user()->position_id,'comp_category',Utility::BEHAV_COMP,'sub_comp_cat',$pickedVal);
            //print_r($optionArray);exit();
            return view::make('general.selectOptions')->with('optionArray',$optionArray)->with('type',$type);

        }

        if($type == 'core_tech_comp'){
            //print_r('dept_id',Auth::user()->dept_id,'position_id',Auth::user()->position_id,'comp_category',Utility::TECH_COMP,'sub_comp_cat',$pickedVal);exit();
            $optionArray = CompetencyFramework::specialColumns4('dept_id',Auth::user()->dept_id,'position_id',Auth::user()->position_id,'comp_category',Utility::TECH_COMP,'sub_comp_cat',$pickedVal);
            return view::make('general.selectOptions')->with('optionArray',$optionArray)->with('type',$type);

        }
        //END OF INDIVIDUAL GOALS

        //BEGIN OF ACCOUNT CHART
        if($type == 'account_chart'){
            //print_r($pickedVal);exit();
            $optionArray = AccountDetailType::specialColumns('acct_cat_id',$pickedVal);
            return view::make('general.selectOptions')->with('optionArray',$optionArray)->with('type',$type);

        }
        //END OF ACCOUNT CHART

        //SEARCH ACCOUNT CHART
        if($type == 'search_accounts'){

            $searchId = $_GET['searchId'];
            $hiddenId = $_GET['hiddenId'];
            $listId = $_GET['listId'];

            if($pickedVal != '') {
                $search = AccountChart::searchAccount($pickedVal);

                $obtain_array = [];

                foreach ($search as $data) {

                    $obtain_array[] = $data->id;
                }

                $account_ids = array_unique($obtain_array);
                //print_r($account_ids); exit();
                $fetchData =  AccountChart::massDataCondition('id', $account_ids, 'active_status', Utility::STATUS_ACTIVE);
            }else{

                $fetchData = AccountChart::getAllData();
                return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                    ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
            }

            return view::make('general.selectOptions')->with('optionArray',$fetchData)->with('hiddenId',$hiddenId)
                ->with('listId',$listId)->with('searchId',$searchId)->with('type',$type);
        }
        //END OF SEARCH ACCOUNT CHART

        //BEGIN OF GET TAX PERCENTAGE
        if($type == 'get_tax'){
            //print_r($pickedVal);exit();
            $optionArray = Tax::firstRow('id',$pickedVal);
            return $optionArray->sum_percentage;

        }
        //END OF GET TAX PERCENTAGE


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addMore()
    {
        //
        $num1 = $_GET['num'];
        $type = $_GET['type'];
        $addButtonId = $_GET['add_id'];
        $hideButtonId = $_GET['hide_id'];
        $num2 = $num1+1;
        $more = 1000+$num1;

        if($type == 'tax'){
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId);
        }

        if($type == 'salary_struct'){
            $salaryComp = SalaryComponent::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('salaryComp',$salaryComp);
        }

        if($type == 'approval_sys'){
            $users = User::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('users',$users);
        }

        if($type == 'competency_cat'){
            $dept = Department::getAllData();
            $compType = SkillCompFrame::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('dept',$dept)
                ->with('compType',$compType);
        }

        //FOR COMPETENCY FRAMEWORK
        if($type == 'behav_comp'){
            $dept = Department::getAllData();
            $behavCompCat = SkillCompCat::specialColumns('skill_comp_id',Utility::BEHAV_COMP);
            $position = Position::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('dept',$dept)
                ->with('position',$position)->with('behavCompCat',$behavCompCat);
        }

        if($type == 'tech_comp'){
            $dept = Department::getAllData();
            $techCompCat = SkillCompCat::specialColumns('skill_comp_id',Utility::TECH_COMP);
            $position = Position::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('dept',$dept)
                ->with('position',$position)->with('techCompCat',$techCompCat);
        }

        if($type == 'pro_qual'){
            $dept = Department::getAllData();
            $position = Position::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('dept',$dept)
                ->with('position',$position);
        }
        //END OF COMPETENCY FRAMEWORK

        //BEGINNING OF UNIT GOAL
        if($type == 'unit_goal'){
            $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
            $lowerHod = Utility::detectHOD(Auth::user()->id);

            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('hod',$hod)->with('lowerHod',$lowerHod);
        }

        //ENDING OF UNIT GOAL

        //BEGINING OF INDIVIDUAL GOAL
        if($type == 'app_obj_goal'){
            $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
            $lowerHod = Utility::detectHOD(Auth::user()->id);
            $hodId = Utility::appSupervisorId('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
            $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);
            $compFrame = SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::BEHAV_COMP);

            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('hod',$hod)->with('lowerHod',$lowerHod)
                ->with('hodId',$hodId)->with('lowerHodId',$lowerHodId);

        }

        if($type == 'comp_assess'){
            $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
            $lowerHod = Utility::detectHOD(Auth::user()->id);
            $hodId = Utility::appSupervisorId('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
            $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);
            $techComp = SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::COMP_ASSESS);

            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('hod',$hod)->with('lowerHod',$lowerHod)
                ->with('hodId',$hodId)->with('lowerHodId',$lowerHodId)->with('techComp',$techComp);

        }

        if($type == 'behav_comp2'){
            $hod = Utility::appSupervisor('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
            $lowerHod = Utility::detectHOD(Auth::user()->id);
            $hodId = Utility::appSupervisorId('appraisal_supervision',Auth::user()->dept_id,Auth::user()->id);
            $lowerHodId = Utility::detectHODId(Auth::user()->dept_id);
            $compFrame = SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::BEHAV_COMP);

            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('hod',$hod)->with('lowerHod',$lowerHod)
                ->with('hodId',$hodId)->with('behavComp',$compFrame)->with('lowerHodId',$lowerHodId);

        }

        //END OF INDIVIDUAL GOAL

        //START OF IDP
        if($type == 'idp_comp_assess'){

            $techComp = SkillCompCat::specialColumns2('dept_id',Auth::user()->dept_id,'skill_comp_id',Utility::COMP_ASSESS);

            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('type',$type)
                ->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)->with('techComp',$techComp);

        }
        //END OF IDP

        //START OF ADDING ZONE TO WAREHOUSE
        if($type == 'warehouse_zone'){
            $zone = Zone::getAllData();
            return view::make('general.addMore')->with('zone',$zone)->with('num2',$num2)->with('more',$more)
                ->with('type',$type)->with('add_id',$addButtonId)->with('hide_id',$hideButtonId);
        }
        //END OF ADDING ZONE TO WAREHOUSE

        //START OF ADDING BIN TO WAREHOUSE ZONES
        if($type == 'zone_bin'){
            $bin = Bin::getAllData();
            return view::make('general.addMore')->with('bin',$bin)->with('num2',$num2)->with('more',$more)
                ->with('type',$type)->with('add_id',$addButtonId)->with('hide_id',$hideButtonId);
        }
        //END OF ADDING BIN TO WAREHOUSE ZONES

        //START OF ADDING BILL OF MATERIALS
        if($type == 'bom_inv'){
            $currSymbol = session('currency')['symbol'];
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('currSymbol',$currSymbol)
                ->with('type',$type)->with('add_id',$addButtonId)->with('hide_id',$hideButtonId);
        }
        if($type == 'assign_inv'){

            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)
                ->with('type',$type)->with('add_id',$addButtonId)->with('hide_id',$hideButtonId);
        }
        //END OF ADDING BILL OF MATERIALS

        //START OF ADDING PURCHASE ORDER
        if($type == 'po'){
            $warehouse = Warehouse::getAllData();
            $tax = Tax::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)
                ->with('type',$type)->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)
                ->with('warehouse',$warehouse)->with('tax',$tax);
        }
        //END OF ADDING PURCHASE ORDER

        //START OF ADDING ACCOUNTS
        if($type == 'acc'){
            $tax = Tax::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)
                ->with('type',$type)->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)
                ->with('tax',$tax);
        }
        //END OF ADDING ACCOUNTS

        //START OF ADDING PURCHASE ORDER EDIT
        if($type == 'po_edit'){
            $warehouse = Warehouse::getAllData();
            $tax = Tax::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)
                ->with('type',$type)->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)
                ->with('warehouse',$warehouse)->with('tax',$tax);
        }
        //END OF ADDING PURCHASE ORDER

        //START OF ADDING ACCOUNTS EDIT
        if($type == 'acc_edit'){
            $tax = Tax::getAllData();
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)
                ->with('type',$type)->with('add_id',$addButtonId)->with('hide_id',$hideButtonId)
                ->with('tax',$tax);
        }
        //END OF ADDING ACCOUNTS


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_currency(Request $request)
    {
        //
        $currency = $request->input('currency');
        $curr = json_decode($currency);
        //print_r($curr);die();
        if ($curr->success == 1) {

            $realDate = date("Y-m-d H:i:s", $curr->timestamp);
            $checkData = ExchangeRate::countData('date',$realDate);
        $dbData = [
            'rates' => $currency,
            'date' => $realDate,
            'default_curr' => $curr->source,
            'status' => Utility::STATUS_ACTIVE
        ];

        if($checkData > 0){

        }else{
            $create = ExchangeRate::create($dbData);
            return $currency;
        }

        }

    }

    /**
     * Get equivalent exchange rate of default currency
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exchangeRate(Request $request)
    {
        //post_date=' + postDate+'&vendor_id='+vendorVal
        $postDate = $request->input('post_date');
        $searchId = $request->input('search_id');
        $searchData = VendorCustomer::firstRow('id',$searchId);
        $searchCurrency = Currency::firstRow('id',$searchData->currency_id);
        $currency = '('.$searchCurrency->code.')'.$searchCurrency->symbol;
        $exRate = Utility::currencyRates(Utility::currencyArrayItem('code'),$searchCurrency->code,$postDate);

        return response()->json([

            'rate' => $currency.$exRate
        ]);

    }

    /**
     * GET CURRENCY OF CUSTOMER/VENDOR WHEN THEY ARE SELECTED FROM A DROP DOWN
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vendorCustomerCurrency(Request $request)
    {
        //
        $searchId = $request->input('search_id');
        $searchData = VendorCustomer::firstRow('id',$searchId);
        $searchCurrency = Currency::firstRow('id',$searchData->currency_id);
        $currency = '('.$searchCurrency->code.')'.$searchCurrency->symbol;
        $amount = 1;
        $postDate = date('Y-m-d');
        $currAmount = Utility::convertAmountToDate(Utility::currencyArrayItem('code'),$searchCurrency->code,$amount,$postDate);

        return response()->json([
            'billing_address' => $searchData->address,
            'currency' => $currency,
            'rate' => $currency.$currAmount
        ]);

    }

    /**
     * FETCH INVENTORY DETAILS WHEN AN INVENTORY ITEM IS SELECTED.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inventoryDetails(Request $request)
    {
        //
        $searchId = $request->input('search_id');
        $searchData = Inventory::firstRow('id',$searchId);
        $unitMeasure = UnitMeasure::firstRow('id',$searchData->unit_measure);

        $item_desc = ($request->input('bill_invoice_type') == Utility::PURCHASE_DESC) ? $searchData->purchase_desc : $searchData->sales_desc ;
        $item_rate = ($request->input('bill_invoice_type') == Utility::PURCHASE_DESC) ? $searchData->unit_cost : $searchData->unit_price ;
        return response()->json([
            'rate' => $searchData->unit_cost,
            'unit_measure' => $unitMeasure->unit_name,
            'item_desc' => $item_desc
        ]);

    }

    /**
     * CONVERT AMOUNT TO DEFAULT.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function convertToDefault(Request $request)
    {
        //

        $amount = $request->input('amount');
        $vendorCust = $request->input('vendorCust');
        if($vendorCust == ''){
            return $amount;
        }
        $postDate = ($request->input('postDate') == '') ? date("Y-m-d") : $request->input('postDate');
        $data = VendorCustomer::firstRow('id',$vendorCust);
        $dataCurr = $data->currency_id;
        $curr = Currency::firstRow('id',$dataCurr);
        $currAmount = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$amount,$postDate);
        //print_r($curr); exit();
        return response()->json([
            'overall_sum' => $currAmount,
        ]);

    }

    //GET ITEM RATES
    public function getRate(Request $request)
    {
        //
        $searchId = $request->input('itemId');
        $searchData = Inventory::firstRow('id',$searchId);
        return response()->json([
            'rate' => $searchData->unit_cost,
            'itemId' => $searchData->id,
        ]);

    }

        //UPDATE TOTAL SUM,TAX SUM, DISCOUNT SUM AND THEIR DEFAULT CURRENCY
        public function updateSum(Request $request)
        {
            //
            $dataId = $request->input('dataId'); $grandTotal = $request->input('grandTotal');
            $totalTax = $request->input('totalTax'); $totalDiscount = $request->input('totalDiscount');
            $postDate = $request->input('postDate'); $vendorCust = $request->input('vendorCust');

            $data = VendorCustomer::firstRow('id',$vendorCust);
            $dataCurr = $data->currency_id;
            $curr = Currency::firstRow('id',$dataCurr);

            $grandTotalDefaultCurr = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$grandTotal,$postDate);
            $totalTaxDefaultCurr = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$totalTax,$postDate);
            $totalDiscountDefaultCurr = Utility::convertAmountToDate($curr->code,Utility::currencyArrayItem('code'),$totalDiscount,$postDate);

            $dbData = [
                'sum_total' => $grandTotalDefaultCurr,
                'trans_total' => $grandTotal,
                'discount_total' => $totalDiscountDefaultCurr,
                'discount_trans' => $totalDiscount,
                'tax_total' => $totalTaxDefaultCurr,
                'tax_trans' => $totalTax,
            ];

            PoExtension::defaultUpdate('id',$dataId,$dbData);

            return response()->json([
                'message' => $dataId,
                'message2' => json_encode($dbData),
            ]);

        }

}
