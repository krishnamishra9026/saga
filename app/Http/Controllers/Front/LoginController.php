<?php
namespace App\Http\Controllers\Front;
use Route;
use Auth, Hash;
use Validator;
use Session;
use Redirect;
use DB;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Models\Front\LoginModel;
use App\Http\Models\Front\HomeModel;
use App\Mail\UserRegistration;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Admin\CategoryModel;
use App\Http\Models\ProductsModel;
use App\Http\Controllers\Controller;
use App\Helpers\Common;


class LoginController extends Controller 
{
	public function __construct(Request $request)
	{
		$this->LoginModel 	= new LoginModel();
		$this->HomeModel 	= new HomeModel();
		$this->CategoryModel = new CategoryModel();
        $this->productModel    = new ProductsModel();

	}

	public function Login(){

		$Data['Title'] 					= 'User Login';
		$Data['Menu'] 					= '';
		$Data['DivClass'] 				= 'login';
        $Data['Category'] = $this->productModel->CategoryList();
        $Data['CategoryA'] = $this->productModel->CategoryAList();
		$Data['notification'] = $this->productModel->getProductNotification();

		$Data['manuPage'] = $this->productModel->manuPage();

		if(session('user_id'))
		{
		return redirect('/');
		}
		else
		{

		if(session('locale')=='en'){
        	return view('en-SA/Front.login')->with($Data);
	    }
	    else{
	        return view('ar-SA/Front.login')->with($Data);
	    }

		//return View('Front.login',compact('Data'))->with($Data);
		}
}


public function UserForgotPasswordRecover(Request $request){
	$Data = $request->all();
	
	$email = $Data['email'];

	$LoginValidate = $this->LoginModel->CheckUserEmail(['first_name','last_name','password','status'],$email);

	if(!empty($LoginValidate))
	{
		if($LoginValidate->status==1){
			
			$EmailData['first_name'] = $LoginValidate->first_name;
			$EmailData['last_name'] = $LoginValidate->last_name;

			$EmailData['Email'] = $email;
			$EmailData['recoverpasswordlink'] = 'http://cureroot.com/cureroot/public/change-password';
			$subject = 'Create New Password';
		 
			$Body =  $this->UserpasswordRecoverHtml($EmailData);

		 

		$MailStatus = Common::SendMail($email, 'info@cureroot.com', '', '', $subject, $Body);
		  
		
		if($MailStatus){
			$msg = Common::AlertErrorMsg('Success','We have e-mailed your password!');
			$status = 1;
		}else{
			$msg = Common::AlertErrorMsg('Danger','Mail Error.');
			$status = 0;
		}
		
		}
		else{
			$msg = Common::AlertErrorMsg('Danger','Your account has been In-active.');
			$status = 0;
		}
	}else{
		$msg 		= Common::AlertErrorMsg('Danger','Invalid email.');
		$status = 0;
	}
	$arr['status'] 	= $status;
	$arr['msg'] 	= $msg;
	
	return Redirect()->route('Login');

}

public function UserpasswordRecoverHtml($EmailData)
{
	

	$html ='';
   


$html.='<html>';
$html.='<head>';
$html.='<meta charset="utf-8">';
$html.='<meta http-equiv="x-ua-compatible" content="ie=edge">';
$html.='<title>Recover Password</title>';
$html.='<meta name="viewport" content="width=device-width, initial-scale=1">';

	
$html.='</head>';
$html.='<body style="background-color: #EFF2F7;padding: 25px 0 !important;">';


$html.='<table border="0" cellpadding="0" cellspacing="0" width="100%">';

$html.='<tr>';
$html.='<td align="center" bgcolor="#e9ecef">';
$html.='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
$html.='<tr>';
$html.='<td align="center" valign="top" style="padding: 5px 5px;">';
		
$html.='</td>';
	$html.='</tr>';
  $html.='</table>';
$html.='</td>';
$html.='</tr>';

$html.='<td align="center" bgcolor="#e9ecef">';
  $html.='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
	$html.='<tr>';
	  $html.='<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">';
	  $html.='Dear '.$EmailData["first_name"].'<span>'.$EmailData["last_name"].'</span>,';
		$html.='<br/><br/>Here is your login details:-';
	  $html.='</td>';
	$html.='</tr>';
	$html.='<tr>';
	  $html.='<td height="53" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">';
	  $html.='Your Email Id: <b>'.$EmailData["Email"].'</b><br>';
	  $html.='Your Can Change your Password by Clicking on this link : <b>'.$EmailData["recoverpasswordlink"].'</b>';
	  $html.='</td>';
  $html.='</tr> <br> <br>';
  $html.='<tr>';
	  $html.='<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">';
		$html.='<br>Warm regards, <br>';
		$html.='<strong> Cureroot </strong><br>';
		$html.='<br>';
	$html.='</td>';
  $html.='</tr>';
  $html.='</table>';
$html.='</td>';
$html.='</table>';
$html.='</body></html>';

	return $html;
	
}

public function CreateNewPassword(Request $request)
{
	$requestData = $request->all();
	$email = $requestData['email'];
	$password = md5($requestData['password']);
	$confirm_password = md5($requestData['confirm_password']);

	$LoginValidate = $this->LoginModel->CheckUserEmail(['first_name','last_name','password','status'],$email);

	if(!empty($LoginValidate))
	{
	
       if($LoginValidate->status==1){
		

		
		if($password != $confirm_password){

			$msg = Common::AlertErrorMsg('Danger','Password Mismatch.');
			Session::flash('message', $msg);
			return Redirect()->route('ChangePassword');
		
		}
		else{

		if($LoginValidate->password != $confirm_password )
		{

			$paaswordChangeStatus=DB::table('user_authentication_details')->where('email',$email)->update(array('password'=>$confirm_password));

			if($paaswordChangeStatus){
				$msg = Common::AlertErrorMsg('Success','Password Change Successfully .');
						Session::flash('message', $msg);
						return Redirect()->route('Login');

			}else{
				$msg = Common::AlertErrorMsg('Danger','Password Not Changed! Please Try Again.');
						Session::flash('message', $msg);
						return Redirect()->route('ChangePassword');

			}

		}
		else{


			$msg = Common::AlertErrorMsg('Success','Password Change Successfully .');
			Session::flash('message', $msg);
			return Redirect()->route('Login');


		}
	
		}
}
else{

	$msg = Common::AlertErrorMsg('Danger','Your account has been In-active.');
	Session::flash('message', $msg);
	return Redirect()->route('Login');
}
}
else{

	$msg = Common::AlertErrorMsg('Danger','Invalid email.');
	Session::flash('message', $msg);
	return Redirect()->route('Login');



}

}


public function userFrontLoginValidate(Request $request)
{


	$finalArray = array();

	$requestData = $request->all();
	
	$email = $request->email;
	// $password = $request->password;
	$password = md5($request->password);

$FrontLoginValidate = $this->LoginModel->FrontLoginValidate($email,$password);
	
	
 $cartCollection = \Cart::getContent();


	if(!empty($FrontLoginValidate))
		{
			if($FrontLoginValidate->status==1){

				Session::put('user_id', $FrontLoginValidate->id);
				Session::put('user_name', $FrontLoginValidate->first_name);
				Session::put('full_name', $FrontLoginValidate->first_name.' '.$FrontLoginValidate->last_name);
			    Session::put('user_email', $FrontLoginValidate->email);
                Session::put('user_login', 1);
				Session::save();
				
				
				   if(count($cartCollection) == 0)
			    {
		
				$msg = Common::AlertErrorMsg('Success','Login Successfully');
			    Session::flash('message', $msg);
			    return Redirect()->route('Home');	
			    
			    }else
			    {
			        
				$msg = Common::AlertErrorMsg('Success','Login Successfully');
			Session::flash('message', $msg);
			return Redirect()->route('Checkout');   
			    }
				
				

			}
			else
			{
			    
			$msg = Common::AlertErrorMsg('Danger','Your account has been De-active.');
			Session::flash('message', $msg);
			return Redirect()->route('Login');
			}
					
		   }
			else
			{
		
			$msg = Common::AlertErrorMsg('Danger','Email Or Password Invalid.');
			
			Session::flash('message', $msg);
			return Redirect()->route('Login');
		   }
		

}

public function UserContactSubmit(Request $request)
{
    	if(session('user_id'))
    	{
    	 
    	$requestData = $request->all();
        unset($requestData['_token']);
	    $Save['name'] = $requestData['name'];
	    $Save['user_id'] = session('user_id');
	    $Save['subject'] = $requestData['subject'];
		$Save['email'] 	= $requestData['email'];
		$Save['mobile'] = $requestData['mobile'];
		$address['message'] = $requestData['message'];
		$Save['created_at'] = date('Y-m-d H:i:s');
    	$Save['created_at'] = date('Y-m-d H:i:s');
    	
    	$result = DB::table('contact_page')->insert($Save);
    	
      if($result){
				$msg = Common::AlertErrorMsg('Success','Details Submited Successfully !');
					Session::flash('message', $msg);
			return Redirect()->route('Home');
			}else{
				$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
					Session::flash('message', $msg);
			return Redirect()->route('Contact');
			}
			
			
    	}
    	else
    	{
    	  
    	  return Redirect()->route('Login');
  
    	}
    	
    
}

	public function userRegistration(Request $request)
	{
		if($request->isMethod('post'))
		{
			$finalArray = array();
			$requestData = $request->all();
			unset($requestData['_token']);
			
		$Save['first_name'] = $requestData['first_name'];
		$Save['last_name'] 	= $requestData['last_name'];
		$Save['mobile'] 	= $requestData['mobile'];
		$Save['email'] 	= $requestData['email'];
		$Save['mobile'] = $requestData['mobile'];
		$Save['country_code'] = $requestData['country_code'];
/*		
		$address['street_Address'] = $requestData['street_Address'];
		$address['city'] = $requestData['city'];
		$address['state'] = $requestData['state'];
		$address['country'] = $requestData['country'];
		$address['pin_code'] = $requestData['pin_code'];
        $Save['address'] 	= json_encode($address);*/
        	
		$md5 = md5($requestData['confirm_password']);


		$Save['password'] 	= $md5;
		$Save['created_at'] 	= date('Y-m-d H:i:s');
		 
		/*$images=array();
		if(!empty($requestData['user_image'])){
			
			$Path = 'images';
			$name = $requestData['user_image']->getClientOriginalName();
			$requestData['user_image']->move($Path,$name);
			
			$images=$name;
			$Save['image'] = $name;
			
		}

		Session::put('address',$Save['address']);
        session()->save();*/

	$LoginValidate = $this->LoginModel->CheckUserEmail(['first_name','last_name','password','status'],$Save['email']);
	

	if($LoginValidate)
	{
	       
	        $msg = Common::AlertErrorMsg('Danger','Mail Id Already Exists.');
	    	Session::flash('message', $msg);
			return Redirect()->route('Register');
	    
	}
	else
	{
	       
	    	$EmailData['first_name'] = $requestData['first_name'];
			$EmailData['last_name'] = $requestData['last_name'];
			$EmailData['mobile'] = $requestData['mobile'];
			$EmailData['Email'] = $requestData['email'];
			$email = $requestData['email'];
		    $EmailData['Password'] = $requestData['confirm_password'];
		    
		    $subject = 'User Registration';

		    // $MailSendStatus = $this->UserRegistrationMail($EmailData,$subject);



		    
             //$Body =  $this->UserRegistrationHtml($EmailData);
            
            // $email='kanchanaggarwal1996@gmail.com';
        // $email='aftaba146@gmail.com';
        // $email='noreplysagabags@gmail.com';

       $MailStatus =  \Mail::to($email)->send(new UserRegistration($subject,$EmailData));

       // echo "<pre>";print_r($MailStatus);"</pre>";exit;


		//$MessageStatus=$this->sendMessage($requestData['mobile'],'register');
		//$whatsupMessageStatus=$this->sendWhatsupMessage($requestData['mobile'],'register');
	
		    
		/*if($MailStatus){
			$msg = Common::AlertErrorMsg('Success','We have e-mailed your password!');
			$status = 1;
		}else{
		    
			$msg = Common::AlertErrorMsg('Danger','Mail Error.');
			$status = 0;
		}*/
			
	   $Pro_id = $this->LoginModel->AddUserDetails($Save);
	    
	     if($Pro_id){
				$msg = Common::AlertErrorMsg('Success','User Registred Successfully !');
					Session::flash('message', $msg);
			return Redirect(route('Login'));
			}else{
				$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
					Session::flash('message', $msg);
			return Redirect()->route('Register');
			}
	    
	}
		

		}

	}
	

	
public function UserRegistrationHtml($EmailData)
{
	

	$html ='';
   


$html.='<html>';
$html.='<head>';
$html.='<meta charset="utf-8">';
$html.='<meta http-equiv="x-ua-compatible" content="ie=edge">';
$html.='<title>Recover Password</title>';
$html.='<meta name="viewport" content="width=device-width, initial-scale=1">';

	
$html.='</head>';
$html.='<body style="background-color: #EFF2F7;padding: 25px 0 !important;">';


$html.='<table border="0" cellpadding="0" cellspacing="0" width="100%">';

$html.='<tr>';
$html.='<td align="center" bgcolor="#e9ecef">';
$html.='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
$html.='<tr>';
$html.='<td align="center" valign="top" style="padding: 5px 5px;">';
		
$html.='</td>';
	$html.='</tr>';
  $html.='</table>';
$html.='</td>';
$html.='</tr>';

$html.='<td align="center" bgcolor="#e9ecef">';
  $html.='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
	$html.='<tr>';
	  $html.='<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">';
	  $html.='Dear '.$EmailData["first_name"].'<span>'.$EmailData["last_name"].'</span>,';
		$html.='<br/><br/>Here is your login details:-';
	  $html.='</td>';
	$html.='</tr>';
	$html.='<tr>';
	  $html.='<td height="53" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">';
	  $html.='Your Email Id: <b>'.$EmailData["Email"].'</b><br>';
	  $html.='Your Can Change your Password by Clicking on this link : <b></b>';
	  $html.='</td>';
  $html.='</tr> <br> <br>';
  $html.='<tr>';
	  $html.='<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">';
		$html.='<br>Warm regards, <br>';
		$html.='<strong> SAGA BANG </strong><br>';
		$html.='<br>';
	$html.='</td>';
  $html.='</tr>';
  $html.='</table>';
$html.='</td>';
$html.='</table>';
$html.='</body></html>';
return $html;
	
}
		
	 public function sendMessage($mobile ,$type)
    {
       
     $message = 'Congratulations You have successfully registered with Cure Root';
    //  $mobile = '7042481438';
     $smsmessage = rawurlencode($message);
     
		   	$ch = curl_init('http://sms.clickconnectmedia.in/http-tokenkeyapi.php?authentic-key=32394f4a415356494e3633351612865765&senderid=CUROOT&route=1&number='.$mobile.'&message='.$smsmessage);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);

      curl_close($ch);
     return 'success';  
     
    }
    	
	
	
	
		 public function sendWhatsupMessage($mobile ,$type)
    {
       
     $message = 'Congratulations You have successfully registered with Cure Root';
    //  $mobile = '7042481438';
     $smsmessage = rawurlencode($message);
     
		   	$ch = curl_init('http://promomessages.com/wapp/api/send?apikey=5062283bbb6b4d2d8bfa8a32ee59e150&mobile='.$mobile.'&msg='.$smsmessage.'');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			

	
		curl_close($ch);
		
        return 'success';  
    }
    
		
		
public function EditUserShippingAddress(Request $request)
{

$requestData = $request->all();


if($requestData['action'] == 'edit-shipping-address')
{

$userId = session('user_id');
$shippingAddres= array();
unset($requestData['_token']);

$Save['first_name'] = $requestData['first_name'];
$Save['last_name'] 	= $requestData['last_name'];
$Save['email'] 	= $requestData['email'];
$Save['mobile'] = $requestData['mobile'];
$Save['street_Address'] = $requestData['street_Address'];
$Save['city'] = $requestData['city'];
$Save['state'] = $requestData['state'];
$Save['country'] = $requestData['country'];
$Save['pin_code'] = $requestData['pin_code'];
$Save['address'] 	= json_encode($Save);



if(!empty(session('address')))
{
		Session::forget('address');
		Session::put('address',$Save['address']);
		Session::save();

}
else{

	Session::put('address',$Save['address']);
	Session::save();

}

$shippingAddress = array('shipping_address'=>$Save['address']);
DB::table('user_authentication_details')->where('id','=',$userId)->update($shippingAddress);
return Redirect()->route('Checkout');
}

}
	
	
public function UserShippingAddress(Request $request)
{

$requestData = $request->all();


if($requestData['action'] == 'add-address')
{

	if($requestData['address_type'] == 'ShippingAddress')
	{
		$userId = $requestData['user_id'];
		$usersInfo = $this->productModel->getUserInfoByUserId($userId);
		Session::put('add_address_for_checkout', 'ShippingAddress');
        Session::put('address', $usersInfo->shipping_address);
		Session::save();
		$finalArray = array('status'=>'success');
print_r(json_encode($finalArray));
exit();
}
else{

    $userId = $requestData['user_id'];
	$usersInfo = $this->productModel->getUserInfoByUserId($userId);
	Session::put('add_address_for_checkout', 'DeliveryAddress');
	Session::put('address', $usersInfo->address);
	Session::save();
	$finalArray = array('status'=>'success');
print_r(json_encode($finalArray));
exit();

}
					 
}
else
{

$userId = session('user_id');
$shippingAddres= array();
unset($requestData['_token']);

$Save['first_name'] = $requestData['first_name'];
$Save['last_name'] 	= $requestData['last_name'];
$Save['email'] 	= $requestData['email'];
$Save['mobile'] = $requestData['mobile'];
$address['street_Address'] = $requestData['street_Address'];
$address['city'] = $requestData['city'];
$address['state'] = $requestData['state'];
$address['country'] = $requestData['country'];
$address['pin_code'] = $requestData['pin_code'];
$Save['street_Address'] = $requestData['street_Address'];
$Save['city'] = $requestData['city'];
$Save['state'] = $requestData['state'];
$Save['country'] = $requestData['country'];
$Save['pin_code'] = $requestData['pin_code'];


$Save['address'] 	= json_encode($Save);
// print_r($Save['address']);
// exit();

if(!empty(session('user_name')))
{
		Session::forget('user_name');
		Session::put('user_name',$requestData['first_name'].$requestData['last_name']);
		Session::save();

}
else{

	Session::put('user_name',$requestData['first_name'].$requestData['last_name']);
		Session::save();

}


 if(!empty(session('user_email')))
{
		Session::forget('user_email');
		Session::put('user_email',$requestData['email']);
		Session::save();
}
else{

	Session::put('user_email',$requestData['email']);
	Session::save();

}
if(!empty(session('user_phone')))
{
		
	Session::forget('user_phone');
		Session::put('user_phone',$requestData['mobile']);
		Session::save();


}
else{

	Session::put('user_phone',$requestData['mobile']);
	Session::save();


}
if(!empty(session('address')))
{
		Session::forget('address');
		Session::put('address',$Save['address']);
		Session::save();

}
else{

	Session::put('address',$Save['address']);
	Session::save();

}

$shippingAddress = array('shipping_address'=>$Save['address']);
DB::table('user_authentication_details')->where('id','=',$userId)->update($shippingAddress);
return Redirect()->route('Checkout');

}

}

	
// public function UserRegistrationHtml($EmailData)
// {
	
 
// 	$html ='';
//   $html.='<html>';
// $html.='<head>';
// $html.='<meta charset="utf-8">';
// $html.='<meta http-equiv="x-ua-compatible" content="ie=edge">';
// $html.='<title>Recover Password</title>';
// $html.='<meta name="viewport" content="width=device-width, initial-scale=1">';
// $html.='</head>';
// $html.='<body style="background-color: #e9ecef;">';
//   $html.='<table border="0" cellpadding="0" cellspacing="0" width="100%">';

//     $html.='<tr>';
//       $html.='<td align="center" bgcolor="#e9ecef">';
//       $html.=' <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
//           $html.='<tr>';
//             $html.='<td align="center" valign="top" style="padding: 5px 5px;">';
              
//             $html.='</td>';
//           $html.='</tr>';
//         $html.='</table>';
//       $html.='</td>';
//     $html.='</tr>';
//     $html.='<tr>';
//       $html.='<td align="center" bgcolor="#e9ecef">';
//       $html.=' <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">';
//           $html.='<tr>';
//             $html.='<td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Dear '.$EmailData["first_name"].'<span   style="padding-left:5px;" >'.$EmailData["last_name"].',';
//              $html.=' <br/><br/><b>Congratulations.</b> You have successfully registered with the following details:.';
//           $html.=' </td>';
//          $html.=' </tr>';
//           $html.='<tr>';
//             $html.='<td height="53" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">';
//               $html.='Your Email Id: <b>'.$EmailData["Email"].'</b><br>';
//               $html.='Your Password: <b>'.$EmailData["Password"].'</b>';
//             $html.='</td>';
//         $html.='</tr> <br> <br>';
//       $html.=' <tr>';
//           $html.=' <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;"><br>Warm regards, <br>';
//              $html.=' <strong>CureRoot</strong><br>';
//               $html.='<br>';
//           $html.='</td>';
//         $html.='</tr>';
//         $html.='</table>';
//      $html.='</td>';
//     $html.='</tr>';
//   $html.='</table>';
// $html.='</body>

// </html>';

// 	return $html;
	
// }
	
	
public function UserEditProfile(Request $request)
{
	$requestData = $request->all();


	 $UserId = session('user_id');
	
	$Save['first_name'] 		= $requestData['first_name'];
	$Save['last_name'] 			= $requestData['last_name'];
	$Save['mobile'] 			= $requestData['mobile'];
	
        $address['street_Address'] = $requestData['street_Address'];
		$address['city'] = $requestData['city'];
		$address['state'] = $requestData['state'];
		$address['country'] = $requestData['country'];
		$address['pin_code'] = $requestData['pin_code'];
        $Save['address'] 	= json_encode($address);
	

    $images=array();
	if(!empty($requestData['image'])){
		
		$Path = 'images';
		$name = $requestData['image']->getClientOriginalName();
		$requestData['image']->move($Path,$name);
		$images=$name;
		$Save['image'] = $name;
		
	}
	
$EditPro_id = $this->LoginModel->UserEditProfile($Save,$UserId);

if($EditPro_id){
		$msg = Common::AlertErrorMsg('Success','Profile Details Has been Updated.');
	}else{
		$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
	}
	Session::flash('message', $msg);
	
	return Redirect()->route('userProfile');

}


public function UserChangePassword(Request $request){
	
	$Data = $request->all();
	$old_password 	= $Data['old_password'];
	$userId = Session::get('user_id');
	$Setting = DB::table('user_authentication_details')->where('id',$userId)->first();
	if($Setting->password != $old_password){
		$msg = Common::AlertErrorMsg('Danger','Old password mismatch.');
				
	}else{
		$Save['password'] 			= md5($Data['confirm_password']);
         DB::table('user_authentication_details')->where('id',$userId)->update($Save);
		$msg = Common::AlertErrorMsg('Success','Password Change Successfully');
	
	} 
	Session::flash('message', $msg);
    return Redirect()->route('userProfile');
    
}


	public function Register(Request $request){


		$Data['Title'] 					= 'User Register';
		$Data['Menu'] 					= '';
		$Data['DivClass'] 				= 'register';
		$Data['Settings']               = $this->HomeModel->Settings();
		$Data['Category']               = $this->productModel->CategoryList();
		$Data['CategoryA']               = $this->productModel->CategoryAList();
		$Data['manuPage']               = $this->productModel->manuPage();
        $Data['notification'] = $this->productModel->getProductNotification();
        //$Data['pincode'] = DB::table('pincode')->select('*')->get();

        if(session('locale')=='en'){
        	return view('en-SA/Front.register')->with($Data);
	    }
	    else{
	        return view('ar-SA/Front.register')->with($Data);
	    }

		//return View('Front.register',compact('Data'))->with($Data);
	}

	public function ForgotPassword(){

		$Data['Title'] 					= 'Forgot Password';
		$Data['Menu'] 					= '';
		$Data['DivClass'] 				= 'forgot';
		$Data['Settings']               = $this->HomeModel->Settings();
		$Data['Category']               = $this->productModel->CategoryList();
		$Data['CategoryA']              = $this->productModel->CategoryAList();
		$Data['manuPage']               = $this->productModel->manuPage();
        $Data['notification'] = $this->productModel->getProductNotification();

		
		if(session('locale')=='en'){
			return view('New.forget-pass',compact('Data'))->with($Data);
	    }
	    else{
	        return view('New.forget-pass-ar',compact('Data'))->with($Data);
	    }
	}


	public function ChangePassword(){

		$Data['Title'] 					= 'Change Password';
		$Data['Menu'] 					= '';
		$Data['DivClass'] 				= 'forgot';
		$Data['Settings']               = $this->HomeModel->Settings();
		$Data['Category']               = $this->productModel->CategoryList();
		$Data['CategoryA']               = $this->productModel->CategoryAList();
		$Data['manuPage']               = $this->productModel->manuPage();
        $Data['notification'] = $this->productModel->getProductNotification();

		return View('New.change-pass',compact('Data'))->with($Data);
	}

	




	public function CheckUserLogin(Request $request){
		$Data = $request->all();
		$email = $Data['LoginEmail'];
		$Password = $Data['LoginPassword'];		

		$LoginValidate = $this->LoginModel->CartUserLogin($email,$Password);
		if(!empty($LoginValidate))
		{
			if($LoginValidate->status==1){
				Session::put('user_id', $LoginValidate->id);
				Session::put('user_name', ucfirst($LoginValidate->name));
				Session::put('user_email', $LoginValidate->email);
				Session::put('user_login', 1);
				Session::save();
				$msg 	= Common::AlertErrorMsg('Success','Login Successfully');
				$status = 1;
			}else{
				$msg 	= Common::AlertErrorMsg('Danger','Your account has been In-active.');
				$status = 0;
			}
			
		}else{
			$msg 		= Common::AlertErrorMsg('Danger','Invalid Current Password.');
			$status = 0;
    }
		$arr['status'] 	= $status;
		$arr['msg'] 	= $msg;
		echo json_encode($arr);
		exit();
	}

	public function InsertRegisterUser(Request $request){
		$Data = $request->all();
		$name   		= $Data['name'];
	    $email        	= $Data['email'];
	    $password     	= $Data['password'];
	    
	    if($name==''){
	      $arr['msg']     = Common::AlertErrorMsg('Danger','Please enter name.');
	      $arr['status']  = 0;
	      echo json_encode($arr);
	      exit();
	    }
	    if($email==''){
	      $arr['msg']     = Common::AlertErrorMsg('Danger','Please enter email.');
	      $arr['status']  = 0;
	      echo json_encode($arr);
	      exit();
	    }
	    if($password==''){
	      $arr['msg']     = Common::AlertErrorMsg('Danger','Please enter password.');
	      $arr['status']  = 0;
	      echo json_encode($arr);
	      exit();
	    }  
	    
	    $CountEmail = $this->LoginModel->CountUserWhere(['email'=>$email]);
	    if($CountEmail>0){
	      $arr['msg']    = Common::AlertErrorMsg('Danger','Sorry Email already exist!!!!');
	      $arr['status'] = 0; 
	      echo json_encode($arr);
	      exit();
	    }

	    $Save['name'] 					= $name;
		$Save['email'] 					= $email;
		$Save['password'] 				= $password;
		$Save['created_at'] 			= date('Y-m-d H:i:s');

		$Result = $this->LoginModel->AddUser($Save);
		if($Result){
			$user = $this->LoginModel->CheckUserEmail(['id','name','email','password','status'],$email);
			
			$EmailData['Name'] = ucfirst($user->name);
			$EmailData['Email'] = $user->email;
			$EmailData['Password'] = $user->password;
			$subject = 'Registration Saka Maka';
			$Body = view('Emailer.Registration',$EmailData);
	    	$MailStatus = Common::SendMail($email, 'info@sakamaka.co.in', '', '', $subject, $Body);

			Session::put('user_id', $user->id);
			Session::put('user_name', ucfirst($user->name));
			Session::put('user_email', $user->email);
			Session::put('user_login', 1);
			Session::save();
			$arr['status'] 	= 1;
			$arr['msg'] 		= Common::AlertErrorMsg('Success','Registration Successfully.');
		}else{
			$arr['status'] 	= 0;
			$arr['msg'] 		= Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		echo json_encode($arr);
		exit();
	}
	
	public function UserLogout(Request $request)
	{
		session()->regenerate();
        Session::forget('user_id');
		Session::forget('user_name');
		Session::forget('user_email');
		Session::forget('user_login');
		Session::forget('user_image');
		Session::forget('user_icon');
        return Redirect()->route('Home');

	}


public function ChangeWebLanguage(Request $request)
{

$requestData= $request->all();

if(Session::has('locale')){

	Session::put('locale',$requestData['language']);
	Session::save();
	\App::setLocale(\Session::get('locale'));
  
  }
  else{

  Session::put('locale','ar');
  Session::save();
\App::setLocale(\Session::get('locale'));

  }


$finalArray = array('status'=>'success');
  print_r(json_encode($finalArray));
  exit();


}


}