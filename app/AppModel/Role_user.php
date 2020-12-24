<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{
    protected $table      = 'role_user';
    protected $primaryKey = "user_id";
    public $timestamps    = false;
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    
    public function mindeposit()
    {
        return $this->hasOne('App\AppModel\SettingMinDeposit','id');
    }
    
}
