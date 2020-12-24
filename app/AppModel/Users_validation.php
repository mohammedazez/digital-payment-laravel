<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Users_validation extends Model
{
    public static function getUseralidation($id){
        
        $notifValidation = DB::table('users_validations')
                			->select('*')
                			->where('user_id', $id)
                			->where('status',1)
                            ->count();
                            
        return $notifValidation;
    }
}