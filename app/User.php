<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Klaravel\Ntrust\Traits\NtrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, NtrustUserTrait; // add this trait to your user model

     /*
     * Role profile to get value from ntrust config file.
     */
    protected static $roleProfile = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'saldo', 'api_key','pin',
        ];
    
    protected $dates = [
        'created_at', 'updated_at', 'email_verified_at', 'phone_verified_at', 'last_login', 'last_online'
        ];

    public function antrian()
    {
        return $this->hasMany('App\AppModel\Antriantrx');
    }
    public function transaksis()
    {
        return $this->hasMany('App\AppModel\Transaksi');
    }
    public function deposit()
    {
        return $this->hasMany('App\AppModel\Deposit');
    }
    public function informasi()
    {
        return $this->hasMany('App\AppModel\Informasi');
    }
    public function testimonial()
    {
        return $this->hasMany('App\AppModel\Testimonial');
    }
    public function mutasi()
    {
        return $this->hasMany('App\AppModel\Mutasi');
    }
    public function tagihan()
    {
        return $this->hasMany('App\AppModel\Tagihan');
    }
    public function redeem()
    {
        return $this->hasMany('App\AppModel\Redeem');
    }
    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }
}
