<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class V_pembelianproduk_personal extends Model
{
    protected $table      = 'produkpembelian_personal';
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