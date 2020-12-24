<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use URL;

class BlockPhone extends Model
{
    protected $table = 'blokir_telephone';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public static function getDataPhone()
	{
		$query = DB::table('blokir_telephone')
			->select('*')
			->orderBy('updated_at', 'DESC')
            ->get();
            
			return $query;
	}    

    public static function getDataPhoneMobile()
	{
		$query = DB::table('blokir_telephone')
			->select('*')
			->orderBy('updated_at', 'DESC')
            ->paginate(10);
            
			return $query;
	}  
	
    public static function getDataPhoneWhere($data_phone)
	{
	    $query = DB::table('blokir_telephone')
			->select('*')
			->where('phone',$data_phone)
			->orderBy('updated_at', 'DESC')
            ->first();
            
		return $query;
	}      
	
    public static function getDataPhoneWhereNotIn($id, $data_phone)
	{
	    $query = DB::table('blokir_telephone')
			->select('*')
			->whereNotIn('id',[$id])
			->where('phone',$data_phone)
			->orderBy('updated_at', 'DESC')
            ->get();
            
		return $query;
	}   
}