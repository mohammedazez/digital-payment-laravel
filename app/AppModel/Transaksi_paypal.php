<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Transaksi_paypal extends Model
{
    protected $table      = 'transaksi_saldo_paypal';
    protected $primaryKey = "id";
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    }    
    
    public function transaksis()
    {
    	return $this->belongsTo('App\AppModel\Transaksi');
    }
}