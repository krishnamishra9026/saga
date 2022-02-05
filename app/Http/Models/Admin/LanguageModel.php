<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class LanguageModel extends Model
{
   
   public function languageList()
   {

$Result = DB::table('language')->get();
return $Result;

   }

   public function AddLanguage($Details){
    $result=DB::table('language')->insertGetId($Details);
    return $result; 
  }

  public function CheckLanguage($data){
    $result = DB::table('language')->where($data)->count();
    return $result;
  }
  
  public function GetLanguage($id)
  {
    $result = DB::table('language')->select('*')->where('id',$id)->first();
    return $result;
  }
  
  public function UpdateLanguage($id,$data){
    $result = DB::table('language')->where('id',$id)->update($data);
    return true;
  }
  
  
  //Notification

  public function NotificationList()
   {

$Result = DB::table('notification_list')->get();
return $Result;

   }

   public function AddNotification($Details){
    $result=DB::table('notification_list')->insertGetId($Details);
    return $result; 
  }

  public function CheckNotification($data){
    $result = DB::table('notification_list')->where($data)->count();
    return $result;
  }
  
  public function GetNotification($id)
  {
    $result = DB::table('notification_list')->select('*')->where('notification_id',$id)->first();
    return $result;
  }
  
  public function UpdateNotification($id,$data){
    $result = DB::table('notification_list')->where('notification_id',$id)->update($data);
    return true;
  }
  
  
}
