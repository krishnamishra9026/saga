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
use App\Http\Models\Admin\UserModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class UserController extends Controller 
{
	public function __construct(Request $request)
	{
		$this->UserModel = new UserModel();	
	}

	public function List(){
		$Data['Title'] 				= 'User List';
		$Data['Menu'] 				= 'User';
		$Data['SubMenu'] 			= '';
    	$Data['SelectMenu']   		= '';
		$Data['Result']				= $this->UserModel->UsersListing();
		
    	return View('Admin/User/List')->with($Data);
	}
  
	public function ChangeStatus(Request $request){
		
		
		$finalArray = array();
        $Data 	= $request->all();
		$id 	= $Data['user_id'];
		$userDetails = DB::table('user_authentication_details')->select('status')->where('id',$id)->first();
	    if($userDetails->status == 1){
			$status = 0;
		}
		else{
		
			$status = 1;	
		}
		$statusUpdate = DB::table('user_authentication_details')->where('id',$id)->update(['status'=>$status]);

		if($statusUpdate)
		{

			$finalArray  = array('status'=>'success');
			print_r(json_encode($finalArray));
			exit();
		}
		else{

			$finalArray  = array('status'=>'failure');
			print_r(json_encode($finalArray));
			exit();
		}
	
	}
}