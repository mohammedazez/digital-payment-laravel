<?php

namespace App\Http\Controllers\Auth;

use Auth, Session, Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\AppModel\BlockPhone;
use App\AppModel\Setting;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        
        $setting = Setting::first();

        $phone = $request->phone;
      
        if( substr($phone, 0, 2) == '62' ) {
            $phone = substr($phone, 2); // 81234567890
        } elseif( substr($phone, 0, 3) === '+62' ) {
            $phone = substr($phone, 3); // 81234567890
        } elseif( substr($phone, 0, 2) == '08' ) {
            $phone = substr($phone, 1); // 81234567890
        }
        
        $users = User::select('id', 'phone', 'status', 'online')
            ->where('phone', $phone)
            ->orWhere('phone', 'LIKE', '0'.$phone)
            ->orWhere('phone', 'LIKE', '62'.$phone)
            ->orWhere('phone', 'LIKE', '+62'.$phone)
            ->first();

        if( $users )
        {
            if( $users->status == 0 )
            {
                $errors = [$this->username() => 'Maaf, Akun anda nonaktif!'];

                if ($request->expectsJson()) {
                    return response()->json($errors, 422);
                }
        
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors($errors);
            }
            elseif( $setting->prevent_multilogin == 1 && $users->online == 1 && !$users->hasRole('admin') )
            {
                $errors = [$this->username() => 'Maaf, akun Anda terdeteksi sedang login. Silahkan tunggu 5 menit jika sebelumnya Anda menutup tanpa menekan tombol keluar/logout'];

                if ($request->expectsJson()) {
                    return response()->json($errors, 422);
                }
        
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors($errors);
            }

            $request->merge([
                'phone' => $users->phone
            ]);
        }
        
        $cekPhone = BlockPhone::getDataPhoneWhere($request->phone);

        if( !$cekPhone )
        {
            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
    
                return $this->sendLockoutResponse($request);
            }
    
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
    
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);
    
            return $this->sendFailedLoginResponse($request);
        }
        else
        {
            return redirect()->back()->with(['alert-error' => 'Maaf, No.Hp Anda Diblokir!']);
        }
        
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string'
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->route('login')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }
    
    public function username()
    {
        return 'phone';
    }
    
    public function logout(Request $request)
    {
        $user = $request->user();
        if( $user )
        {
            $user->online = 0;
            $user->last_online = date('Y-m-d H:i:s');
            $user->save();
        }
        
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
}