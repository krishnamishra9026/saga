<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Http\Models\Admin\CategoryModel;
use App\Http\Models\ProductsModel;
use App\Http\Models\Front\LoginModel;
use App\Http\Models\Front\HomeModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User; 
use Session;
use App\Helpers\Common;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest');
    
		$this->LoginModel 	= new LoginModel();
		$this->HomeModel 	= new HomeModel();
		$this->CategoryModel = new CategoryModel();
        $this->productModel    = new ProductsModel();

	
    }

    public function getPassword($token) { 
        $Data['Title'] 					= 'Forgot Password';
		$Data['Menu'] 					= '';
		$Data['DivClass'] 				= 'forgot';
		$Data['Settings']               = $this->HomeModel->Settings();
		$Data['Category']               = $this->productModel->CategoryList();
		$Data['CategoryA']               = $this->productModel->CategoryAList();
		$Data['manuPage']               = $this->productModel->manuPage();
        $Data['notification'] = $this->productModel->getProductNotification();
        
        if(session('locale')=='en'){
            return view('customauth.passwords.reset', ['token' => $token])->with($Data);
	    }
	    else{
            return view('customauth.passwords.reset-ar', ['token' => $token])->with($Data);
	    }
       
     }
   
     public function updatePassword(Request $request)
     {

    
        $updatePassword = DB::table('password_resets')
                        ->where(['email' => $request->email, 'token' => $request->token])
                        ->first();
        
        if (!$updatePassword){
            // $msg = Common::AlertErrorMsg('Danger','Token mismatch!');
            $msg = Common::AlertErrorMsg('Danger','password reset success full!');
            Session::flash('message', $msg);
        }
  
        $user = DB::table('user_authentication_details')->where('email', $request->email)
                ->update(['password' => md5($request->password)]);
   
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
   
         return redirect(route('Login'));
     }
}
