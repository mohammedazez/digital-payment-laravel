<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $guarded = ['id'];
    public function bank_kategori()
    {
    	return $this->belongsTo('App\AppModel\Bank_kategori');
    }

    public function deposit()
    {
    	return $this->hasMany('App\AppModel\Deposit');
    }
    public function provider(){
        return $this->belongsTo('App\AppModel\Provider');
    }
}