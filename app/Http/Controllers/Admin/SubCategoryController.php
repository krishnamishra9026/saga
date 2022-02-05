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
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\SubCategoryModel;
use App\Http\Models\Admin\CategoryModel;

use Illuminate\Routing\ResponseFactory;
use App\Helpers\Common;


class SubCategoryController extends Controller
{

    public function __construct(Request $request)
	{		
		$this->CategoryModel = new CategoryModel();
		$this->SubCategoryModel = new SubCategoryModel();

	}

    public function SubCategory(){
		
		$Data['Title'] 		= 'Sub Category List';
		$Data['Menu'] 		= 'SubCategory';
		$Data['SubMenu'] 	= 'SubCategory';
		$Data['SelectMenu'] = 'SubCategory';
		$Data['Category'] = $this->SubCategoryModel->SubCategoryListWithCategory();

		// print_r($Data);
		// exit();

		return View('Admin/SubCategory/List')->with($Data);

    }
    public function AddSubCategory(){
		$Data['Title'] 		= 'Add Sub Category';
		$Data['Menu'] 		= 'SubCategory';
		$Data['SubMenu'] 	= 'SubCategory';
		$Data['SelectMenu'] = 'SubCategory';
		$Data['Category'] = $this->CategoryModel->CategoryList();
		$Data['Language'] = $this->CategoryModel->Language();

		return View('Admin/SubCategory/Add')->with($Data);
    }
    

    public function InsertSubCategory(Request $request){
		$Data = $request->all();
		$Save['name'] 	= $Data['name'];
		$Save['status'] = $Data['status'];
		$Save['category_id'] = $Data['category_id'];
		$Save['language_id'] = $Data['language_id'];
		$Save['sub_category_slug'] = $Data['sub_category_slug'];
        $Save['created_at'] 	= date('Y-m-d H:i:s');


        if(!empty($Data['subcategory_images'])){
			$image = $Data['subcategory_images'];
			$Path = 'upload/sub-category';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}
		
		$Pro_id = $this->SubCategoryModel->AddSubCategory($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Sub Category Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('SubCategory');
    }
    

    public function EditSubCategory($id){
		$Id = base64_decode($id);
		$CheckID = $this->SubCategoryModel->CheckSubCategory(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->SubCategoryModel->GetSubCategory($Id);
		$Data['Result'] 	= $Result;
		$Data['Category'] = $this->CategoryModel->CategoryList();
		$Data['Language'] = $this->CategoryModel->Language();

		$Data['Title'] 		= 'Edit Sub Category';
		$Data['Menu'] 		= 'SubCategory';
		$Data['SubMenu'] 	= 'SubCategory';
		$Data['SelectMenu'] = 'SubCategory';
		return View('Admin/SubCategory/Edit')->with($Data);
    }

    public function SaveSubCategory(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];

		$Save['status'] = $Data['status'];
		$Save['name'] = $Data['name'];
		$Save['category_id'] = $Data['category_id'];
		$Save['language_id'] = $Data['language_id'];
		$Save['sub_category_slug'] = $Data['sub_category_slug'];

		$Save['updated_at'] = date('Y-m-d H:i:s');

		if(!empty($Data['subcategory_images'])){
			$image = $Data['subcategory_images'];
			$Path = 'upload/sub-category';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}

		$Result = $this->SubCategoryModel->UpdateSubCategory($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Sub Category Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('SubCategory');
    }

    public function DeleteSubCategory($ID){
		$id = base64_decode($ID);
		DB::table('sub-category')->where('id',$id)->delete();	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
    }
    
    //
}
