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
use App\Http\Models\Admin\CategoryModel;
use App\Http\Models\Admin\ConcernModel;
use App\Http\Models\Admin\SubCategoryModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class CategoryController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->ConcernModel = new ConcernModel();
		$this->CategoryModel = new CategoryModel();
		$this->SubCategoryModel = new SubCategoryModel();
	}

	public function Category(){
		
		$Data['Title'] 		= 'Category List';
		$Data['Menu'] 		= 'Category';
		$Data['SubMenu'] 	= 'Category';
		$Data['SelectMenu'] = 'Category';
		$Data['Category'] = $this->CategoryModel->CategoryList();
		$Data['Language'] = $this->CategoryModel->Language();

return View('Admin/Category/List')->with($Data);

	}
	public function Concern(){
		
		$Data['Title'] 		= 'Concern List';
		$Data['Menu'] 		= 'Concern';
		$Data['SubMenu'] 	= 'Concern';
		$Data['SelectMenu'] = 'Concern';
		$Data['Concern'] = $this->ConcernModel->ConcernList();
		$Data['Language'] = $this->ConcernModel->Language();
		return View('Admin/Concern/List')->with($Data);

	}
	public function AddConcern(){
		$Data['Title'] 		= 'Add Concern';
		$Data['Menu'] 		= 'Concern';
		$Data['SubMenu'] 	= 'Concern';
		$Data['SelectMenu'] = 'Concern';
		$Data['Language'] = $this->ConcernModel->Language();
		$Data['Category'] = $this->CategoryModel->CategoryList();
        return View('Admin/Concern/Add')->with($Data);
	}

	public function EditConcern($id){
		$Id = base64_decode($id); 

		$CheckID = $this->ConcernModel->CheckConcern(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->ConcernModel->GetConcern($Id);
		$Data['Language'] = $this->ConcernModel->Language();
		$Data['Category'] = $this->CategoryModel->CategoryList();
        $Data['Result'] 	= $Result;
        $Data['Title'] 		= 'Edit Concern';
		$Data['Menu'] 		= 'Concern';
		$Data['SubMenu'] 	= 'Concern';
		$Data['SelectMenu'] = 'Concern';
		return View('Admin/Concern/Edit')->with($Data);
		
	}

	public function SaveConcern(Request $request){
		$Data = $request->all();
        $EditID	= $Data['edit_id'];
        $Save['language_id'] 	= $Data['language_id'];
		$Save['category_id'] 	= $Data['category_id'];
		$Save['concern_slug'] 	= $Data['concern_slug'];
        $Save['status'] = $Data['status'];
		$Save['name'] = $Data['name'];
		$Save['updated_at'] = date('Y-m-d H:i:s');
        $Result = $this->ConcernModel->UpdateConcern($EditID,$Save);
				// 	dd($Result);

		$msg = Common::AlertErrorMsg('Success','Concern Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Concern');
		
	}

	public function InsertConcern(Request $request){
		$Data = $request->all();
		$categoryConcernMap = array();
        $Save['name'] 	= $Data['name'];
        $Save['status'] = $Data['status'];
		$Save['created_at'] 	= date('Y-m-d H:i:s');
		$Save['concern_slug'] 	= $Data['concern_slug'];
	   $Pro_id = $this->ConcernModel->AddConcern($Save);
	   
	 $categoryConcernMap = array('category_id'=>$Data['category_id'],
	'language_id'=>$Data['language_id'],
	'concern_id'=>$Pro_id,
	'status'=>$Data['status']
);
$Map_id = $this->ConcernModel->AddMapOfCategoryConcern($categoryConcernMap);



		if($Map_id){
			$msg = Common::AlertErrorMsg('Success','Concern Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Concern');
	}

	public function AddCategory(){
		$Data['Title'] 		= 'Add Category';
		$Data['Menu'] 		= 'Category';
		$Data['SubMenu'] 	= 'Category';
		$Data['SelectMenu'] = 'Category';
		$Data['Language'] = $this->CategoryModel->Language();

		return View('Admin/Category/Add')->with($Data);
	}

	public function InsertCategory(Request $request){
		$Data = $request->all();
		$Save['category_name'] 	= $Data['category_name'];
		$Save['language_id'] 	= $Data['language_id'];
		$Save['category_slug'] 	= $Data['category_slug'];
        $Save['status'] = $Data['status'];
        $Save['gst'] = $Data['gst'];
        
		$Save['created_at'] 	= date('Y-m-d H:i:s');

		if(!empty($Data['category_images'])){
			$image = $Data['category_images'];
			$Path = 'upload/category';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}

		$Pro_id = $this->CategoryModel->AddCategory($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Category Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Category');
	}

	public function EditCategory($id){
		$Id = base64_decode($id);
		$CheckID = $this->CategoryModel->CheckCategory(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->CategoryModel->GetCategory($Id);
		$Data['Language'] = $this->CategoryModel->Language();

		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Category';
		$Data['Menu'] 		= 'Category';
		$Data['SubMenu'] 	= 'Category';
		$Data['SelectMenu'] = 'Category';
		return View('Admin/Category/Edit')->with($Data);
	}

	public function SaveCategory(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];
		$Save['language_id'] 	= $Data['language_id'];
		$Save['category_slug'] 	= $Data['category_slug'];

		$Save['status'] = $Data['status'];
		$Save['category_name'] = $Data['category_name'];
		$Save['gst'] = $Data['gst'];
		$Save['updated_at'] = date('Y-m-d H:i:s');

		if(!empty($Data['category_images'])){
			$image = $Data['category_images'];
			$Path = 'upload/category';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}

		$Result = $this->CategoryModel->UpdateCategory($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Category Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Category');
	}

	public function DeleteCategory($ID){
		$id = base64_decode($ID);
		DB::table('category')->where('id',$id)->delete();	
		DB::table('category-concern-map')->where('category_id',$id)->delete();	
		DB::table('sub-category')->where('category_id',$id)->delete();	

		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}


	public function DeleteConcern($ID){
		$id = base64_decode($ID);
		$concernId=	DB::table('category-concern-map')->select('concern_id')->where('id',$id)->first();	

	
	
		DB::table('concern')->where('id','=',$concernId->concern_id)->delete();	
		
		
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

	public function AddCategoryInSubCategory($ID)
	{
		$id = base64_decode($ID);
		$Data['Title'] 		= 'Add Category';
		$Data['Menu'] 		= 'Category';
		$Data['SubMenu'] 	= 'Category';
		$Data['SelectMenu'] = 'Category';
		$Result 			= $this->CategoryModel->GetCategory($id);
		$Data['Result'] 	= $Result;
		$Data['subCategories'] = $this->SubCategoryModel->SubCategoryList();



		return View('Admin/Category/Add-Sub-Category')->with($Data);


	}
	public function AddCategoryInConcern($ID)
	{
		$id = base64_decode($ID);
		$Data['Title'] 		= 'Add Category';
		$Data['Menu'] 		= 'Category';
		$Data['SubMenu'] 	= 'Category';
		$Data['SelectMenu'] = 'Category';
		$Result 			= $this->CategoryModel->GetCategory($id);
		$Data['Result'] 	= $Result;
		$Data['Concern'] = $this->CategoryModel->ConcernList();
		$Data['Language'] = $this->CategoryModel->Language();


		return View('Admin/Category/Add-Concern')->with($Data);

	}
	public function InsertConcernInCategory(Request $request){
		
		$Data = $request->all();
		$Save['category_name'] 	= $Data['category_name'];
		$Save['language_id'] 	= $Data['language_id'];
		$Save['sub_category_id'] 	= $Data['sub_category_id'];
        $Save['status'] = $Data['status'];
		$Save['created_at'] 	= date('Y-m-d H:i:s');

	

		$Pro_id = $this->CategoryModel->AddCategory($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Concern Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Category');
	}


}