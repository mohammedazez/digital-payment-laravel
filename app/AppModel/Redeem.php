<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Redeem extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    
    public function voucher()
    {
    	return $this->belongsTo('App\AppModel\Voucher');
    }
}