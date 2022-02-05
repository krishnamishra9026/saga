<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class CategoryModel extends Model 
{
  public function CategoryList(){
    $Result = DB::table('category')->get();
    return $Result;
  }

  public function ConcernList(){
    $Result = DB::table('concern')->get();
    return $Result;
  }
  
  public function AddCategory($Details){
    $result=DB::table('category')->insertGetId($Details);
    return $result; 
  }
  public function UpdateCategory($id,$data){
    $result = DB::table('category')->where('id',$id)->update($data);
    return true;
  }
  public function CheckCategory($data){
    $result = DB::table('category')->where($data)->count();
    return $result;
  }
  public function GetCategory($id)
  {
    $result = DB::table('category')->select('*')->where('id',$id)->first();
    return $result;
  }

public function Language()
{
 
    $Result = DB::table('language')->get();
    return $Result;

}

}