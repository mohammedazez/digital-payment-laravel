<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Mutasi_saldobank extends Model
{
    protected $table = 'mutasisaldo_bank';
    protected $primaryKey = 'id';
     
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}