<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class MenuModel extends Model 
{
  
  public function MenuList()
  {
    $result = DB::table('menubars')->get();
    return $result; 
  }

  public function CheckMenuName($data){
    $result = DB::table('menubars')->where($data)->count();
    return $result;
  }

  public function AddMenu($Details){
    $result=DB::table('menubars')->insertGetId($Details);
    return $result; 
  }

  public function CheckMenuEditName($data,$ID){
    $result = DB::table('menubars')->where($data)->where('id','!=',$ID)->count();
    return $result;
  }

  public function UpdateMenu($id,$data){
    $result = DB::table('menubars')->where('id',$id)->update($data);
    return true;
  }

  public function GetMenuDetails($id)
  {
    return DB::table('menubars')->select('*')->where('id',$id)->first();
  }

}