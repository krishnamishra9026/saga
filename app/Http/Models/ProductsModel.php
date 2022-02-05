<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
 
class ProductsModel extends Model
{
 
 public function CategoryList()
 {
     $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
     $Result = DB::table('category')->where('status','=','1')->where('language_id','=',$languageId->id)->orderBy('show_order', 'ASC')->get();
     return $Result;
  }

  public function CategoryListShowOrder()
 {
     $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
     $Result = DB::table('category')->where('status','=','1')->where('language_id','=',$languageId->id)->orderBy('show_order', 'ASC')->get();
     return $Result;
  }

public function CategoryAList()
 {
     $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
     $Result = DB::table('category')->where('status','=','1')->where('language_id','=',$languageId->id)->orderBy('show_order', 'DESC')->get();
     return $Result;
  }

  public function CategoryAListShowOrder()
 {
     $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
     $Result = DB::table('category')->where('status','=','1')->where('language_id','=',$languageId->id)->orderBy('show_order', 'DESC')->get();
     return $Result;
  }

 public function SubcategoryList()
 {
     $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
     $Result = DB::table('sub-category')->where('status','=','1')->where('language_id','=',$languageId->id)->get();
     return $Result;
  }

  public function SubcategoryListSortBy()
 {
     $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
     $Result = DB::table('sub-category')->where('status','=','1')->where('language_id','=',$languageId->id)->orderBy('show_order')->get();
     return $Result;
  }

public function getUserInfoByUserId($userId){

    $Result = DB::table('user_authentication_details')->select('address','mobile','shipping_address')->where('id','=',$userId)->first();
    return $Result;

}

public function geGstByCategoryId($categoryId)
{
  
$result = DB::table('category')->select('gst')->where('id','=',$categoryId)->first();
return $result;
    
}



public function getProductNotification()
{

$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
$result = DB::table('notification_list')->select('*')->where('status','=','1')->where('language_id','=',$languageId->id)->get();
return $result;


}


public function AddOrdersDetails($orderDetails)
{

$result= DB::table('orders')->insertGetId($orderDetails);
return $result;

}


    
    public function getProductBannerList()
    {
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
$Result = DB::table('banner')->select('*')->where('status','=','1')->orderBy('id', 'DESC')->where('language_id','=',$languageId->id)->get();

return $Result;


    }
    

public function MenuPageDetails($page)
    {
        
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $Result = DB::table('menubars')->select('*')->where('slug','=',$page)->where('status','=','1')->where('language_id','=',$languageId->id)->orderBy('id', 'DESC')->first();
        return $Result;


    }
    
    public function manuPage()
    {

$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
$Result = DB::table('menubars')->select('*')->where('status','=','1')->orderBy('id', 'ASC')->where('language_id','=',$languageId->id)->get();
return $Result;

        
    }
    
    public function BlogsList(){

        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $Result = DB::table('blogs')->select('*')->where('status','=','1')->orderBy('blog_id', 'ASC')->where('language_id','=',$languageId->id)->get();
        return $Result;

      }
    

    public function getProductCategoryList()
    {

$productCategoryListData = array();

$result = DB::table('product_category_list')->select('*')->get()->toArray();

$productCategoryListData =  json_decode(json_encode((array) $result ),true);

if(isset($productCategoryListData) && count($productCategoryListData)>0)
{

return $productCategoryListData;

}

else{

    return $productCategoryListData;

}


    }
    
    public function getProductConcernList()
    {
$productConcernListData = array();
$result = DB::table('product_concern_list')->select('*')->get()->toArray();
$productConcernListData =  json_decode(json_encode((array) $result ),true);


if(isset($productConcernListData) && count($productConcernListData)>0)
{

return $productConcernListData;

}

else{

    return $productConcernListData;

}


    }

    public function getNewProductList()
    {
        
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $result = DB::table('products')->select('*')->where('status','=','1')->where('language_id','=',$languageId->id)->get();

        return $result;
    }


    public function getWomenBagsList()
    {
        
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $result = DB::table('products')->select('*')->where('sub_category_id','=','1')->where('status','=','1')->where('language_id','=',$languageId->id)->get();
        return $result;
    }

    public function getWomenWalletsList()
    {
        
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $result = DB::table('products')->select('*')->where('sub_category_id','=','5')->where('status','=','1')->where('language_id','=',$languageId->id)->get();
        return $result;
    }

    public function getMensBagsList()
    {
        
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $result = DB::table('products')->select('*')->where('sub_category_id','=','3')->where('status','=','1')->where('language_id','=',$languageId->id)->get();
        return $result;
    }

    public function getLuggagesList()
    {
        
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $result = DB::table('products')->select('*')->where('sub_category_id','=','9')->where('status','=','1')->where('language_id','=',$languageId->id)->get();
        return $result;
    }

    public function getLaptopBagsList()
    {
        
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $result = DB::table('products')->select('*')->where('sub_category_id','=','6')->where('status','=','1')->where('language_id','=',$languageId->id)->get();
        return $result;
    }


    public function getOtherList()
    {
        
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $result = DB::table('products')->select('*')->whereIn('sub_category_id', [7,8])->where('status','=','1')->where('language_id','=',$languageId->id)->get();
        return $result;
    }
    
 

    public function getProductList()
    {
        
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
        $result = DB::table('products')->select('id','product_type')->where('status','=','1')->where('language_id','=',$languageId->id)->get();
        return $result;
}

    public function getTrendingItemProductList($trendingItemsProductId)
    {
        $result = array();
        $trendingItemsProductIdStr = implode(',',$trendingItemsProductId);
        
       

        if(isset($trendingItemsProductIdStr) && !empty($trendingItemsProductIdStr)){


            $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
            $result = DB::table('products')->select('*')->whereIn('id',$trendingItemsProductId)->where('status','=','1')->where('language_id','=',$languageId->id)->get();
            return $result;
          
        }
        else{

            return $result;
          }
     
    }


    public function getNewLaunchProductList($newLaunchItemProductId)
    {

        $newLaunchItemProductIdStr = implode(',',$newLaunchItemProductId);
        
        $result = array();
    
        if(isset($newLaunchItemProductIdStr) && !empty($newLaunchItemProductIdStr)){
           
            $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
            $result = DB::table('products')->select('*')->whereIn('id',$newLaunchItemProductId)->where('status','=','1')->where('language_id','=',$languageId->id)->get();

            return $result;

        }
        else{

            return $result;
          }

       
        }  
        


    public function getFeaturedProductList($featuredProductsItemProductId)
    {

        $featuredProductsItemProductIdStr = implode(',',$featuredProductsItemProductId);
        $result = array();
        if(isset($featuredProductsItemProductIdStr) && !empty($featuredProductsItemProductIdStr)){
            $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();

            $result = DB::table('products')->select('*')->whereIn('id',$featuredProductsItemProductId)->where('status','=','1')->where('language_id','=',$languageId->id)->get();
            return $result;

        }
        else{

            return $result;
          }
        }



    public function getCategoryConcernSubcategryMaping()
    {  

        $result = DB::table('category')->select('*')->get();
       
        return $result;

    }


   public function getProductListWithCategory()
   {

$productCategoryListDataArray = array();

    $result = DB::table('products')->join('product_category_map','product_list.product_id','=','product_category_map.product_id')->join('product_category_list','product_category_list.category_id','=','product_category_map.category_id')->select('product_list.product_display_name','product_category_list.category_name')->get()->toArray();

    $productCategoryListData =  json_decode(json_encode((array) $result ),true);

  

    
    if(isset($productCategoryListData) && count($productCategoryListData)>0)
    {


        foreach($productCategoryListData as $key=>$value)
        {

            $productCategoryListDataArray[$value['product_display_name']][] = $value;
          
        }
        // print_r($productCategoryListDataArray);

        //     exit();

    return $productCategoryListDataArray;
    
    }
    
    else{
    
        return $productCategoryListDataArray;
    
    }
   }
   public function getProductListWithConcern()
   {

$productConcernListDataArray = array();

    $result = DB::table('product_list')->join('product_concern_map','product_list.product_id','=','product_concern_map.product_id')->join('product_concern_list','product_concern_list.concern_id','=','product_concern_map.concern_id')->select('product_list.product_display_name','product_concern_list.concern_name')->get()->toArray();

    $productConcernListData =  json_decode(json_encode((array) $result ),true);

 
    
  

    if(isset($productConcernListData) && count($productConcernListData)>0)
    {
    
        foreach($productConcernListData as $key=>$value)
        {
    
            $productConcernListDataArray[$value['product_display_name']][] = $value;
          
        }
       
    
    return $productConcernListDataArray;    
    }
    
    else{
    
        return $productConcernListDataArray;
    
    }

   }
   

   public function getBlogList()
   {
    $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first(); 
$result= DB::table('blogs')->select('*')->where('status','=','1')->where('language_id','=',$languageId->id)->get();
return $result;

 }


   public function getBlogDetailsByBlogName($blog_title)
   {
 

$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
$result = DB::table('blogs')->select('blog_id','blog_title','blog_title_display_name','blog_description','images','updated_at')->where('blog_title','=',$blog_title)->where('language_id','=',$languageId->id)->get();

return $result;

   }

   public function getAllUsersComment($blogId)
   {
$commentArray = array();

$result = DB::table('user_comment')->select('*')->where('blog_id','=',$blogId)->get()->toArray();

$commentArray =  json_decode(json_encode((array) $result ),true);

    if(isset($commentArray) && count($commentArray)>0)
{

return $commentArray;

}

else{

    return $commentArray;

}
   }


   public function getcommentCountAccToBlogId($blog_id)
   {

    $commentArray = array();

    $result = DB::table('user_comment')->where('blog_id','=',$blog_id)->count();
    
    $commentArray =  json_decode(json_encode((array) $result ),true);
    
        if(isset($commentArray) && count($commentArray)>0)
    {
    
    return $commentArray;
    
    }
    
    else{
    
        return $commentArray;
    
    }
   }


   public function getProductListWithConcernAndCategory()
   {

    $productCategoryConcernListDataArray = array();

    $result = DB::table('product_category_concern_map')->leftJoin('product_list','product_category_concern_map.product_id','=','product_list.product_id')->leftJoin('product_category_list','product_category_list.category_id','=','product_category_concern_map.category_id')->leftJoin('product_concern_list','product_category_concern_map.concern_id','=','product_concern_list.concern_id')->select('product_list.product_display_name','product_category_list.category_name','product_concern_list.concern_name')->get()->toArray();

    $productCategoryConcernListData =  json_decode(json_encode((array) $result ),true);

  

    
    if(isset($productCategoryConcernListData) && count($productCategoryConcernListData)>0)
    {


        foreach($productCategoryConcernListData as $key=>$value)
        {

            $productCategoryConcernListDataArray[$value['product_display_name']][] = $value;
          
        }
     
    return $productCategoryConcernListDataArray;
    
    }
    
    else{
    
        return $productCategoryConcernListDataArray;
    
    }

   }

   public function getSelectedItems($userId)
   {
$result = DB::table('user_added_items')->join('products','user_added_items.item_id','=','products.id')->where('user_added_items.user_id','=',$userId)->select('products.*','user_added_items.item_id','user_added_items.user_id')->get();

// $result = DB::table('user_added_items')->join('products','products.id','=','user_added_items.item_id')->select('products.*')->where('user_added_items.user_id','=','$userId')->get();
return $result;
   }

   public function getProductListAccToSubcategoryIds($sub_category_slug)
   {

$slugId = DB::table('sub-category')->select('id')->where('id','=',$sub_category_slug)->first();
$result = DB::table('products')->select('*')->where('sub_category_id','=',$slugId->id)->get();
return $result;
   
}

   public function getProductListCategoryWise($sub_category_slug)
   {

$slugId = DB::table('sub-category')->select('id')->where('id','=',$sub_category_slug)->first();
$result = DB::table('products')->select('*')->where('sub_category_id','=',$slugId->id)->first();
return $result;
   
}

public function getProductListBySlug($Search)
   {
    $slugId = DB::table('sub-category')->select('id')->where('id','=',$Search['slug'])->first();
    //$Data = DB::table('products')->select('*')->where('sub_category_id','=',$slugId->id)->get();

    $Data = DB::table('products');

    if($Search['short_by']!='' && $Search['short_by']=='price_low_high'){
      $Data->orderBy('discount_price','ASC');
    }

    if($Search['short_by']!='' && $Search['short_by']=='price_high_low'){
      $Data->orderBy('discount_price','DESC');
    }

    if($Search['fromVal']!='' && $Search['toVal']!=''){
      $Data->where([['discount_price','>=',$Search['fromVal']],['discount_price','<=',$Search['toVal']]]);
    }

    $Data->select('*');
    $Data->where('sub_category_id','=',$slugId->id);
    $Data->orderBy('id','ASC');
    $Res['Count'] = $Data->count();
    $Res['Res']   = $Data->get();
    return $Res;
    
    }


public function getProductListAccToConcernIds($concern_slug)
{
$slugId = DB::table('concern')->select('id')->where('concern_slug','=',$concern_slug)->first();
$result = DB::table('products')->select('*')->where('concern_id','=',$slugId->id)->get();
return $result;

}

public function getProductDetailsByProductId($name_slug)
{

$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
$result = DB::table('products')->select('*')->where('products.id','=',$name_slug)->where('products.language_id','=',$languageId->id)->first();

return $result;
}

public function getProductAttributes($name_slug)
{

$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
$result = DB::table('products')->select('attribute_values.value')
        ->join('attributes','products.category_attribute_id','=','attributes.id')
        ->join('attribute_values','attributes.id','=','attribute_values.attribute_id')
        ->where('products.id','=',$name_slug)->where('products.language_id','=',$languageId->id)->get();

return $result;
}

public function getProductCategoryDetailsByProductId($name_slug)
{

$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
$result = DB::table('products')->select('category_id','sub_category_id')->where('id','=',$name_slug)->where('language_id','=',$languageId->id)->first();
return $result;

}

public function getRelatedProductDetailsAccToCategoryId($category_id)
{

$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
$result = DB::table('products')->select('id')->where('category_id','=',$category_id)->where('language_id','=',$languageId->id)->get();
return $result;

}

public function getRelatedProductDetailsAccToSubCategoryId($sub_category_id)
{
    
    $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
    $result = DB::table('products')->select('id')->where('sub_category_id','=',$sub_category_id)->where('language_id','=',$languageId->id)->get();
    return $result;

}

public function getRelatedProductDetailsAccToConcernId($concern_id)
{
    
    $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
    $result = DB::table('products')->select('id')->where('concern_id','=',$concern_id)->where('language_id','=',$languageId->id)->get();
    return $result;

}

public function getRelatedProductListIds($RelatedProductIds)
{

$result = DB::table('products')->select('*')->whereIn('id',$RelatedProductIds)->get();
return $result;

}

public function gst()
{
   
$Result = DB::table('gst')->select('*')->where('status','=','1')->orderBy('id', 'DESC')->first();
return $Result;
}

public function getAllReview()
{
$Result = DB::table('user_rating')->select('*')->orderBy('id', 'DESC')->get();
return $Result;
}

public function getProductListAccToCategoryIds($category_slug)
{
    $slugId = DB::table('category')->select('id')->where('category_slug','=',$category_slug)->first();
    $Result = DB::table('products')->select('*')->where('category_id','=',$slugId->id)->orderBy('id', 'DESC')->get();
    return $Result;
}

}
