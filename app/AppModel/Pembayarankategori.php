<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Pembayarankategori extends Model
{
    protected $guarded = [];
    
    public function pembayaranoperator()
    {
        return $this->hasMany('App\AppModel\Pembayaranoperator');
    }
    public function pembayaranproduk()
    {
        return $this->hasMany('App\AppModel\Pembayaranproduk');
    }
}