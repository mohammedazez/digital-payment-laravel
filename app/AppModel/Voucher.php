<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    public function redeem()
    {
        return $this->hasMany('App\AppModel\Redeem');
    }
}