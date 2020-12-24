<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pembelianproduk extends Model
{

    protected $fillable = [
        'id', 
        'apiserver_id', 
        'product_id', 
        'pembelianoperator_id', 
        'pembeliankategori_id', 
        'product_name', 
        'desc',
        'price_default', 
        'price_markup', 
        'price',
        'status',
        'created_at',
        'updated_at',
    ];
    
    protected $hidden = [
        'price_default', 'price_markup', 'price',
    ];
    
    public static function IndexRaw($index_raw)
    {
        $model = new static();
        $model->setTable(\DB::raw($model->getTable() . ' ' . $index_raw));
        return $model;
    }

    public function pembelianoperator()
    {
        return $this->belongsTo('App\AppModel\Pembelianoperator');
    }
    public function pembeliankategori()
    {
        return $this->belongsTo('App\AppModel\Pembeliankategori');
    }
    public function pembelianMarkup()
    {
        return $this->hasOne('App\AppModel\Pembelian_markup', 'id_product');
    }
    public function V_pembelianproduk_personal()
    {
        return $this->hasOne('App\AppModel\V_pembelianproduk_personal','id');
    }
    public function V_pembelianproduk_agen()
    {
        return $this->hasOne('App\AppModel\V_pembelianproduk_agen','id');
    }
    public function V_pembelianproduk_enterprise()
    {
        return $this->hasOne('App\AppModel\V_pembelianproduk_enterprise','id');
    }
    

    public static function updateAllpriceByCategory($id,$aksi,$nominal)
    {
         DB::table('pembelianproduks')
              ->where('pembeliankategori_id', $id)
              ->update(['price_markup'  => DB::raw('price_markup '.$aksi.' '.intval($nominal).'')]);
    }


    public static function updateAllpriceByOperator($id,$aksi,$nominal)
    {
         DB::table('pembelianproduks')
              ->where('pembelianoperator_id', $id)
              ->update(['price_markup'  => DB::raw('price_markup '.$aksi.' '.intval($nominal).'')]);
    }

    public static function updateAllprice($aksi,$nominal)
    {
         DB::table('pembelianproduks')
              ->update(['price_markup'  => DB::raw('price_markup '.$aksi.' '.intval($nominal).'')]);
    }

    public static function getProductIdOperator($id)
    {
            $query = DB::table('pembelianoperators')
            ->select('product_id')
            ->where('id', $id)
            ->get();

            return $query;
    }

    public static function getIdOperator($id)
    {
            $query = DB::table('pembelianoperators')
            ->select('id')
            ->where('product_id', $id)
            ->get();

            return $query;
    }

    public static function getAllKategori()
    {
            $query = DB::table('pembeliankategoris')
            ->select('*')
            ->get();

            return $query;
    }
}
