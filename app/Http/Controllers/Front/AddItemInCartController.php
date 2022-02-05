<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\CartItemModel;
use App\Http\Models\ProductsModel;
use App\Http\Models\Admin\CategoryModel;
use App\Helpers\Common;
use Illuminate\Support\Facades\DB;

use Session;
use App\Http\Controllers\Front\AddItemInCartController;
use Cart;


class AddItemInCartController extends Controller
{
    public function __construct(Request $request)
    {
        $this->CartItemModel    = new CartItemModel();
        $this->productModel    = new ProductsModel();
		$this->CategoryModel = new CategoryModel();

    }

    public function AddItemInCart(Request $request)
    {

        if($request->IsMethod('post'))
        {
            $finalArray = array();
 
$requestData = $request->all();
unset($requestData['action']);
 $id = $requestData['item_id'];

//new code start
$product = AddItemInCartController::find($id);
if(!$product) {

    abort(404);

}

$cart = session()->get('cart');

// if cart is empty then this the first product
if(!$cart) {

    $cart = [
            $id => [
                "id" => $product[0]['id'],
                "images" => $product[0]['images'],
                "product_discription" => $product[0]['product_discription'],

                "price" => $product[0]['price'],

                

                "quantity" => 1,
                "name" => $product[0]['name'],
            ]
    ];

    session()->put('cart', $cart);
    
    // return redirect()->back()->with('success', 'Product added to cart successfully!');
}

// if cart not empty then check if this product exist then increment quantity
if(isset($cart[$id])) {

    $cart[$id]['quantity']++;

    session()->put('cart', $cart);
   
    // return redirect()->back()->with('success', 'Product added to cart successfully!');

}



// if item not exist in cart then add to cart with quantity = 1
$cart[$id] = [
    "id" => $product[0]['id'],
                "images" => $product[0]['images'],
                "product_discription" => $product[0]['product_discription'],

                "price" => $product[0]['price'],

                

                "quantity" => 1,
                "name" => $product[0]['name'],
];

session()->put('cart', $cart);

$productItemHtml = $this->getProductItemHtml();

    $finalArray = array('status'=>'success',
    'addeditems'=>$productItemHtml,
    
    );
        
print_r(json_encode($finalArray));
exit();
        
}

    }

    private function getProductItemHtml()
    {
        

$html='';
$html.='<div class="dropdown-cart-header">';
$html.='<span>'.\Cart::getContent()->count().'Items</span>';
$html.='<a href="/cart">'.__('home.View Cart').'</a>';
$html.='</div>';
$html.='<ul class="shopping-list" >';
$items =0;
$totalPrice= 0;
$sum= 0;
$cartCollection = \Cart::getContent();


foreach( $cartCollection as $key=>$value)
{

    $html.='<li id="remove-item-'.$value->id.'" >';
    $html.='<a  onClick="removeFromCart('.$value->id.');"  class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>';

    
    $html.='<a class="cart-img" href="/cart"><img src="'.$value->attributes->image.'"  alt="#"></a>';
    $html.='<h4><a href="/cart">'.$value->name.'</a></h4>';
    $html.='<p class="quantity">'.$value->quantity.' - <span class="amount">Rs.'.$value->price*$value->quantity.'</span></p>';
    $html.='</li>';

    
}

$html.='</ul>';
$html.='<div class="bottom">';
$html.='<div class="total">';
$html.='<span>Total</span>';
if(session('DiscountCoupenCode'))
{
$html.='<span class="total-amount" id="add-item-deleted-price">Rs. '.session('totalAmountForPaidAfterDiscount').'</span>';
}
else
{
    $html.='<span class="total-amount" id="add-item-deleted-price">Rs. '.session('totalAmountForPaid').'</span>';
}
// $html.='<span class="total-amount" id="add-item-deleted-price-show" >Rs.'.session('totalAmountForPaid').'</span>';

$html.='</div>';
$html.='<a href="'.route("ShowCartItems").'" class="btn animate">'.__('home.View Cart').'</a>';
$html.='</div>';




return $html;

    }


    public function getAllProductItems()
    {
        
        $data['Category'] = $this->productModel->CategoryList();
        $data['CategoryA']              = $this->productModel->CategoryAList();
        $data['gst'] = $this->productModel->gst();
        $data['manuPage'] = $this->productModel->manuPage();
        $gst = $data['gst']->GST;
        $discountPrice = array();
        $finalArray = array();
        $normalPrice = array();
        $lastPrice=0;
        $finalArray1=array();
        $finalDiscountPrice=0;
        $finalWithoutDiscountPrice=0;
        $discountAmount=0;
        $data['notification'] = $this->productModel->getProductNotification();

        $itemCount =  \Cart::getContent()->count();
        $cartCollection =  \Cart::getContent();
        $data['cartCollection'] = $cartCollection;
        
        /*$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
        $subcategory = DB::table('sub-category')->where('id','=',$row->sub_category_id)->where('status','=','1')->where('language_id','=',$languageId->id)->first();*/
        /*echo "<pre>";
        print_r($cartCollection);
        die;*/
        
        if(session('locale')=='en'){
            return view('en-SA/Front.cart')->with($data);
        }
        else{
            return view('ar-SA/Front.cart')->with($data);
        } 
          
}





    public function  RemoveItemFromTheCart(Request $request)
    {
if($request->isMethod('post'))
{
    $finalArray = array();

    $requestData = $request->all();
    unset($requestData['action']);
    $userId = session('user_id','1');

    $insertItem = $this->CartItemModel->removeItem($requestData ,$userId);
    $userId = session('user_id','1');
    $productItem = $this->CartItemModel->getProductItem($userId);
    $sum=0;
foreach( $productItem as $key=>$value)
{
$sum = $sum+$value['price'];

}
$finalArray = array('status'=>'success',
'item_id'=>$requestData['item_id'],
'price'=>$sum

);

print_r(json_encode($finalArray));
    exit();
}
 }

    public function fetchUserAddedItems(Request $request)
    {

        if($request->isMethod('post'))
        {
            $finalArray = array();

            $requestData = $request->all();
           
            $productItemHtml = $this->getProductItemListHtml();

                $finalArray = array('status'=>'success',
                'selectedItems'=>$productItemHtml,
              
                );
            
            print_r(json_encode($finalArray));
            exit();
        }
    }


    private function getProductItemListHtml()
    {


        $items = session()->get('totalItems');
        // session('totalItems');
$html='';

$html.='<div class="dropdown-cart-header">';
$html.='<span>'.\Cart::getContent()->count().' Items</span>';
$html.='<a href="/cart">'.__('home.View Cart').'</a>';
$html.='</div>';
$html.='<ul class="shopping-list" >';
$sum= 0;
$items =0;
$totalPrice= 0;
$cartCollection = \Cart::getContent();

foreach( $cartCollection as $key=>$value)
{


    $html.='<li id="remove-item-'.$value->id.'" >';
    $html.='<a  onClick="removeFromCart('.$value->id.');"  class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>';
    $html.='<a class="cart-img" href="/cart"><img src="'.$value->attributes->image.'" alt="#"></a>';
    $html.='<h4><a href="/cart">'.$value->name.'</a></h4>';
    $html.='<p class="quantity">'.$value->quantity.' - <span class="amount">Rs. '.$value->price*$value->quantity.'</span></p>';
    $html.='</li>';
 
}

$html.='</ul>';
$html.='<div class="bottom">';
$html.='<div class="total">';
$html.='<span>Total</span>';



if(!empty(session('DiscountCoupenCode')))
{

    if(session('totalAmountForPaidAfterDiscount')){

        $html.='<span class="total-amount" id="add-item-deleted-price">'.session('totalAmountForPaidAfterDiscount').'.Rs</span>';
    
      }else{
    
        $html.='<span class="total-amount" id="add-item-deleted-price">Rs.0</span>';
    
    
      }

$html.='<span class="total-amount" id="add-item-deleted-price">Rs. '.session('totalAmountForPaidAfterDiscount').'</span>';
}
else
{
    
  if(session('totalAmountForPaid')){

    $html.='<span class="total-amount" id="add-item-deleted-price">Rs.'.session('totalAmountForPaid').'</span>';

  }
  else
  
  {

    $html.='<span class="total-amount" id="add-item-deleted-price">Rs.0</span>';
}

}

$html.='</div>';
$html.='<a href="'.route("ShowCartItems").'" class="btn animate">'.__('home.View Cart').'</a>';
$html.='</div>';

return $html;
    }


    public function addToCart($id)
    {
        
       
        $product = AddItemInCartController::find($id);
        if(!$product) {

            abort(404);

        }

        $cart = session()->get('cart');
      
        // if cart is empty then this the first product
        if(!$cart) {

            $cart = [
                    $id => [
                        "id" => $product[0]['id'],
                        "images" => $product[0]['images'],
                        "product_discription" => $product[0]['product_discription'],

                        "price" => $product[0]['price'],

                        

                        "quantity" => 1,
                        "name" => $product[0]['name'],
                    ]
            ];

            session()->put('cart', $cart);
            
            return redirect()->route('ShowCartItems');
        }

        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);
           
            return redirect()->route('ShowCartItems');

        }
        
      
       
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "id" => $product[0]['id'],
                        "images" => $product[0]['images'],
                        "product_discription" => $product[0]['product_discription'],

                        "price" => $product[0]['price'],

                        

                        "quantity" => 1,
                        "name" => $product[0]['name'],
        ];

        session()->put('cart', $cart);
          
        $cart = session()->get('cart');
        
        $items = 0;
        $totalPrice= 0;

foreach($cart as $key =>$value)
{
$items = $items+$value['quantity'];
$totalPrice = $totalPrice+$value['price']; 
}
return redirect()->route('ShowCartItems');
}

    public function find($id)
    {


        $productDetails=$this->productModel->getProductDetailsByProductId($id);

return $productDetails;

    }


    public function update(Request $request)
    {
        
       
if($request->isMethod('post'))
{
$requestArray = $request->all();


        if($requestArray['id'])
        {
          

            $cart = session()->get('cart');
       
          $quantity = 1;
        
          $quantity = $quantity+$requestArray['quantity'];
        
        
            $cart[$requestArray['id']]["quantity"] =  $quantity;

           

            session()->put('cart', $cart);
        //     $cart = session()->get('cart');

        //     print_r($cart);
        //   exit();
        }
    }
    }


    public function reduceQuantity(Request $request)
    {

        if($request->isMethod('post'))
        {
        $requestArray = $request->all();
        
//         print_r($requestArray);
// exit();
        
                if($requestArray['id'])
                {
                    $cart = session()->get('cart');
                    if( $requestArray['quantity'] == 0)
                    {

                        $quantity = 0;


                    }else
                    {

                        $quantity = 1;
                        $quantity = $requestArray['quantity']-$quantity;

                    }
                 
                    $cart[$requestArray['id']]["quantity"] =  $quantity;
        
                   
        
                    session()->put('cart', $cart);
                 
                }
            }
    }

    public function remove(Request $request)
{
        
    
    if($request->isMethod('post'))
{
$requestArray = $request->all();



        if($requestArray['id']) {
            \Cart::remove($requestArray['id']);


            // $cart = session()->get('cart')
            // ;
            // Session::forget('totalItems');
            // Session::forget('totalPrice');
            // Session::forget('totalItems1');
            // Session::forget('totalPrice1');
            // $totalItems = session()->get('totalItems');
            // $totalPrice = session()->get('totalPrice');
// print_r($totalItems);
// print_r($totalPrice);

// exit();
            
//             session()->put('totalItems', $items);
// session()->put('totalPrice', $totalPrice);

            // if(isset($cart[$requestArray['id']])) {

            //     unset($cart[$requestArray['id']]);

            //     session()->put('cart', $cart);
            // }

            // session()->flash('success', 'Product removed successfully');
        }
    }
}

public function calculatePriceAccToCoupen(Request $request)
{

if(session('user_id'))
{
$finalArray = array();
$requestData = $request->all();
$discountDetails= $this->CartItemModel->getCoupenDetails($requestData['Coupon']);


if(empty(session('DiscountCoupenCode')))
{
    Session::forget('DiscountCoupenCode');
    Session::put('DiscountCoupenCode', $requestData['Coupon']);
    Session::save();
}



if(!empty($discountDetails))
{
    
$discountPrice = $discountDetails[0]['discount_amount'];
$totalPrice = $requestData['totalPrice'];
$discountAmount = ($discountPrice/100)*$totalPrice;
$totalAmountForPaid = $totalPrice-$discountAmount;




if(!empty(session('Discount')))
{
        Session::forget('Discount');


}
if(!empty(session('discountAmount')))
{
        Session::forget('discountAmount');


}
if(!empty(session('totalAmountForPaidAfterDiscount')))
{
Session::forget('totalAmountForPaidAfterDiscount');

}


Session::put('Discount', $discountPrice);
Session::put('discountAmount', $discountAmount);
Session::put('totalAmountForPaidAfterDiscount', $totalAmountForPaid);



Session::save();

$msg = Common::AlertErrorMsg('Success','Discount is Applied.');
			Session::flash('message', $msg);
			return Redirect()->route('ShowCartItems');

}
else
{

if(!empty(session('Discount')))
    {
            Session::forget('Discount');
    
    
    }
if(!empty(session('discountAmount')))
    {
            Session::forget('discountAmount');
    
    
    }
    
if(!empty(session('totalAmountForPaidAfterDiscount')))
    {
            Session::forget('totalAmountForPaidAfterDiscount');
    
    }
    
    Session::put('Discount', 0);
    Session::put('discountAmount', 0);
    Session::put('totalAmountForPaidAfterDiscount', 0);
    Session::save();

return Redirect()->route('ShowCartItems');
    
}

}
else{

return Redirect()->route('Login');

}

}
    //
}
