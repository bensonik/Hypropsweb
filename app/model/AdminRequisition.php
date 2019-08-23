<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class AdminRequisition extends Model
{
    //
    protected  $table = 'admin_requisition';

    private static function table(){
        return 'admin_requisition';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'request_category' => 'required',
        'request_type' => 'required',
        'request_description' => 'required',
    ];

    public static $feedbackMainRules = [
        'feedback' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id');

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id')->withDefault();

    }

    public function department(){
        return $this->belongsTo('App\model\Department','dept_id','id');

    }

    public function approval(){
        return $this->belongsTo('App\model\AdminApprovalSys','approval_id','id');

    }

    public function requestType(){
        return $this->belongsTo('App\model\RequestType','req_type','id');

    }

    public function requestCat(){
        return $this->belongsTo('App\model\AdminCategory','req_cat','id');

    }

    public function project(){
        return $this->belongsTo('App\model\Project','proj_id','id');

    }

    public function requestUser(){
        return $this->belongsTo('App\user','request_user','id');

    }

    public function denyUser(){
        return $this->belongsTo('App\user','deny_user','id');

    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate('15');
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('status', '=','1')->orderBy('id','DESC')->get();

    }

    public static function paginateData($column, $post)
    {
        return Utility::paginateData(self::table(),$column, $post);

    }

    public static function paginateData2($column, $post, $column2, $post2)
    {
        return  Utility::paginateData2(self::table(),$column, $post, $column2, $post2);

    }

    public static function countData($column, $post)
    {
        return Utility::countData(self::table(),$column, $post);

    }

    public static function specialColumns($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPage($column, $post)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumns2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPage2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumnsPageOr2($column, $post, $column2, $post2)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->orWhere($column2, '=',$post2)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function specialColumns3($column, $post, $column2, $post2, $column3, $post3)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPage3($column, $post, $column2, $post2, $column3, $post3)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function massData($column, $post)
    {
        return Utility::massData(self::table(),$column, $post);

    }
    public static function massDataCondition($column, $post, $column2, $post2)
    {
        return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);

    }

    public static function firstRow($column, $post)
    {
        //return Utility::firstRow(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->first();

    }

    public static function firstRow2($table,$column, $post2,$column2, $post)
    {
        return Utility::firstRow2($table,$column, $post2,$column2, $post);

    }

    public static function massUpdate($column, $arrayPost, $arrayDataUpdate=[])
    {
        return Utility::massUpdate(self::table(),$column, $arrayPost, $arrayDataUpdate);

    }

    public static function defaultUpdate($column, $postId, $arrayDataUpdate=[])
    {
        return Utility::defaultUpdate(self::table(),$column, $postId, $arrayDataUpdate);

    }

    ///////////////////////////////

    public static function specialArrayColumnsPageDate($column, $post,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function specialArrayColumnsPageDate2($column, $post, $column2, $post2,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2,$post2)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArrayColumnsPageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2, $post2)->whereIn($column3, $post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArraySingleColumnsPageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->whereIn($column2, $post2)->where($column3, $post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArraySingleColumns1PageDate2($column, $post, $column2, $post2,$dateArray)
    {

        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->where($column2, '=',$post2)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialArraySingleColumns2PageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {

        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
            ->whereIn($column2, $post2)->where($column3, $post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPageDate3($column, $post, $column2, $post2, $column3, $post3,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)->where($column3, '=',$post3)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPageDate($column, $post,$dateArray)
    {
        //Utility::specialColumns(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)->orderBy('id','DESC')->get();

    }

    public static function specialColumnsPageDate2($column, $post, $column2, $post2,$dateArray)
    {
        //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
            ->where($column2, '=',$post2)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();

    }

    public static function paginateAllDataDate($dateArray)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)
            ->where('approval_status', '=',Utility::STATUS_ACTIVE)
            ->where('complete_status', '=',Utility::STATUS_ACTIVE)
            ->whereBetween('created_at',$dateArray)
            ->orderBy('id','DESC')->get();
        //return Utility::paginateAllData(self::table());

    }

}
