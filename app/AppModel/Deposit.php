<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Deposit extends Model
{
    protected $guarded= ['id'];
    public function bank()
    {
    	return $this->belongsTo('App\AppModel\Bank');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public static function getMinDeposit()
    {
      $query = DB::table('settings_min_deposit')
            ->select('*')
            ->get();

        return $query;
    }
}