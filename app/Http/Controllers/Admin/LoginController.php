<?php
namespace App\Http\Controllers\Admin;
use Route;
use Mail;
use Auth, Hash;
use Validator;
use Session;
use Redirect;
use DB;
use Crypt;
use Illuminate\Http\Request;
use App\Http\Models\Admin\LoginModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class LoginController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->LoginModel = new LoginModel();
	}

	public function Login()
	{
		$Data['Title'] = 'Admin Login';
		return View('Admin/Login')->with($Data);
	}
	public function AdminLoginValidate(Request $request){
		$Data = $request->all();
		$Email = $Data['email'];
		$Password = $Data['password'];
	
		$referer_url = route('Dashboard');
		
		if($Data['referer_url']){
			$referer_url = $Data['referer_url'];
		}

		$AdminLoginValidate = $this->LoginModel->AdminLoginValidate($Email,$Password);

		if(!empty($AdminLoginValidate))
		{
			if($AdminLoginValidate->status==1 && $AdminLoginValidate->last_name == 'Admin' ){

				$Image = asset('Admin/assets/images/logo-01.png');
				$Icon = asset('Admin/assets/images/logo-01.png');
				if($AdminLoginValidate->image!=''){
					$Image = asset('Admin/assets/images/'.$AdminLoginValidate->image);
				}
				
				Session::put('admin_id', $AdminLoginValidate->id);
				Session::put('admin_name', $AdminLoginValidate->first_name);
				Session::put('admin_image', $Image);
				Session::put('admin_icon', $Icon);
				Session::put('admin_email', $AdminLoginValidate->email);
				Session::put('admin_login', 1);
				Session::save();
				$msg 		= Common::AlertErrorMsg('Success','Login Successfully');
				$status = 1;
			}
			elseif($AdminLoginValidate->status==1 && $AdminLoginValidate->last_name == 'Client')
			{

				$Image = asset('Admin/assets/images/logo-01.png');
				$Icon = asset('Admin/assets/images/logo-01.png');
				if($AdminLoginValidate->image!=''){
					$Image = asset('Admin/assets/images/'.$AdminLoginValidate->image);
				}
				
				Session::put('admin_id', $AdminLoginValidate->id);
				Session::put('admin_name', $AdminLoginValidate->first_name);
				Session::put('admin_image', $Image);
				Session::put('admin_icon', $Icon);
				Session::put('admin_email', $AdminLoginValidate->email);
				Session::put('admin_login', 2);
				Session::save();
				$msg 		= Common::AlertErrorMsg('Success','Login Successfully');
				$status = 1;


			}
			
			
		}else{
			$msg 		= Common::AlertErrorMsg('Danger','Email Or Password Invalid.');
			$status = 0;
    }
		$arr['status'] 	= $status;
		$arr['msg'] 		= $msg;
		$arr['RefererURL'] 		= $referer_url;
		
		echo json_encode($arr);
		exit();
	}


	public function ResetPassword(){
		if(Session::get('admin_login')==1){
			return redirect()->route('Dashboard');
		}
		$Data['Title'] = 'Reset Password';
		return View('Admin/ResetPassword')->with($Data);
	}


	public function CheckResetPassword(Request $request){
		$Data = $request->all();
		$Email =$Data['email'];

		$AdminLoginValidate = $this->LoginModel->CheckEmailID($Email);
		if(!empty($AdminLoginValidate))
		{
			if($AdminLoginValidate->status==1){
				$msg 		= Common::AlertErrorMsg('Success','Please check mail Successfully');
				$status = 1;
			}else{
				$msg 		= Common::AlertErrorMsg('Danger','Your account has been De-active.');
				$status = 0;
			}
		}else{
			$msg 		= Common::AlertErrorMsg('Danger','Email Invalid.');
			$status = 0;
    }
		$arr['status'] 	= $status;
		$arr['msg'] 		= $msg;
		echo json_encode($arr);
		exit();
	}
	public function Logout(Request $request)
	{

        session()->regenerate();
		Session::put('admin_id', '');
		Session::put('admin_name', '');
		Session::put('admin_login', '');
		Session::put('admin_email', '');
		Session::put('admin_image', '');
        Session::forget('admin_id');
		Session::forget('admin_name');
		Session::forget('admin_login');
		Session::forget('admin_email');
		Session::forget('admin_image');
		Session::flash('message', 'Logout successfully.'); 
    	Session::flash('alert-class', 'alert-success'); 
		return redirect()->action('Admin\LoginController@Login');
		
	}
}