<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class OffersModel extends Model 
{
  public function OffersList(){
    $Result = DB::table('offers')->get();
    return $Result;
  }
  public function AddOffers($Details){
    $result=DB::table('offers')->insertGetId($Details);
    return $result; 
  }
  public function UpdateOffers($id,$data){
    $result = DB::table('offers')->where('id',$id)->update($data);
    return true;
  }
  public function CheckOffers($data){
    $result = DB::table('offers')->where($data)->count();
    return $result;
  }
  public function GetOffers($id)
  {
    return DB::table('offers')->select('*')->where('id',$id)->first();
  }

  public function GSTList()
  {
    return DB::table('gst')->select('*')->get();
  }
  public function AddGst($Save){
    $result=DB::table('gst')->insertGetId($Save);
    return $result; 
  }
  public function CheckGst($data){
    $result = DB::table('gst')->where($data)->count();
    return $result;
  }
  public function GetGst($id)
  {
    return DB::table('gst')->select('*')->where('id',$id)->first();
  }
  public function UpdateGst($id,$data){
    $result = DB::table('gst')->where('id',$id)->update($data);
    return true;
  }
}