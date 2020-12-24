<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class PaypalSetting extends Model
{
    protected $table = 'paypal_settings';
    protected $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;
}