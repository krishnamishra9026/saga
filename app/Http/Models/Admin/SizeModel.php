<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class SizeModel extends Model 
{
  public function SizeList(){
    $Result = DB::table('sizes')->get();
    return $Result;
  }
  public function AddSize($Details){
    $result=DB::table('sizes')->insertGetId($Details);
    return $result; 
  }
  public function UpdateSize($id,$data){
    $result = DB::table('sizes')->where('id',$id)->update($data);
    return true;
  }
  public function CheckSize($data){
    $result = DB::table('sizes')->where($data)->count();
    return $result;
  }
  public function GetSize($id)
  {
    $result = DB::table('sizes')->select('*')->where('id',$id)->first();
    return $result;
  }



}