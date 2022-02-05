<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class SubCategoryModel extends Model
{
    public function SubCategoryList(){
        $Result = DB::table('sub-category')->get();
        return $Result;
      }
      public function AddSubCategory($Details){
        $result=DB::table('sub-category')->insertGetId($Details);
        return $result; 
      }
      public function UpdateSubCategory($id,$data){
        $result = DB::table('sub-category')->where('id',$id)->update($data);
        return true;
      }
      public function CheckSubCategory($data){
        $result = DB::table('sub-category')->where($data)->count();
        return $result;
      }
      public function GetSubCategory($id)
      {
        $result = DB::table('sub-category')->select('*')->where('id',$id)->first();
        return $result;
      }

      public function SubCategoryListWithCategory()
      {
        $result = DB::table('category')
        ->join('sub-category', function($join)
        {
            $join->on('category.id', '=', 'sub-category.category_id');
              
        })
        ->get();

        // DB::table('sub-category')->join('category','sub-category.category_id','=','category.id')->get();
        return $result;

      }
    
    //
}
