<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Pin extends Model
{
    public static function GeneratePin($id)
    {
        $userCek  = User::where('id', $id)->first();
        
        $random =  mt_rand(1000, 9999);
        
        $query_data = DB::table("users")
    	        ->where('id', $userCek->id)
        	    ->update([
    			'pin'=> $random,
    		]);
        
        return $random;
    }
}