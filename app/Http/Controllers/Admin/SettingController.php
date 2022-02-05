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
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class SettingController extends Controller 
{
	public function __construct(Request $request)
	{		
		
	}
	public function Setting()
	{
		$admin_id = Session::get('admin_id');
		
		$Setting = DB::table('admin')->where('id',$admin_id)->first();
		
		$Data['Title'] 				= 'Setting';
		$Data['Menu'] 				= '';
		$Data['SubMenu'] 			= '';
		$Data['SelectMenu']   = '';
		$Data['Setting'] 			= $Setting;
		return View('Admin/Setting')->with($Data);
	}

	public function UpdateSetting(Request $request){
		$Data = $request->all();
		$Save['first_name'] 	= $Data['first_name'];
		$Save['last_name'] 	= $Data['last_name'];
		$Save['email'] 	= $Data['email'];
		$Save['mobile'] 	= $Data['mobile'];
		$Save['address']= $Data['address'];
		$Save['timing']= $Data['timing'];
		
		if(!empty($Data['profile_img'])){
			$image = $Data['profile_img'];
	   	 	$Path = 'Admin/assets/images';
			$extension = $image->getClientOriginalExtension();
			$ImageName = Session::get('admin_id').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 		= $ImageName;

			$Image = asset('Admin/assets/images/'.$ImageName);
			Session::put('admin_image', $Image);
	    }
		Session::put('admin_name', $Save['first_name']);
		Session::put('admin_email', $Save['email']);
		Session::save();

		DB::table('admin')->where('id',Session::get('admin_id'))->update($Save);

		$msg = Common::AlertErrorMsg('Success','Save Successfully');
		Session::flash('message', $msg); 
		return Redirect()->back();
	}
	public function ChangePassword(Request $request){
		$Data = $request->all();
		
		$old_password 	= $Data['old_password'];
		
		$admin_id = Session::get('admin_id');
		$Setting = DB::table('admin')->where('id',$admin_id)->first();
		if($Setting->password != $old_password){
			$arr['msg'] 	= Common::AlertErrorMsg('Danger','Old password mismatch.');
			$arr['status'] 		= 0;		
		}else{
			$Save['password'] 			= $Data['password'];
			DB::table('admin')->where('id',$admin_id)->update($Save);
			$arr['msg'] 	= Common::AlertErrorMsg('Success','Password Change Successfully');
			$arr['status'] 		= 1;
		}
		echo json_encode($arr);
		exit();
	}
	public function UpdateSocialMedia(Request $request){
		$Data = $request->all();

		$Save['facebook'] = $Data['facebook'];
		$Save['twitter'] = $Data['twitter'];
		$Save['instagram'] = $Data['instagram'];
		$Save['youtube'] = $Data['youtube'];
		$Save['linkedin'] = $Data['linkedin'];
		$Save['pinterest'] = $Data['pinterest'];

		DB::table('social_media')->where('id',1)->update($Save);

		$msg = Common::AlertErrorMsg('Success','Social Media Save Successfully');
		Session::flash('message', $msg); 
		return Redirect()->back();
	}
	public function UpdatePagination(Request $request){
		$Data = $request->all();
		$Save['no_of_page'] 	= $Data['no_of_page'];
		$Save['analytics_code'] = $Data['analytics_code'];
		$Save['refer_amt'] 		= $Data['refer_amt'];
		
		Session::put('no_of_page', $Save['no_of_page']);
		Session::save();

		DB::table('admin')->where('id',Session::get('admin_id'))->update($Save);

		$msg = Common::AlertErrorMsg('Success','Save Successfully');
		Session::flash('message', $msg); 
		return Redirect()->back();
	}
}