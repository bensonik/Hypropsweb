<?php

namespace App\model;

use App\Helpers\Utility;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    protected  $table = 'stock';

    private static function table(){
        return 'stock';
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public static $mainRules = [
        'email1' => 'email',
        'logo' => 'sometimes|image|mimes:jpeg,jpg,png,bmp,gif',
        'name' => 'required',
        'address' => 'required',

    ];

    public function user_c(){
        return $this->belongsTo('App\User','created_by','id');

    }

    public function user_u(){
        return $this->belongsTo('App\User','updated_by','id');

    }

    public function currency(){
        return $this->belongsTo('App\model\Currency','currency_id','id');
    }

    public function position(){
        return $this->belongsTo('App\model\Position','position_id','id');
    }

    public function inventory(){
        return $this->belongsTo('App\model\Inventory','item_id','id');
    }

    public function roles(){
        return $this->belongsTo('App\model\Roles','role','id');
    }

    public static function paginateAllData()
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate(Utility::P35);
        //return Utility::paginateAllData(self::table());

    }

    public static function getAllData()
    {
        return static::where('status', '=','1')->orderBy('id','DESC')->get();

    }
    public static function paginateData($column, $post)
    {
        return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate('15');
        //return Utility::paginateData(self::table(),$column, $post);

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

    public static function massData($column, $post = [])
    {
        //return Utility::massData(self::table(),$column, $post);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)
            ->orderBy('id','DESC')->paginate(Utility::P35);

    }
    public static function massDataCondition($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column, $post)->where($column2, '=',$post2)
            ->orderBy('id','DESC')->paginate(Utility::P35);

    }

    public static function massDataMassCondition($column, $post, $column2, $post2)
    {
        //return Utility::massDataCondition(self::table(),$column, $post, $column2, $post2);
        return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->whereIn($column2,$post2)
            ->orderBy('id','DESC')->paginate(Utility::P35);

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

    public static function searchCustomer($value){
        return static::where('vendor_customer.status', '=','1')
            ->where(function ($query) use($value){
                $query->where('vendor_customer.name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.address','LIKE','%'.$value.'%') ->orWhere('vendor_customer.phone','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.contact_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.contact_name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.search_key','LIKE','%'.$value.'%')->orWhere('vendor_customer.email1','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.email2','LIKE','%'.$value.'%')->orWhere('vendor_customer.company_no','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.tax_id_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.bank_name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.account_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.account_name','LIKE','%'.$value.'%');
            })->get();
    }

    public static function searchVendor($value){
        return static::where('vendor_customer.company_type', '=',Utility::VENDOR)
            ->where('vendor_customer.status', '=',Utility::STATUS_ACTIVE)
            ->where(function ($query) use($value){
                $query->where('vendor_customer.name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.address','LIKE','%'.$value.'%') ->orWhere('vendor_customer.phone','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.contact_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.contact_name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.search_key','LIKE','%'.$value.'%')->orWhere('vendor_customer.email1','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.email2','LIKE','%'.$value.'%')->orWhere('vendor_customer.company_no','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.tax_id_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.bank_name','LIKE','%'.$value.'%')
                    ->orWhere('vendor_customer.account_no','LIKE','%'.$value.'%')->orWhere('vendor_customer.account_name','LIKE','%'.$value.'%');
            })->get();
    }

}