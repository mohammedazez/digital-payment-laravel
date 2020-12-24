<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class PaypalModel extends Model
{
    protected $table = 'paypal_payments';
    protected $guarded = [];
    protected $dates = ['checking_time', 'expired_at', 'created_at', 'updated_at'];
}
