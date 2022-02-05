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
use App\Helpers\Common;

class MenuController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->MenuModel = new MenuModel();
		$this->CategoryModel = new CategoryModel();
		
	}

	public function Menu(){
		$Data['Title'] 				= 'Menu List';
		$Data['Menu'] 				= 'Menu';
		$Data['SubMenu'] 			= 'Menu';
		$Data['SelectMenu']   		= 'Menu';
		$Data['Result']   			= $this->MenuModel->MenuList();

		return View('Admin/Menu/List')->with($Data);
	}

	public function AddMenu(){
		$Data['Title'] 				= 'Add Menu';
		$Data['Menu'] 				= 'Menu';
		$Data['SubMenu'] 			= 'Menu';
		$Data['SelectMenu']   = 'Menu';
		$Data['categories']   = DB::table('category')->select('*')->get();
		$Data['Language'] = $this->CategoryModel->Language();
		return View('Admin/Menu/AddMenu')->with($Data);
	}
	public function EditMenu($ID){
		$id = base64_decode($ID);
		$CheckID = $this->MenuModel->CheckMenuName(['id'=>$id]);

		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->MenuModel->GetMenuDetails($id);
				
		$Data['Result'] 	= $Result;
		$Data['Language'] = $this->CategoryModel->Language();
		$Data['Title'] 		= 'Edit Menu';
		$Data['Menu'] 		= 'Menu';
		$Data['SubMenu'] 	= 'Menu';
		$Data['SelectMenu'] = 'Menu';
		return View('Admin/Menu/EditMenu')->with($Data);
	}

	public function InsertMenu(Request $request){
		$Data = $request->all();
		
	
		$Save['name'] 			= $Data['name'];
		$Save['slug'] 			= $Data['slug'];
        $Save['page_discription'] = $Data['page_discription'];
        $Save['language_id'] 	= $Data['language_id'];
		$Save['status'] 		= $Data['status'];
        $Save['created_at'] 	= date('Y-m-d H:i:s');
		$Save['updated_at'] 	= date('Y-m-d H:i:s');
	
		$Pro_id = $this->MenuModel->AddMenu($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Menu Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Menu');
	}

	public function SaveMenu(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];

	    $Save['name'] 			= $Data['name'];
		$Save['slug'] 			= $Data['slug'];
        $Save['page_discription'] = $Data['page_discription'];
        $Save['language_id'] 	= $Data['language_id'];
		$Save['status'] 		= $Data['status'];
		$Save['updated_at'] 	= date('Y-m-d H:i:s');
		
		$Result = $this->MenuModel->UpdateMenu($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Menu Details Has been Saved.');
		Session::flash('message', $msg);
		return Redirect()->route('Menu');
	}

	public function MenuChangeStatus(Request $request){
		$Data 	= $request->all();
		$id 	= $Data['id'];
		$status = $Data['status'];
		$this->MenuModel->UpdateMenu($id,['status'=>$status]);
	}

	public function DeleteMenu($ID){
		$id = base64_decode($ID);
		$affected = DB::table('menubars')
              ->where('id', $id)
              ->delete();
              	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
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