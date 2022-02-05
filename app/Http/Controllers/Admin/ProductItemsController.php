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
use App\Http\Models\Admin\ProductItemModel;
use App\Http\Models\Admin\CategoryModel;

use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class ProductItemsController extends Controller 
{
	public function __construct(Request $request)
	{				

		$this->ProductItemModel = new ProductItemModel();
		$this->CategoryModel = new CategoryModel();
	}

	public function Product(){
		$Data['Title'] 				= 'Product List';
		$Data['Menu'] 				= 'Product';
		$Data['SubMenu'] 			= 'Product';
        $Data['SelectMenu']   		= 'Product';
        $Data['Result']   			= $this->ProductItemModel->ProductList();
        
return View('Admin/Product/List')->with($Data);

	    
	}

	public function AddProduct(){
		$Data['Title'] 				= 'Add Product';
		$Data['Menu'] 				= 'Product';
		$Data['SubMenu'] 			= 'Product';
		$Data['SelectMenu']   = 'Product';
        $Data['categories']   = DB::table('category')->select('*')->get();
		$Data['subCategories']   = DB::table('sub-category')->select('*')->get();
		$Data['color']   = DB::table('colors')->select('*')->get();
		$Data['Language'] = $this->CategoryModel->Language();


		return View('Admin/Product/AddProduct')->with($Data);
	}
	public function EditProduct($ID){

		$id = base64_decode($ID);
		$CheckID = $this->ProductItemModel->CheckProductName(['id'=>$id]);
		if($CheckID==0){
			return Redirect()->back();
		}
        $Result 			= $this->ProductItemModel->GetProductDetails($id);
        $Data['Result'] 	= $Result;
		$Data['categories']   = DB::table('category')->select('*')->get();
	    $Data['subCategories']   = DB::table('sub-category')->select('sub-category.id','sub-category.name')->where('category_id','=',$Result->category_id)->first();
	    //$Data['sizes']   = DB::table('sizes')->select('sizes.id','sizes.name')->where('id','=',$Result->size_id)->first();
	    //$Data['color']   = DB::table('colors')->select('colors.id','colors.name')->where('id','=',$Result->color_id)->first();
	    $Data['color']   = DB::table('colors')->select('*')->get();
        $Data['Language'] = $this->CategoryModel->Language();
        $Data['Title'] 		= 'Edit Product';
		$Data['Menu'] 		= 'Product';
		$Data['SubMenu'] 	= 'Product';
		$Data['SelectMenu'] = 'Product';
		return View('Admin/Product/EditProduct')->with($Data);

	}

	public function InsertProduct(Request $request){
		
		$Data = $request->all();
		
		$Save['serial_no'] 			= $Data['serial_no'];
		$Save['name'] 				= $Data['name'];
		$Save['name_slug'] 			= $Data['product_slug'];
		$Save['price'] 				= $Data['price'];
		$Save['quantity'] 			= $Data['quantity'];
		$Save['discription']  		= $Data['product_discription'];
		$Save['short_discription'] 	= $Data['product_short_discription'];
        $Save['discount_title']     = $Data['discount_title'];
        $Save['discount_price'] 	= $Data['discount_price'];
		$Save['discount_percent']   = $Data['discount_percent'];
        $Save['category_id'] 		= $Data['category_id'];
        $Save['sub_category_id'] 	= $Data['sub_category_id'];
        $Save['size'] 				= $Data['size_id'];
        $Save['color'] 				= $Data['color_id'];
        $Save['weight'] 			= $Data['weight_products'];
        $Save['material'] 			= $Data['material_products'];
        $Save['start_rating'] 		= $Data['start_rating'];
        $Save['in_stock'] 			= $Data['in_stock'];
		$Save['language_id']    	= $Data['language_id'];
        $Save['sku_id'] 	    	= $Data['sku_id'];
		$Save['status'] 			= $Data['status'];
        $Save['created_at'] 		= date('Y-m-d H:i:s');
		$Save['updated_at'] 		= date('Y-m-d H:i:s');

		/*if(!empty($Save['discount_title']) && !empty($Save['discount_price']))
		{

			$percentPrice  = $Save['discount_price']/100;
		$discountAmount = $percentPrice*$Save['price'];

		$discountPrice = $Save['price']-$discountAmount;
		$Save['discount_price']  = $discountPrice;

		}else
		{


		}*/

		/*echo "<pre>";
		print_r($Save);
		die;*/

		if(!empty($Data['product_images'])){
			$image = $Data['product_images'];
			$Path = 'upload/prd';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}

        $images=array();
		if($files=$request->file('product_gallery_images')){
			$Path = 'upload/prd';
			foreach($files as $file){
				$extension = strtoupper($file->getClientOriginalName());
				
				$name = 'IMG_'.date('YmdHis').$extension;
				
				$file->move($Path,$name);
				$images[]=$name;
				
			}
			$multipleimg = implode("|",$images);
		
			$Save['images'] = $multipleimg;
		}
	
		$Pro_id = $this->ProductItemModel->AddProduct($Save);
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
		

		$EditID	= $Data['id'];
		$Save['serial_no'] 			= $Data['serial_no'];
		$Save['name'] 				= $Data['name'];
		$Save['name_slug'] 			= $Data['product_slug'];
		$Save['price'] 				= $Data['price'];
		$Save['quantity'] 			= $Data['quantity'];
		$Save['discription']  		= $Data['product_discription'];
		$Save['short_discription'] 	= $Data['product_short_discription'];
        $Save['discount_title']     = $Data['discount_title'];
        $Save['discount_price'] 	= $Data['discount_price'];
		$Save['discount_percent']   = $Data['discount_percent'];
        $Save['category_id'] 		= $Data['category_id'];
        $Save['sub_category_id'] 	= $Data['sub_category_id'];
        $Save['size'] 				= $Data['size_id'];
        $Save['color'] 				= $Data['color_id'];
        $Save['weight'] 			= $Data['weight_products'];
        $Save['material'] 			= $Data['material_products'];
        $Save['start_rating'] 		= $Data['start_rating'];
        $Save['in_stock'] 			= $Data['in_stock'];
		$Save['language_id']    	= $Data['language_id'];
        $Save['sku_id'] 	    	= $Data['sku_id'];
		$Save['status'] 			= $Data['status'];
        $Save['created_at'] 		= date('Y-m-d H:i:s');
		$Save['updated_at'] 		= date('Y-m-d H:i:s');

		/*echo "<pre>";
		print_r($Save);
		die;*/

		if(!empty($Data['product_images'])){
			$image = $Data['product_images'];
			$Path = 'upload/prd';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}

	    $images=array();
		if($files=$request->file('product_gallery_images')){
			$Path = 'upload/prd';
			foreach($files as $file){
				$extension = strtoupper($file->getClientOriginalName());
				$name = 'IMG_'.date('YmdHis').$extension;
				$file->move($Path,$name);
				$images[]=$name;
			}
			$multipleimg = implode("|",$images);
			$Save['images'] = $multipleimg;
		}

		/*if(!empty($Save['discount_title']) && !empty($Save['discount_amount']))
		{
		
			$percentPrice  = $Save['discount_amount']/100;
		$discountAmount = $percentPrice*$Save['price'];
		
		$discountPrice = $Save['price']-$discountAmount;
		$Save['discount_price']  = $discountPrice;
		
		}else{
		
		}*/
		
	

		$Result = $this->ProductItemModel->UpdateProduct($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Product Details Updated Has been Saved.');
		Session::flash('message', $msg);
		return Redirect()->route('Product');
	}

	public function ProductChangeStatus(Request $request){
		$Data 	= $request->all();
		$id 		= $Data['id'];
		$status = $Data['status'];
		$this->ProductItemModel->UpdateProduct($id,['status'=>$status]);
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
		$Data['Categories'] = $this->ProductItemModel->CategoriesList();
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
		
		
		$Pro_id = $this->ProductItemModel->AddCategories($Save);
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
		$CheckID = $this->ProductItemModel->CheckCategories(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->ProductItemModel->GetCategories($Id);
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

		$Result = $this->ProductItemModel->UpdateCategories($EditID,$Save);
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

public function RemoveProductImg(Request $request)
{
	$finlImageArray = array();
	$requestData = $request->all();

$imageDetails = DB::table('products')->select('images')->where('id',$requestData['productId'])->first();	
$imageArray =  explode('|',$imageDetails->images);

	
foreach (array_keys($imageArray, $requestData['img']) as $key) {
    unset($imageArray[$key]);
}


if(empty($imageArray)){
  
  DB::table('products')->where('id','=',$requestData['productId'])->update(array('images' => NULL));
  
}
else
{

$finlImageArray= implode('|',$imageArray);
DB::table('products')->where('id','=',$requestData['productId'])->update(array('images' => $finlImageArray));

    
}

return Redirect()->route('Product');

}

public function FetchSubCategoryList(Request $request)
{

if($request->isMethod('post')){
	$finalArray = array();

$requestData = $request->all();
$categoryId = $requestData['categoryId'];
$subcat=DB::table('sub-category')->where('category_id',$categoryId)->get();	
$concern=DB::table('category-concern-map')->select('category-concern-map.concern_id')->where('category-concern-map.category_id','=',$categoryId)->get();	
$conIdArray=array();
foreach($concern as $con)
{
$conIdArray[] = $con->concern_id;
}

$concernDetails=DB::table('concern')->whereIn('id',$conIdArray)->get();	
$subConcernHtml = $this->getConcernHtml($concernDetails);
$subCateoryHtml = $this->getSubCategoryHtml($subcat);
$finalArray= array('status'=>'success',
'data_sub'=>$subCateoryHtml,
'data_con'=>$subConcernHtml
);
print_r(json_encode($finalArray));
exit();
}

}

private function getConcernHtml($concern)
{
$html='';
$html='<option value="1">Select</option>';

foreach($concern as $rs)
{
$html .='<option value="'.$rs->id.'">'.$rs->name.'</option>';

}

return $html;

}

private function getSubCategoryHtml($result)
{
$html='';
$html='<option value="">Select</option>';

foreach($result as $rs)
{
$html .='<option value="'.$rs->id.'">'.$rs->name.'</option>';

}

return $html;

}


public function getproductListSlug(Request $request)
{
	$RequestData = $request->all();

	$productSlug=DB::table('products')->select('name_slug','id')->get();	
	$productSlugHtml = $this->getproductSlugHtml($productSlug);
	$finalArray= array('status'=>'success',
	'product_slug'=>$productSlugHtml,
	);
	print_r(json_encode($finalArray));
	exit();


}

private function getproductSlugHtml($productSlug)
{
$html='';
$html='<option value="">Select</option>';

foreach($productSlug as $rs)
{
$html .='<option value="'.$rs->name_slug.'">'.$rs->name_slug.'</option>';

}

return $html;

}



}