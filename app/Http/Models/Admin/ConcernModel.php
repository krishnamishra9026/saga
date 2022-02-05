<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class ConcernModel extends Model 
{
  

  public function ConcernList(){
    $Result = DB::table('concern')->join('category-concern-map','concern.id','=','category-concern-map.concern_id')->distinct()->get();
    return $Result;
  }
  
  public function AddConcern($Details){
    $result=DB::table('concern')->insertGetId($Details);
    return $result; 
  }
  public function AddMapOfCategoryConcern($categoryConcernMap){
    $result=DB::table('category-concern-map')->insertGetId($categoryConcernMap);
    return $result; 
  }
  


  public function UpdateConcern($id,$data){
    	
    $categoryConcernMap = array('category_id'=>$data['category_id'],
    'language_id'=>$data['language_id'],
    'concern_id'=>$id,
    'status'=>$data['status']
  );
  $finalArray = array('name'=>$data['name'],'status'=>$data['status'],'concern_slug'=>$data['concern_slug']);
  $result = DB::table('concern')->where('id','=',$id)->update($finalArray);
  $result1 = DB::table('category-concern-map')->where('concern_id',$id)->where('category_id',$data['category_id'])->update($categoryConcernMap);
  return true;
  
  }
  
  
  public function CheckConcern($data){
    $result = DB::table('concern')->where($data)->count();
    return $result;
  }
  public function GetConcern($id)
  {
    $result = DB::table('concern')->join('category-concern-map','concern.id','=','category-concern-map.concern_id')->select('*')->where('concern_id',$id)->first();
    return $result;
  }

public function Language()
{
 
    $Result = DB::table('language')->get();
    return $Result;

}

}