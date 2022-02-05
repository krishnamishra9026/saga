<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class OurCustomersModel extends Model 
{
  public function OurCustomersList(){
    $Result = DB::table('user_comment')->get();
    return $Result;
  }
  
    public function ReviewList(){
    $Result = DB::table('user_rating')->get();
    return $Result;
  }
  
    public function CommentList(){
    $Result = DB::table('user_comment')->get();
    return $Result;
  }
  
  public function AddOurCustomers($Details){
    $result=DB::table('ourcustomers')->insertGetId($Details);
    return $result; 
  }
  public function UpdateOurCustomers($id,$data){
    $result = DB::table('ourcustomers')->where('id',$id)->update($data);
    return true;
  }
  public function CheckOurCustomers($data){
    $result = DB::table('ourcustomers')->where($data)->count();
    return $result;
  }
  public function GetOurCustomers($id)
  {
    $result = DB::table('ourcustomers')->select('*')->where('id',$id)->first();
    return $result;
  }



}