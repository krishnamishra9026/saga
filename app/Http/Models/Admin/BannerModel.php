<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class BannerModel extends Model 
{
  public function BannerList(){
    $Result = DB::table('banner')->get();
    return $Result;
  }
  public function AddBanner($Details){
    $result=DB::table('banner')->insertGetId($Details);
    return $result; 
  }
  public function UpdateBanner($id,$data){
    $result = DB::table('banner')->where('id',$id)->update($data);
    return $result;
  }
  public function CheckBannerName($data){
    $result = DB::table('banner')->where($data)->count();
    return $result;
  }
  public function GetBannerDetails($id)
  {
    return DB::table('banner')->select('*')->where('id',$id)->first();
  }

}