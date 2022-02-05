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
use App\Http\Models\Admin\MenuModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\CategoryModel;
use App\Http\Models\Admin\PincodeModel;
use App\Helpers\Common;


class PincodeController  extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->pincodeModel = new PincodeModel();
		$this->CategoryModel = new CategoryModel();
		
	}

	public function Menu(){
		$Data['Title'] 				= 'Pincode List';
		$Data['Menu'] 				= 'Pincode';
		$Data['SubPincode'] 			= 'Pincode';
		$Data['SelectPincode']   		= 'Pincode';
		$Data['Result']   			= $this->pincodeModel->PincodeList();
		return View('Admin/pincode/List')->with($Data);
	}

	public function AddPincode(){
		$Data['Title'] 				= 'Add Pincode';
		$Data['Menu'] 				= 'Pincode';
		$Data['SubPincode'] 			= 'Pincode';
		$Data['SelectPincode']          = 'Pincode';
	
		return View('Admin/pincode/AddPincode')->with($Data);
	}
	public function EditPincode($ID){
		$id = base64_decode($ID);
		$CheckID = $this->pincodeModel->CheckPincode(['id'=>$id]);

		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->pincodeModel->GetPincodeDetails($id);
		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Pincode';
		$Data['Menu'] 		= 'Pincode';
		$Data['SubMenu'] 	= 'Pincode';
		$Data['SelectMenu'] = 'Pincode';
		return View('Admin/pincode/EditPincode')->with($Data);
	}

	public function InsertPincode(Request $request){
		$Data = $request->all();

	foreach($Data['pincode'] as $key=>$value)
	{
        $Save['pincode'] 			= $value;
	    $Save['created_at'] 	= date('Y-m-d H:i:s');
        $this->pincodeModel->AddPincode($Save);

	    
	}
	     $msg = Common::AlertErrorMsg('Success','Pincode Has been Saved.');
		 Session::flash('message', $msg);
		return Redirect()->route('Pincode');
	}

	public function SavePincode(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];

	    $Save['pincode'] 			= $Data['pincode'];
	    $Save['created_at'] 	= date('Y-m-d H:i:s');
		
		$Result = $this->pincodeModel->UpdatePincode($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Pincode Has been Saved.');
		Session::flash('message', $msg);
		return Redirect()->route('Pincode');
	}

	public function MenuChangeStatus(Request $request){
		$Data 	= $request->all();
		$id 	= $Data['id'];
		$status = $Data['status'];
		$this->MenuModel->UpdateMenu($id,['status'=>$status]);
	}

	public function DeletePincode($ID){
		$id = base64_decode($ID);
		$affected = DB::table('pincode')
              ->where('id', $id)
              ->delete();
              	
		$msg = Common::AlertErrorMsg('Success','Pincode Deleted Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

	public function Categories(){
		
		$Data['Title'] 		= 'Categories List';
		$Data['Menu'] 		= 'Categories';
		$Data['SubMenu'] 	= 'Categories';
		$Data['SelectMenu'] = 'Categories';
		$Data['Categories'] = $this->MenuModel->CategoriesList();
		return View('Admin/Categories/List')->with($Data);

	}

	public function AddCategories(){
		$Data['Title'] 		= 'Add Categories';
		$Data['Menu'] 		= 'Categories';
		$Data['SubMenu'] 	= 'Categories';
		$Data['SelectMenu'] = 'Categories';
		return View('Admin/Categories/AddCategories')->with($Data);
	}

	public function InsertCategories(Request $request){
		$Data = $request->all();
		$Save['name'] 	= $Data['name'];
		$Save['status'] = $Data['status'];
		
		
		$Pro_id = $this->MenuModel->AddCategories($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Categories Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Categories');
	}

	public function EditCategories($id){
		$Id = base64_decode($id);
		$CheckID = $this->MenuModel->CheckCategories(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->MenuModel->GetCategories($Id);
		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Brandlink';
		$Data['Menu'] 		= 'Categories';
		$Data['SubMenu'] 	= 'Categories';
		$Data['SelectMenu'] = 'Categories';
		return View('Admin/Categories/EditCategories')->with($Data);
	}

	public function SaveCategories(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];

		$Save['status'] = $Data['status'];
		$Save['name'] = $Data['name'];

		$Result = $this->MenuModel->UpdateCategories($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Categories Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Categories');
	}

	public function DeleteCategories($ID){
		$id = base64_decode($ID);
		
		DB::table('category')->where('id',$id)->delete();	
		
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

}