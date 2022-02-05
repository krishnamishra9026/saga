<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartItemModel extends Model
{
    public function insertitem($requestData)
    {
$finalArray = array();
$item_id = $requestData['item_id'];
$user_id = $requestData['user_id'];

$checkItemExistence = DB::table('user_added_items')->select('user_added_items.id')->where('user_added_items.item_id','=',$item_id)->where('user_added_items.user_id','=',$user_id)->get()->toArray(); 
  
if(isset($checkItemExistence) && count($checkItemExistence)>0){
    $finalArray = array('message'=>"Already exist",
    'count'=>0
);
    return $finalArray;

}
else{

    $result = DB::table('user_added_items')->insert($requestData);
    $addedItemList = DB::table('user_added_items')->select('user_added_items.id')->where('user_added_items.item_id','=',$item_id)->where('user_added_items.user_id','=',$user_id)->get()->toArray(); 
$itemCount=count($addedItemList);
$finalArray = array('message'=>"item-added",
'count'=>$itemCount
);

return $finalArray;
    
}


        
    }

 

    public function getProductItem($userId)
    {
        $productsArray = array('message'=>" ",
        'count'=>0,
        'data'=>array()
    );        
$result = DB::select("select products.* from products inner join  user_added_items on products.id = user_added_items.item_id  where user_added_items.user_id = $userId ");

$productDataArray =  json_decode(json_encode((array) $result ),true);



if(isset($productsArray) && count($productsArray)>0)
{
    $itemCount=count($productDataArray);

    $productsArray = array('message'=>"fetch-data",
    'count'=>$itemCount,
    'data'=>$productDataArray
);
return $productsArray;

}

else{
   
    return $productsArray;

}



    }

    public function removeItem($requestData ,$userId)
    {

$result = DB::table('user_added_items')->where('user_added_items.item_id','=',$requestData["item_id"])->where('user_added_items.user_id','=',$userId)->delete();

return $result;

    }

    public function getCoupenDetails($coupen){

$result = DB::table('discount')->select('discount.discount_amount')->where('coupen_code','=',$coupen)->get()->toArray();
$dicountAmount =  json_decode(json_encode((array) $result ),true);


return $dicountAmount;
    }
    
    //
}
