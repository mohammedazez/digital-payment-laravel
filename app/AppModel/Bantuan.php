<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use URL;

class Bantuan extends Model
{

    protected $table = 'layanan_bantuan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}