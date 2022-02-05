<?php

namespace App\Http\Controllers\Admin;
use Route;
use Mail;
use Auth, Hash;
use Validator;
use Session;
use Redirect;
use DB;
use Crypt;
use Illuminate\Http\Request;
use App\Http\Models\Admin\LanguageModel;
use App\Http\Models\Admin\CategoryModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class NotificationController extends Controller
{
    public function __construct(Request $request)
	{		
		$this->LanguageModel = new LanguageModel();
        $this->CategoryModel = new CategoryModel();

    }
    
    public function Notification(){
		
		$Data['Title'] 		= 'Notification List';
		$Data['Menu'] 		= 'Notification';
		$Data['SubMenu'] 	= 'Notification';
		$Data['SelectMenu'] = 'Notification';
		$Data['Notification'] = $this->LanguageModel->NotificationList();
		$Data['Language'] = $this->CategoryModel->Language();

     
        return View('Admin/Notification/List')->with($Data);

    }
    
    public function AddNotification()
    {
        $Data['Title'] 		= 'Add Notification';
		$Data['Menu'] 		= 'Notification';
		$Data['SubMenu'] 	= 'Notification';
        $Data['SelectMenu'] = 'Notification';
        $Data['Language'] = $this->CategoryModel->Language();
      
        return View('Admin/Notification/Add')->with($Data);


    }
public function InsertNotification(Request $request)
{
    $Data = $request->all();
     
    $Data['Title'] 		= 'Add Notification';
    $Data['Menu'] 		= 'Notification';
    $Data['SubMenu'] 	= 'Notification';
    $Data['SelectMenu'] = 'Notification';
    
    $Save['language_id'] = $Data['language_id'];
    $Save['notification_title'] = $Data['notification_title'];
    $Save['status'] = $Data['status'];
    $Save['notification_add_date'] = date('Y-m-d H:i:s');
   
    
    $Pro_id = $this->LanguageModel->AddNotification($Save);
    if($Pro_id){
        $msg = Common::AlertErrorMsg('Success','Notification Has been Saved.');
    }else{
        $msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
    }
    Session::flash('message', $msg);
    return Redirect()->route('Notification');

}

public function EditNotification($id)
{

    $Id = base64_decode($id);
     
    $CheckID = $this->LanguageModel->CheckNotification(['notification_id'=>$Id]);
 
    if($CheckID==0){
        return Redirect()->back();
    }
    $Result 			= $this->LanguageModel->GetNotification($Id);
    $Data['Language'] = $this->CategoryModel->Language();
    $Data['Result'] 	= $Result;
    $Data['Title'] 		= 'Edit Notification';
    $Data['Menu'] 		= 'Notification';
    $Data['SubMenu'] 	= 'Notification';
    $Data['SelectMenu'] = 'Notification';
    // print_r($Data);
    // exit();
    return View('Admin/Notification/Edit')->with($Data);

}

public function SaveNotification(Request $request)
{

	$Data = $request->all();
		$EditID	= $Data['id'];
 
        $Save['language_id'] = $Data['language_id'];
        $Save['notification_title'] = $Data['notification_title'];
        $Save['status'] = $Data['status'];
        $Save['updated_at'] = date('Y-m-d H:i:s');

		$Result = $this->LanguageModel->UpdateNotification($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Notification Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Notification');


}

public function DeleteNotification($ID){
    $id = base64_decode($ID);
    DB::table('notification_list')->where('notification_id',$id)->delete();	

    $msg = Common::AlertErrorMsg('Success','Delete Successfully.');
    Session::flash('message', $msg);
    return Redirect()->back();
}
    //
}
