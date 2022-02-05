<?php
namespace App\Http\Models\Front;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProductsModel extends Model 
{
	protected $table = 'products';
	
	public function CategoryDetails($Select,$Id)
	{
		$Result = DB::table('product_categories')->select($Select)->where('status',1)->where('id',$Id)->first();
		return $Result;
	}

	public function SubCategoryList($Select,$Id)
	{
		$Result = DB::table('product_categories')->select($Select)->where('status',1)->where('cat_parent',$Id)->get();
		return $Result;
	}

	public function MainCategoryList($Select)
	{
		$Result = DB::table('product_categories')->select($Select)->where('cat_parent',0)->where('status',1)->get();
		return $Result;
	}
	public function ProductGallery($Proid)
	{
		$Result = DB::table('product_gallery')->select('gallery_image_name')->where('product_id',$Proid)->get();
		return $Result;
	}
	public function GetProductIDArray($Catid)
	{
		$Result = DB::table('pro_categories')->where('sub_cat_id',$Catid)->pluck('product_id');
		return $Result;
	}
	public function GetProductListWhereIN($Select,$ProductIDArr)
	{
		$Result = DB::table('products')
								->select($Select)
								->whereIn('id',$ProductIDArr)
								->where('status',1)
								->where('product_stock','In stock')
								->orderByRaw("RAND()")
								->orderBy('id','desc')
								->get();
		return $Result;
	}

	public function ProductFilterList($start,$numofrecords,$Search,$ProductIDArr){
    $Data = DB::table('products');
    if($Search['lower']!=''){
      $Data->whereBetween('price',[$Search['lower'],$Search['upper']]);
    }
    if($Search['SortBy']!='All'){
      $Data->orderBy('price',$Search['SortBy']);
    }else{
    	$Data->orderBy('id','desc');
    }
    $Data->where('status',1);
    $Data->where('product_stock','In stock');
    $Data->whereIn('id',$ProductIDArr);
    $Data->select('*');
    $Res['Count'] = $Data->count();
    $Res['Res']   = $Data->offset($start)->limit($numofrecords)->get();
    return $Res;
  }

  public function ProductDetails($Proid)
	{
		$Result = DB::table('products')->select('*')->where('status',1)->where('id',$Proid)->first();
		return $Result;
	}
	public function CountProduct($Proid)
	{
		$Result = DB::table('products')->where('product_stock','In stock')->where('status',1)->where('id',$Proid)->count();
		return $Result;
	}

	public function CartProductDetails($Proid,$UserId)
	{
		$Result = DB::table('cart')->select('*')->where('user_id',$UserId)->where('product_id',$Proid)->first();
		return $Result;
	}
	
	public function getProduct($Proid)
	{
		$Result = DB::table('products')->select('*')->where('id',$Proid)->first();
		return $Result;
	}
	

}