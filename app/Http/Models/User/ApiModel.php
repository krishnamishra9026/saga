<?php
namespace App\Http\Models\User;
use Illuminate\Database\Eloquent\Model;
use DB;
class ApiModel extends Model 
{
	public function InsertUser($Details){
    $result = DB::table('users')->insert($Details);
    return true;
  }
  
  public function UserLogin($email,$Password){
    $LoginDetails=DB::table('users')
        ->where('email',$email)
        ->orWhere('username', $email)
        ->where('password',$Password)
        ->first();
    return $LoginDetails;
  }

  public function CheckUserEmail($Select,$Email){
    $LoginDetails=DB::table('users')->select($Select)->where('email',$Email)->first();
    return $LoginDetails;
  }
  
  public function CountUser($Where){
    $Count = DB::table('users')->where($Where)->count();
    return $Count;
  }
  public function LocationList(){
    $Result = DB::table('location')->select('id','location')->where('status',1)->orderBy('sort','ASC')->get();
    return $Result;
  }
  public function GetKYCDetails($user_id){
    $Result = DB::table('user_kyc')->where('user_id',$user_id)->first();
    return $Result;
  }

  public function GetUserDetails($Select,$Where){
    $Result = DB::table('users')->select($Select)->where($Where)->first();
    return $Result;
  }
}