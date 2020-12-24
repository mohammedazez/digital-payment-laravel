<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Bank_kategori extends Model
{
    public function bank()
    {
        return $this->hasMany('App\AppModel\Bank');
    }
    public function deposit()
    {
        return $this->hasMany('App\AppModel\Deposit');
    }

}
