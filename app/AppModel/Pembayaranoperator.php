<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Pembayaranoperator extends Model
{
    protected $guarded = [];
    
    public function pembayarankategori()
    {
    	return $this->belongsTo('App\AppModel\Pembayarankategori');
    }
    public function pembayaranproduk()
    {
        return $this->hasMany('App\AppModel\Pembayaranproduk');
    }
}