<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}