<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}