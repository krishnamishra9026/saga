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
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class LanguageController extends Controller
{
    public function __construct(Request $request)
	{		
		$this->LanguageModel = new LanguageModel();
    }
    
    public function language(){
		
		$Data['Title'] 		= 'language List';
		$Data['Menu'] 		= 'language';
		$Data['SubMenu'] 	= 'language';
		$Data['SelectMenu'] = 'language';
		$Data['Category'] = $this->LanguageModel->languageList();

		

		return View('Admin/Language/List')->with($Data);

    }
    
    public function AddLanguage()
    {
        $Data['Title'] 		= 'Add Language';
		$Data['Menu'] 		= 'Language';
		$Data['SubMenu'] 	= 'Language';
        $Data['SelectMenu'] = 'Language';
        
		return View('Admin/Language/Add')->with($Data);


    }


    public function InsertLanguage(Request $request)
{
    $Data = $request->all();

    $Data['Title'] 		= 'Add Language';
    $Data['Menu'] 		= 'Language';
    $Data['SubMenu'] 	= 'Language';
    $Data['SelectMenu'] = 'Language';
    
    $Save['language_name'] 	= $Data['language_name'];
    $Save['language_slug'] 	= $Data['language_slug'];
    $Save['status'] = $Data['status'];
    $Save['created_at'] 	= date('Y-m-d H:i:s');
   
    
    $Pro_id = $this->LanguageModel->AddLanguage($Save);
    if($Pro_id){
        $msg = Common::AlertErrorMsg('Success','Language Has been Saved.');
    }else{
        $msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
    }
    Session::flash('message', $msg);
    return Redirect()->route('Language');

}

public function EditLanguage($id)
{

    $Id = base64_decode($id);
    $CheckID = $this->LanguageModel->CheckLanguage(['id'=>$Id]);
   if($CheckID==0){
        return Redirect()->back();
    }
    $Result 			= $this->LanguageModel->GetLanguage($Id);
    $Data['Result'] 	= $Result;
    $Data['Title'] 		= 'Edit Language';
    $Data['Menu'] 		= 'Language';
    $Data['SubMenu'] 	= 'Language';
    $Data['SelectMenu'] = 'Language';
   
    return View('Admin/Language/Edit')->with($Data);

}


public function SaveLanguage(Request $request)
{
        $Data = $request->all();
        $EditID	= $Data['id'];
        $Save['language_name'] 	= $Data['language_name'];
        $Save['language_slug'] 	= $Data['language_slug'];
        $Save['status'] = $Data['status'];
        $Save['updated_at'] = date('Y-m-d H:i:s');
        $Result = $this->LanguageModel->UpdateLanguage($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Language Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Language');

}
    //
}
