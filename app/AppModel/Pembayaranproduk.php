<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pembayaranproduk extends Model
{
    protected $guarded = [];
    
    public function pembayaranoperator()
    {
        return $this->belongsTo('App\AppModel\Pembayaranoperator');
    }
    
    public function pembayarankategori()
    {
        return $this->belongsTo('App\AppModel\Pembayarankategori');
    }

    public static function updateAllpriceByCategory($id,$aksi,$nominal)
    {
         DB::table('pembayaranproduks')
              ->where('pembayarankategori_id', $id)
              ->update(['markup'  => DB::raw('markup '.$aksi.' '.intval($nominal).'')]);
    }


    public static function updateAllpriceByOperator($id,$aksi,$nominal)
    {
         DB::table('pembayaranproduks')
              ->where('pembayaranoperator_id', $id)
              ->update(['markup'  => DB::raw('markup '.$aksi.' '.intval($nominal).'')]);
    }

    public static function updateAllprice($aksi,$nominal)
    {
    	 DB::table('pembayaranproduks')
              ->update(['markup'  => DB::raw('markup '.$aksi.' '.intval($nominal).'')]);
    }

    public static function getOperatorWhere($id)
    {
            $query = DB::table('pembayaranoperators')
            ->select('*')
            ->where('pembayarankategori_id', $id)
            ->get();

            return $query;
    }

    public static function getProductIdOperator($id)
    {
            $query = DB::table('pembayaranoperators')
            ->select('product_id')
            ->where('id', $id)
            ->get();

            return $query;
    }

    public static function getIdOperator($id)
    {
            $query = DB::table('pembayaranoperators')
            ->select('id')
            ->where('pembayarankategori_id', $id)
            ->get();

            return $query;
    }

    public static function getAllKategori()
    {
            $query = DB::table('pembayarankategoris')
            ->select('*')
            ->get();

            return $query;
    }

}