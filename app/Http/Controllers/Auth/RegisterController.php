<?php

namespace App\Http\Controllers\Auth;

use Mail, Hash, DB, Cookie;
use App\User;
use App\Role;
use App\Mail\SendEmail;
use App\AppModel\Pin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\AppModel\SMSGateway;
use Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/member';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function showRegistrationForm(Request $request)
    {
        if( !empty($request->ref) && empty(Cookie::get('ref')) )
        {
            Cookie::queue(Cookie::make('ref', $request->ref, (24*60)));
        }
        
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'username'=>'required|max:255',
            'phone' => 'required|min:10|max:15|unique:users',
            'city' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X]).*$/|confirmed',
            'pin' => 'required|string|min:4|max:4',
            'kode_referral'=>'numeric'
        ],[
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama maksimal 255 karakter',
            'username.required'=>'Username tidak boleh kosong',
            'username.max'=> 'Username maksimal 255 karakter',
            'phone.required' => 'Nomor Handphone tidak boleh kosong',
            'phone.max' => 'Nomor Handphone maksimal 15 digit',
            'phone.unique' => 'Nomor Handphone sudah digunakan',
            'city.required' => 'Kota Sekarang tidak boleh kosong',
            'city.max' => 'Kota maksimal 255 karakter',
            'email.required' => 'Alamat Email tidak boleh kosong',
            'email.max' => 'Alamat Email maksimal 255 karakter',
            'email.email' => 'Alamat Email harus berformat email, contoh : member@gmail.com',
            'email.unique' => 'Alamat Email sudah digunakan',
            'password.required' => 'Kata Sandi tidak boleh kosong',
            'password.min' => 'Kata Sandi minimal 6 digit',
            'password.regex' => 'Kata Sandi harus terdiri dari huruf dan angka',
            'password.confirmed' => 'Kata Sandi konfirmasi tidak benar',
            'pin.required' => 'Pin tidak boleh kosong',
            'pin.min' => 'Pin harus 4 karakter',
            'pin.max' => 'Pin harus 4 karakter',
            'kode_referral'=>'Kode referral harus berupa angka'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {   
       
        $referral_id = null;
        if( !empty(Cookie::get('ref')) )
        {
            $referral_id  = trim(Cookie::get('ref'));
           
        }
        elseif( !empty($data['kode_referral']) )
        {
            $referral_id = $data['kode_referral'];
        }
       
        
        if( !empty($referral_id) )
        {
            
            $cr = User::where('username',$referral_id)->first();
            
            $referral_id = isset($cr) ? $cr->id : null;    
        }
        
        $users = User::create([
            'name'         => addslashes(trim($data['name'])),
            'username'     => addslashes(trim($data['username'])),
            'phone'        => addslashes(trim($data['phone'])),
            'city'         => addslashes(trim($data['city'])),
            'email'        => addslashes(trim($data['email'])),
            'pin'          => trim($data['pin']),
            'password'     => Hash::make($data['password']),
            'referred_by'  => $referral_id,
        ]);
        
        $roles = Role::where('name', 'member')->first();
        $users->attachRole($roles);
        
        Mail::to($data['email'])->queue(new SendEmail($users));
        
        $text = 'Selamat, Akun anda berhasil di Registrasi. Pin anda adalah '.trim($data['pin']).', simpan dan gunakan untuk transaksi';
        SMSGateway::send($data['phone'], $text);
        
        return $users;
    }
}