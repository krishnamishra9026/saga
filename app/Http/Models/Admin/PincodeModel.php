<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;

class PincodeModel extends Model 
{
  
  public function PincodeList()
  {
    $result = DB::table('pincode')->get();
    return $result; 
  }

  public function CheckPincode($data){
    $result = DB::table('pincode')->where($data)->count();
    return $result;
  }

  public function AddPincode($Details){
    $result=DB::table('pincode')->insertGetId($Details);
    return $result; 
  }

  public function CheckPincodeEditName($data,$ID){
    $result = DB::table('pincode')->where($data)->where('id','!=',$ID)->count();
    return $result;
  }

  public function UpdatePincode($id,$data){
    $result = DB::table('pincode')->where('id',$id)->update($data);
    return true;
  }

  public function GetPincodeDetails($id)
  {
    return DB::table('pincode')->select('*')->where('id',$id)->first();
  }

}