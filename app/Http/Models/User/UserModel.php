<?php
namespace App\Http\Models\User;
use Illuminate\Database\Eloquent\Model;
use DB;
class UserModel extends Model 
{
  public function GetUserDetails($id){
    $Result = DB::table('users')->where('id',$id)->first();
		return $Result;
	}
	public function Settings()
	{
		$Result = DB::table('admin')->where('status','1')->first();
		return $Result;
	}
		public function add($id,$Address)
	{
	 $result = DB::table('users')->insert($Address)->where('id',$id);
    return $result;
	}
	 
}