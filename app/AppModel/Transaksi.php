<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}