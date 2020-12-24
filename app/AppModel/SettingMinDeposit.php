<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class SettingMinDeposit extends Model
{   
    protected $table      = 'settings_min_deposit';
    protected $primaryKey = "id";
    public $timestamps    = false;
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    } 
    
    public function role_user()
    {
    	return $this->belongsTo('App\AppModel\Role_user');
    }
    
}
