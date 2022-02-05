<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class ProductItemModel extends Model 
{
  
  public function ProductList()
  {
    $result = DB::table('products')->get();
    return $result; 
  }

  public function CheckProductName($data){
    $result = DB::table('products')->where($data)->count();
    return $result;
  }

  public function AddProduct($Details){
    $result=DB::table('products')->insertGetId($Details);
    return $result; 
  }

  public function CheckProductEditName($data,$ID){
    $result = DB::table('products')->where($data)->where('id','!=',$ID)->count();
    return $result;
  }

  public function UpdateProduct($id,$data){
    $result = DB::table('products')->where('id',$id)->update($data);
    return true;
  }

  public function GetProductDetails($id)
  {
    return DB::table('products')->select('*')->where('id',$id)->first();
  }

}