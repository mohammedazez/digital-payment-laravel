<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class V_pembelianproduk_enterprise extends Model
{
    protected $table      = 'produkpembelian_enterprise';
    protected $primaryKey = "id";
	
    public function pembelianoperator()
    {
        return $this->belongsTo('App\AppModel\Pembelianoperator');
    }
    public function pembeliankategori()
    {
        return $this->belongsTo('App\AppModel\Pembeliankategori');
    }
    public function pembelianproduk()
    {
        return $this->belongsTo('App\AppModel\Pembelianproduk','id');
    }
}