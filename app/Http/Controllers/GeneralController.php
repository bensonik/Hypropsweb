<?php

namespace App\Http\Controllers;

use App\model\CompetencyFramework;
use App\model\SalaryComponent;
use App\model\SkillCompCat;
use App\model\Inventory;
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

        //FOR COMPETENCY CATEGORY
        if($type == 'search_comp_cat'){
            $pro_qual = [];
            $cat = SkillCompCat::specialColumns2('skill_comp_id',$pickedVal,'dept_id',Auth::user()->dept_id);
            $category = (count($cat) > 0) ? $cat : $pro_qual;
            //print_r($category.'adsofaijofera');exit();
            return view::make('general.selectOptions')->with('optionArray',$category)->with('type',$type);

        }

        //SEARCH_CUSTOMER
        if($type == 'search_customer'){

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
        if($type == 'bom_inv_edit'){
            $currSymbol = session('currency')['symbol'];
            return view::make('general.addMore')->with('num2',$num2)->with('more',$more)->with('currSymbol',$currSymbol)
                ->with('type',$type)->with('add_id',$addButtonId)->with('hide_id',$hideButtonId);
        }
        //END OF ADDING BILL OF MATERIALS


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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
