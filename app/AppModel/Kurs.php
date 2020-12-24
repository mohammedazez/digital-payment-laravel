<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Kurs extends Model
{
    protected $table      = 'settings_kurs';
    protected $primaryKey = "id";
    public $timestamps    = false;
    
    public function bank()
    {
    	return $this->belongsTo('App\AppModel\Bank');
    }
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public static function getKurs()
    {
      $query = DB::table('settings_kurs')
            ->select('*')
            ->get();

        return $query;
    }
    
    public static function getInfo($name)
    {
        $query = DB::table('settings_kurs')
        ->where('name', '=', $name)
        ->select('*')
        ->get()[0];
        
        return $query;
    }
}