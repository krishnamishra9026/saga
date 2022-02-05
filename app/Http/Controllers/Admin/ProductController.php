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
use App\Http\Models\Admin\ProductModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class ProductController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->ProductModel = new ProductModel();
	}

	public function Product(){
		$Data['Title'] 				= 'Product List';
		$Data['Menu'] 				= 'Product';
		$Data['SubMenu'] 			= 'Product';
		$Data['SelectMenu']   		= 'Product';
		$Data['Result']   			= $this->ProductModel->ProductList();
		return View('Admin/Product/List')->with($Data);
	}

	public function AddProduct(){
		$Data['Title'] 				= 'Add Product';
		$Data['Menu'] 				= 'Product';
		$Data['SubMenu'] 			= 'Product';
		$Data['SelectMenu']   = 'Product';
		$Data['categories']   = DB::table('category')->select('*')->get();
		return View('Admin/Product/AddProduct')->with($Data);
	}
	public function EditProduct($ID){
		$id = base64_decode($ID);
		$CheckID = $this->ProductModel->CheckProductName(['id'=>$id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->ProductModel->GetProductDetails($id);
		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Product';
		$Data['Menu'] 		= 'Product';
		$Data['SubMenu'] 	= 'Product';
		$Data['SelectMenu'] = 'Product';
		return View('Admin/Product/EditProduct')->with($Data);
	}

	public function InsertProduct(Request $request){
		$Data = $request->all();
		$Save['name'] 			= $Data['name'];
		$Save['price'] 			= $Data['price'];
		$Save['sku_id'] 			= $Data['sku_id'];

		
		$Save['category'] 		= $Data['category'];
		$Save['description'] 	= $Data['description'];
		$Save['sku_id'] 		= $Data['sku_id'];
		$Save['status'] 		= $Data['status'];
		$Save['created_at'] 	= date('Y-m-d H:i:s');
		$Save['updated_at'] 	= date('Y-m-d H:i:s');
		
		$images=array();
		if($files=$request->file('images')){
			$Path = 'upload/product/multipleimg';
			foreach($files as $file){
				$extension = strtoupper($file->getClientOriginalName());
				$name = 'IMG_'.date('YmdHis').$extension;
				$file->move($Path,$name);
				$images[]=$name;
			}
			$multipleimg = implode("|",$images);
			$Save['images'] = $multipleimg;
		}
		
		$Pro_id = $this->ProductModel->AddProduct($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Product Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->back();
	}

	public function SaveProduct(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];

		$Save['name'] 			= $Data['name'];
		$Save['price'] 			= $Data['price'];
		$Save['sku_id'] 		= $Data['sku_id'];

		$Save['category'] 		= $Data['category'];
		$Save['description'] 	= $Data['description'];
		$Save['sku_id'] 		= $Data['sku_id'];
		$Save['status'] 		= $Data['status'];
		$Save['updated_at'] 	= date('Y-m-d H:i:s');
		
		$images=array();
		if($files=$request->file('images')){
			$Path = 'upload/product/multipleimg';
			foreach($files as $file){
				$extension = strtoupper($file->getClientOriginalName());
				$name = 'IMG_'.date('YmdHis').$extension;
				$file->move($Path,$name);
				$images[]=$name;
			}
			$multipleimg = implode("|",$images);
			$Save['images'] = $multipleimg;
		}

		$Result = $this->ProductModel->UpdateProduct($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Product Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Product');
	}

	public function ProductChangeStatus(Request $request){
		$Data 	= $request->all();
		$id 		= $Data['id'];
		$status = $Data['status'];
		$this->ProductModel->UpdateProduct($id,['status'=>$status]);
	}

	public function DeleteProduct($ID){
		$id = base64_decode($ID);
		$affected = DB::table('products')
              ->where('id', $id)
              ->update(['status' => '0']);
              	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

	public function Categories(){
		
		$Data['Title'] 		= 'Categories List';
		$Data['Menu'] 		= 'Categories';
		$Data['SubMenu'] 	= 'Categories';
		$Data['SelectMenu'] = 'Categories';
		$Data['Categories'] = $this->ProductModel->CategoriesList();
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
		
		
		$Pro_id = $this->ProductModel->AddCategories($Save);
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
		$CheckID = $this->ProductModel->CheckCategories(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->ProductModel->GetCategories($Id);
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

		$Result = $this->ProductModel->UpdateCategories($EditID,$Save);
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