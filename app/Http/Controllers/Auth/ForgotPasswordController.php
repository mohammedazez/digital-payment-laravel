<?php

namespace App\Http\Controllers\Auth;

use Captcha;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function showLinkRequestForm()
    {
        $captcha = Captcha::chars('0123456789')->length(4)->size(130, 50)->generate();
        return view('auth.passwords.email', compact('captcha'));
    }
    
    public function sendResetLinkEmail(Request $request)
    {
        if( !Captcha::validate($request->captcha_id, $request->captcha) ) {
            return redirect()->back()->withErrors(['captcha' => 'Kode captcha tidak valid'])->withInput();
        }
            
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }
    
    public function sendResetLinkResponse(Request $request, $response)
    {
        return redirect()->back()->with('alert-success', 'Tautan atur ulang kata sandi telah dikirim ke email Anda. Silahkan cek kotak masuk atau folder spam email Anda');
    }
    
    public function sendResetLinkFailedResponse(Request $request, $response)
    {
        return redirect()->back()->with('alert-error', 'Gagal mengirim tautan atur ulang kata sandi. Silahkan dicoba kembali');
    }
}