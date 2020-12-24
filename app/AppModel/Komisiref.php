<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Komisiref extends Model
{
	protected $table = 'mutasis_komisi';
	protected $guarded = ['id'];
	
	protected $fillable = ['user_id','from_reff_id','komisi','jenis_komisi','note'];
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}