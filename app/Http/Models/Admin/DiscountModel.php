<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class DiscountModel extends Model 
{
  public function DiscountList(){
    $Result = DB::table('discount')->get();
    return $Result;
  }
  public function AddDiscount($Details){
    $result=DB::table('discount')->insertGetId($Details);
    return $result; 
  }
  public function UpdateDiscount($id,$data){
    $result = DB::table('discount')->where('id',$id)->update($data);
    return true;
  }
  public function CheckDiscount($data){
    $result = DB::table('discount')->where($data)->count();
    return $result;
  }
  public function GetDiscount($id)
  {
    return DB::table('discount')->select('*')->where('id',$id)->first();
  }



}