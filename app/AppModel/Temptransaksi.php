<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Temptransaksi extends Model
{
    public function transaksi()
    {
    	return $this->belongsTo('App\AppModel\Transaksi');
    }
}