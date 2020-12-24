<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Setting extends Model
{
    protected $guarded = ['id'];
    
    public static function settingsBonus($id)
	{
		 $komisi  = DB::table('settings_komisi')
                ->select('*')
                ->where('id',$id)
                ->first();
         
         return $komisi;
	}
}