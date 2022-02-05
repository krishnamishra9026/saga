<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Carbon\Carbon; 
use Session;
use App\Helpers\Common;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

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


    public function getEmail()
    {
       return view('customauth.passwords.email');
    }
  
   public function postEmail(Request $request)
    {
        $token = str_random(64);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        
        if(session('locale')=='en'){
            Mail::send('customauth.verify', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password Notification');
            });
	    }
	    else{
            Mail::send('customauth.verify-ar', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password Notification');
            });
	    }
       
        
        $msg = Common::AlertErrorMsg('Success','We have e-mailed your password reset link!');
        Session::flash('message', $msg);
        return redirect()->back();
    }
}
