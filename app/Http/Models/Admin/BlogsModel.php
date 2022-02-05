<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class BlogsModel extends Model 
{
  public function BlogsList(){
    $Result = DB::table('blogs')->get();
    return $Result;
  }
  public function AddBlog($Details){
    $result=DB::table('blogs')->insertGetId($Details);
    return $result; 
  }

  public function Updateblogs($id,$data){
    $result = DB::table('blogs')->where('blog_id',$id)->update($data);
    return true;
  }

  public function Checkblogs($data){
    $result = DB::table('blogs')->where($data)->count();
    return $result;
  }
  
  public function Getblogs($id)
  {
    $result = DB::table('blogs')->select('*')->where('blog_id',$id)->first();
    return $result;
  }



}