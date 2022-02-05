<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class ColorModel extends Model 
{
  public function ColorList(){
    $Result = DB::table('colors')->get();
    return $Result;
  }
  public function AddColor($Details){
    $result=DB::table('colors')->insertGetId($Details);
    return $result; 
  }
  public function UpdateColor($id,$data){
    $result = DB::table('colors')->where('id',$id)->update($data);
    return true;
  }
  public function CheckColor($data){
    $result = DB::table('colors')->where($data)->count();
    return $result;
  }
  public function GetColor($id)
  {
    $result = DB::table('colors')->select('*')->where('id',$id)->first();
    return $result;
  }



}