<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class UserModel extends Model 
{
	public function UsersListing(){
    $Result = DB::table('user_authentication_details')->get();
    return $Result;
  }
  public function CountUser($Where){
    $Count = DB::table('users')->where($Where)->count();
    return $Count;
  }
  public function GetUserDetails($Select,$Where){
    $Result = DB::table('users')->select($Select)->where($Where)->first();
    return $Result;
  }

}