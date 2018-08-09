<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;
class Warehouse extends Model
{
    //
    protected  $table = 'warehouse';

    private static function table(){
        return 'warehouse';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static $mainRules = [
        'code' => 'required',
        'name' => 'required',
        'address' => 'required',
        'shipment_bin' => 'required',
        'receipt_bin' => 'required',
    ];

    public static $mainRulesEdit = [
        'code' => 'required',
        'name' => 'required',
        'address' => 'required',
        'shipment_bin' => 'required',
        'receipt_bin' => 'required',
    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id');

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id');

    }

    public function def_bin(){
        return $this->belongsTo('App\model\Bin','default_bin_select','id');

    }

    public function receipt_bin(){
        return $this->belongsTo('App\model\Bin','receipt_bin_code','id');

    }

    public function adjust_bin(){
        return $this->belongsTo('App\model\Bin','adjust_bin_code','id');

    }

    public function ship_bin(){
        return $this->belongsTo('App\model\Bin','ship_bin_code','id');

    }

    public function open_shop_floor(){
        return $this->belongsTo('App\model\Bin','open_shop_floor_bin_code','id');

    }

    public function to_prod_bin(){
        return $this->belongsTo('App\model\Bin','to_prod_bin_code','id');

    }

    public function from_prod_bin(){
        return $this->belongsTo('App\model\Bin','from_prod_bin_code','id');

    }

    public function cross_dock(){
        return $this->belongsTo('App\model\Bin','cross_dock_bin_code','id');

    }

    public function to_assembly(){
        return $this->belongsTo('App\model\Bin','to_assembly_bin_code','id');

    }

    public function from_assembly(){
        return $this->belongsTo('App\model\Bin','from_assembly_bin_code','id');

    }

    public function assembly_to_order(){
        return $this->belongsTo('App\model\Bin','assembly_to_order_ship_bin_code','id');

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


}
