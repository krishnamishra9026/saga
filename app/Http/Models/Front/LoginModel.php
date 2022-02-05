<?php
namespace App\Http\Models\Front;
use Illuminate\Database\Eloquent\Model;
use DB;

class LoginModel extends Model 
{
	public function CartUserLogin($email,$Password)
	{
		$LoginDetails=DB::table('users')->where('email',$email)->where('password',$Password)->first();
    	return $LoginDetails;
	}

	public function CheckUserEmail($Select,$Email)
	{
		$LoginDetails=DB::table('user_authentication_details')->select($Select)->where('email',$Email)->first();
    	return $LoginDetails;
	}

	public function LocationList()
	{
		$Result=DB::table('location')->select('*')->where('status',1)->orderBy('sort','ASC')->get();
    	return $Result;
	}

	public function CountUserWhere($Where)
	{
		$Count = DB::table('users')->where($Where)->count();
    	return $Count;
	}
	public function GetUserDetails($Select,$Where)
	{
		$Result = DB::table('users')->select($Select)->where($Where)->first();
    	return $Result;
	}
	public function AddUser($Details){
		$result = DB::table('users')->insertGetId($Details);
    	return $result;
	}

	public function AddUserDetails($Save){
		$result=DB::table('user_authentication_details')->insertGetId($Save);
		return $result; 
	  }

	  public function FrontLoginValidate($Email,$Password)
	{
		
		$LoginDetails=DB::table('user_authentication_details')->where('email','=',$Email)->where('password','=',$Password)->first();
	
    return $LoginDetails;
	}

	public function UserEditProfile($Save,$UserId)
	{
	$EditProfileDetails=DB::table('user_authentication_details')->where('id','=',$UserId)->update($Save);
    return $EditProfileDetails;
	}


}