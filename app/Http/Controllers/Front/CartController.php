<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\HomeModel;
use Illuminate\Support\Facades\DB;
use App\Helpers\Common;
use Session;
use Cart;

class CartController extends Controller
{
    public function __construct(Request $request)
    {
        $this->HomeModel    = new HomeModel();
    }

    public function shop()
    {
        $products = Product::all();
        return view('shop')->withTitle('E-COMMERCE STORE | SHOP')->with(['products' => $products]);
    }

    public function cart()  
    {
      
        $cartCollection = \Cart::getContent();
        $Data['Settings']            = $this->HomeModel->Settings();
        $Data['cartCollection']      = $cartCollection;

        if(session('locale')=='en'){
            return view('en-SA/Front.cart')->with($data);
        }
        else{
            return view('ar-SA/Front.cart')->with($data);
        }

       //return view('Front.cart')->withTitle('E-COMMERCE STORE | CART')->with($Data);
    }

    public function add(Request $request)
    {
       $requestData = $request->all();
     

        if($requestData['page'] == 'main_page' )
        {

        //$productDetails = DB::table('products')->select('discount_on_number_of_product_items','number_of_items_discount_applied','discount_amount','discount_price')->where('id','=',$request->id)->first();
        $productDetails = DB::table('products')->where('id','=',$request->id)->first();
      //  dd($productDetails);
       

            $Category = $productDetails->category_id;
            $SubCategory = $productDetails->sub_category_id;
            $Size = $productDetails->size ? $productDetails->size : $request->size;
            $Color = $productDetails->color;
            $discount_price = $productDetails->discount_price;
            $OldPrice = $productDetails->price;
            $SKUId = $productDetails->sku_id;
            $serialNo = $productDetails->serial_no;

              $productPrice = $request->price;
              $discountAmount = (0/100)*$productPrice;
              $totalAmountForPaid = $productPrice-$discountAmount;
            
              \Cart::add(array(
                'id' => $request->id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $requestData['quantity'][1],
                'attributes' => array(
                    'image' => $request->img,
                    'slug' => $request->slug,
                    'Category' => isset($Category) ? $Category : '',
                    'SubCategory' => isset($SubCategory) ? $SubCategory : '',
                    'Size' => isset($Size) ? $Size : '',
                    'Color' => isset($Color) ? $Color : '',
                    'OldPrice' => isset($OldPrice) ? $OldPrice : '',
                    'SKUId' => isset($SKUId) ? $SKUId : '',
                    'serialNo' => isset($serialNo) ? $serialNo : ''
                )
            ));
        }



return redirect()->route('ShowCartItems');
}

    public function remove(Request $request){

        $finalDiscountPrice=0;
        $finalWithoutDiscountPrice=0;
        $finalArray = array();
        $finalArray1=array();
        $lastPrice=0;
        $discountPrice = array();
        $normalPrice = array();
        $totalAmountForPaid = array();
        \Cart::remove($request->id);




 $cartCollection = \Cart::getContent();
    
   
 foreach( $cartCollection as $key=>$value)
 {

     if( $value->attributes->slug  == 0 )
     {
     
     $normalPrice[] = array($value->price*$value->quantity);
     
     }
     else{
     
         $discountPrice[] = array($value->attributes->slug);
     
     }
 }

 if(isset($discountPrice) && !empty($discountPrice))
 {
     foreach($discountPrice as $key=>$value )
     {
         foreach($value as $key1=>$value1 )
         {
         
       
 
         $finalArray[] = $value1;
         }

     }


 }

 if(isset($normalPrice) && !empty($normalPrice))
 {
     foreach($normalPrice as $key=>$value )
     {
         foreach($value as $key1=>$value1 )
         {
         
       
 
         $finalArray1[] = $value1;
         }

     }


 }

 if(isset($finalArray) && isset($finalArray1)){
     $finalDiscountPrice = array_sum($finalArray);
     $finalWithoutDiscountPrice = array_sum($finalArray1);
   
 }
 $lastPrice = $finalDiscountPrice +$finalWithoutDiscountPrice;
 if(!empty(session('totalAmountForPaid'))){


    Session::forget('totalAmountForPaid');
    Session::put('totalAmountForPaid', $lastPrice);
    Session::save();

}
else{

    Session::put('totalAmountForPaid', $lastPrice);
    Session::save();
}

if(session('DiscountCoupenCode'))
    {
    
        $coupenDetails = DB::table('discount')->select('*')->where('coupen_code','=',session('DiscountCoupenCode'))->first();
        $discountPrice = $coupenDetails->discount_amount;
        $totalPrice = array_sum($totalAmountForPaid);
        $discountAmount = ($discountPrice/100)*$totalPrice;
        $totalAmountForPaid = $totalPrice-$discountAmount;
      
        if(!empty(session('totalAmountForPaid')) && !empty(session('totalAmountForPaidAfterDiscount')) )
        {
                Session::forget('totalAmountForPaid');
                Session::put('discountAmount', $discountAmount);
                Session::put('totalAmountForPaidAfterDiscount', $totalAmountForPaid);
                Session::put('totalAmountForPaid', $totalAmountForPaid);
                Session::save();
        }
        else
        {
            Session::put('discountAmount', $discountAmount);
            Session::put('totalAmountForPaidAfterDiscount', $totalAmountForPaid);
            Session::put('totalAmountForPaid', $totalAmountForPaid);
            Session::save();

        }
    }
    else
    {

if(!empty(session('totalAmountForPaid')) && !empty(session('totalAmountForPaidAfterDiscount')) )
        {
                
                Session::forget('totalAmountForPaid');
                $totalPrice = \Cart::getTotal();
                Session::put('totalAmountForPaid', $totalAmountForPaid);
                Session::put('totalAmountForPaidAfterDiscount', $totalAmountForPaid);

                Session::save();
        }
        else{
        
            $totalPrice = \Cart::getTotal();
            Session::put('totalAmountForPaid', $totalAmountForPaid);
            Session::put('totalAmountForPaidAfterDiscount', $totalAmountForPaid);
            Session::save();
        
        }


    }
  

     $itemCount =  \Cart::getContent()->count();
        if($itemCount == 0)
        {
        
            if(!empty(session('Discount')) && !empty('DiscountCoupenCode') )
            {
                    Session::forget('Discount');
                    Session::forget('DiscountCoupenCode');

                    Session::put('Discount',0);
                    Session::save();
            
            }
            if(!empty(session('discountAmount')))
            {
                    Session::forget('discountAmount');
                    Session::put('discountAmount',0);
                    Session::save();
}
            
            if(!empty(session('totalAmountForPaid')) && !empty(session('totalAmountForPaidAfterDiscount')) )
            {
                    Session::forget('totalAmountForPaid');
                    Session::forget('totalAmountForPaidAfterDiscount');

            }
        
        
        }
     return redirect()->route('ShowCartItems');

    }
 

    public function update(Request $request){
        $finalDiscountPrice=0;
        $finalWithoutDiscountPrice=0;
        $totalAmountForPaid = array();
        $productDetails = DB::table('products')->where('id','=',$request->id)->first();

  
        $productPrice = $request->price*$request->quantity;
        $discountAmount = (0/100)*$productPrice;
        $totalAmountForPaid = $productPrice-$discountAmount;

        $Category = $productDetails->category_id;
        $SubCategory = $productDetails->sub_category_id;
        $Size = $productDetails->size;
        $Color = $productDetails->color;
        $discount_price = $productDetails->discount_price;
        $OldPrice = $productDetails->price;
        $SKUId = $productDetails->sku_id;
        $serialNo = $productDetails->serial_no;

        \Cart::update($request->id,
        array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity
            ),
            
                'attributes' => array(
                    'image' => $request->img,
                    'slug' => $request->slug,
                    'Category' => isset($Category) ? $Category : '',
                    'SubCategory' => isset($SubCategory) ? $SubCategory : '',
                    'Size' => isset($Size) ? $Size : '',
                    'Color' => isset($Color) ? $Color : '',
                    'OldPrice' => isset($OldPrice) ? $OldPrice : '',
                    'SKUId' => isset($SKUId) ? $SKUId : '',
                    'serialNo' => isset($serialNo) ? $serialNo : ''
                )
        ));


  
    $cartCollection = \Cart::getContent();
    
   
return redirect()->route('ShowCartItems');


    }

    public function clear(){
        \Cart::clear();
        return redirect()->route('cart.index')->with('success_msg', 'Car is cleared!');
    }

    public function test()
    {
        $image_data = DB::table('products')->whereNotNull('images')->where('id','>',1)->get();
        
        foreach($image_data as $key){
                $url = $key->images;
                $urls = explode(" | ",$url);
                
                for ($i = 0; $i < 3; $i++) {
                    
                $ch = curl_init();
            
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url[$i]);
            
                $data = curl_exec($ch);
                $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                $pathinfo = pathinfo($url[$i]);
                $extension = 'jpg';

                curl_close($ch);

                $image_name = 'mvcode_image_'.$key->id.'_'.$i.'_'.rand().'.'.$extension.'';

                $img = public_path('/images/products') .'/'. $image_name;

                file_put_contents( $img, $data );
                
                }

                // DB::table('products')->where('id',$key->id)
                // ->update(['images'=> $image_name]);
    
            }
        echo "File downloaded!";
    
    }

}
?>