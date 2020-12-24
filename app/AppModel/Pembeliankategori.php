<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Pembeliankategori extends Model
{

    protected $fillable = ['*'];
    
    public static function IndexRaw($index_raw)
    {
        $model = new static();
        $model->setTable(\DB::raw($model->getTable() . ' ' . $index_raw));
        return $model;
    }
    
    public function pembelianoperator()
    {
        return $this->hasMany('App\AppModel\Pembelianoperator');
    }
    public function pembelianproduk()
    {
        return $this->hasMany('App\AppModel\Pembelianproduk');
    }
    public function V_pembelianproduk_admin()
    {
        return $this->hasMany('App\AppModel\V_pembelianproduk_admin');
    }
    public function V_pembelianproduk_personal()
    {
        return $this->hasMany('App\AppModel\V_pembelianproduk_personal');
    }
    public function V_pembelianproduk_agen()
    {
        return $this->hasMany('App\AppModel\V_pembelianproduk_agen');
    }
    public function V_pembelianproduk_enterprise()
    {
        return $this->hasMany('App\AppModel\V_pembelianproduk_enterprise');
    }
}
