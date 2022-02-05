<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Front\HomeModel;
use App\Http\Models\ProductsModel;
use App\Mail\UserOrder;
use App\Mail\AdminOrderMail;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;
use App\Payment;
use Validator;
use Session;
use Redirect;
use DB;
use Cart;
use Auth;
use App\Helpers\Common;


class PaymentController extends Controller
{
 
    public $gateway;
 
    public function __construct()
    {        
        $this->productModel  = new ProductsModel();
    }
 
    public function index()
    {
        $data['Category'] = $this->productModel->CategoryList();
        return view('payment')->with($data);
    }




    public function userPayment_old(Request $request)
    {

        $requestData  =$request->all(); 
        
        $cartItemArray = array();

        $productname = $requestData['productname'];
        $mb_language = $requestData['mb_language'];
        //$amount = $requestData['productamount'];

        $params = array(
            'ivp_method'  => 'create',
            'ivp_store'   => '22114',
            'ivp_authkey' => 'rPFq-2TFdd@4bhZc',
            'ivp_cart'    => 'sagabags-'.rand(10000000,99999999),  
            'ivp_test'    => '1',
            'ivp_amount'  => '1.00',
            'ivp_currency'=> 'SAR',
            'ivp_desc'    => $productname,
            'return_auth' => 'https://99apptechnologies.co.in/design/sagabags/public/'.$mb_language.'/PaymentAuthorised?status=Success',
            'return_can'  => 'https://99apptechnologies.co.in/design/sagabags/public/'.$mb_language.'/PaymentCancelled?status=Cancelled',
            'return_decl' => 'https://99apptechnologies.co.in/design/sagabags/public/'.$mb_language.'/PaymentDeclined?status=Declined'
        );
        /*echo "<pre>";
        print_r($params);
        die;*/

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $results = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($results,true);

        $ref= trim($results['order']['ref']);
        $url= trim($results['order']['url']);
        /*echo "<pre>";
        print_r($results);
        die;
        if (empty($ref) || empty($url)) {
        echo "Failed to create order";
        }
        else{
        echo "create order";
        }
        die;*/

        if(isset($url))
        {
          echo '<form id="telr_payment_form" action="'.$url.'" method="POST">
            <input type="hidden" name="order_ref" id="order_ref" value="'.$ref.'" />
            </form>';
          echo '<script type="text/javascript">document.getElementById("telr_payment_form").submit();</script>';  
        }else{
          echo "no data found";
        }

    }



    public function PaymentAuthorised(Request $request)
    {
        $Category = $this->productModel->CategoryList();
        $data['CategoryA'] = $this->productModel->CategoryList();
        /*echo "<pre>";
        print_r('Aftab');
        die;*/
        //$data['Category'] = $this->productModel->CategoryList();
        //$data['manuPage'] = $this->productModel->manuPage();
        //$data['notification'] = $this->productModel->getProductNotification();
        
        \Cart::clear();
        /*Session::forget('totalAmountForPaidAfterDiscountAndGST');
        Session::forget('CategoryWiseGST');
        Session::forget('totalAmountForPaid');
        Session::forget('totalAmountForPaidAfterDiscount');
        Session::forget('discountAmount');
        Session::forget('DiscountCoupenCode');
        Session::forget('Discount');
        Session::forget('address');*/

        $params = [
          'ivp_method' => 'check',
          'ivp_store' => 22114,
          'ivp_authkey' => 'rPFq-2TFdd@4bhZc',
          'order_ref' => session('order_ref'),
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $results = curl_exec($ch);
        curl_close($ch);
        
        $results = json_decode($results,true);

        $data['order'] = $results['order'];
        // dd($data);

        //Update payment id in order table

        DB::table('orders')->where('order_id',session('order_id'))->update(['telr_payment_id' => session('order_ref') , 'transaction_id'=> $data['order']['transaction']['ref'] ]);

        return view('en-SA/Front.payment-success',compact('data','Category'));
    
    }


    public function PaymentSuccess(Request $request)
    {
        $Category = $this->productModel->CategoryList();
        $data['CategoryA'] = $this->productModel->CategoryList();
        /*echo "<pre>";
        print_r('Aftab');
        die;*/
        //$data['Category'] = $this->productModel->CategoryList();
        //$data['manuPage'] = $this->productModel->manuPage();
        //$data['notification'] = $this->productModel->getProductNotification();
        
        \Cart::clear();
        /*Session::forget('totalAmountForPaidAfterDiscountAndGST');
        Session::forget('CategoryWiseGST');
        Session::forget('totalAmountForPaid');
        Session::forget('totalAmountForPaidAfterDiscount');
        Session::forget('discountAmount');
        Session::forget('DiscountCoupenCode');
        Session::forget('Discount');
        Session::forget('address');*/

        
        //Update payment id in order table

        return view('en-SA/Front.cash-on-delivery',compact('Category'));
    
    }

    public function PaymentCancelled(Request $request)
    {
        $data['Category'] = $this->productModel->CategoryList();
        $data['CategoryA'] = $this->productModel->CategoryList();
        return view('en-SA/Front.payment-failed')->with($data);
    }


    public function PaymentDeclined(Request $request)
    {
        $data['Category'] = $this->productModel->CategoryList();
        $data['CategoryA'] = $this->productModel->CategoryList();
      return view('en-SA/Front.payment-failed')->with($data);
    }


    public function userPayment(Request $request)
    {
        $requestData  =$request->all(); 
        // echo "<pre>";print_r($requestData);"</pre>";exit;
        $cartItemArray = array();
        $productname = $requestData['productname'];
        $mb_language = $requestData['mb_language'];

     
    
        $cartCollection = \Cart::getContent();
        $total = 0;
        foreach($cartCollection as $item)
        {
            $total = $total + ($item->price * $item->quantity);
            $cartItemArray[] = array('id'=>$item->id,
            'name'=>$item->name,
            'price'=>$item->price,
            'quantity'=>$item->quantity,
            'image'=>$item->attributes->image,
            'slug'=>$item->attributes->slug,
            'size'=>$item->attributes->Size,
            'totalAmountForPaid'=>$item->price * $item->quantity,
            'Discount'=>session('Discount'),
            'discountAmount'=>session('discountAmount'),
            'totalAmountForPaidAfterDiscount'=>session('totalAmountForPaidAfterDiscount'),
            'totalAmountForPaidAfterDiscountAndGST'=>session('totalAmountForPaidAfterDiscountAndGST')
            );
        }

            session()->put('totalAmountForPaid',round($total));
            session()->save();
            
          $cartCollectionEncodedData = json_encode($cartItemArray);
           
          $user_phone_number = DB::table('user_authentication_details')->select('mobile')->where('email',session('user_email'))->first();

          $order_id = 'sagabags-'.rand(1000,9999);

          $orderDetails = array(
            'user_id'=>session('user_id'),
            'billing_name'=>session('user_name'),
            'billing_address'=>session('address'),
            'billing_tel'=>$user_phone_number->mobile,
            'billing_email'=>session('user_email'),
            'billing_order_details'=>$cartCollectionEncodedData,
            'order_id'=>$order_id,
            //'razorpay_payment_id'=>$razorpayPaymentId,
            'txn_amount'=>session('totalAmountForPaid'),
            'payment_type'=>'online',
            'currency'=>'SAR',
            'status'=>'success',
            'ip_address'=>$_SERVER['REMOTE_ADDR'],
            'session_id'=>Session::getId(),
            'txn_date'=>date('Y-m-d H:i:s')

        );

        session()->put('order_id',$order_id);
        
        session()->save();

        //$subject = 'User Order Details';
        //$email = $userDetails->email;  
        $orderStatus= $this->productModel->AddOrdersDetails($orderDetails); 

        //echo "<pre>";

        //print_r($orderStatus); die;
        $data['Category'] = $this->productModel->CategoryList();
        $data['CategoryA'] = $this->productModel->CategoryList();
         \Cart::clear();
       
        //Payment integration
        $params = [
          'ivp_framed' => 2,
          'ivp_method' => 'create',
          'ivp_store' => 22114,
          'ivp_authkey' => 'rPFq-2TFdd@4bhZc',
          'ivp_desc' => $productname,
          'ivp_cart' => $order_id,
          'ivp_currency' => 'SAR',
          'ivp_amount' => session('totalAmountForPaid'),
          'ivp_test' => 0,
          'return_auth' => 'https://www.saga-bags.com/public/'.$mb_language.'/PaymentAuthorised?status=Success',
          'return_decl' => 'https://www.saga-bags.com/public/'.$mb_language.'/PaymentDeclined?status=Declined',
          'return_can' => 'https://www.saga-bags.com/public/'.$mb_language.'/PaymentCancelled?status=Cancelled',
          'bill_title' => 'Mr',
          'bill_fname' => session('user_name'),
         // 'bill_sname' => 'Maids',
          'bill_email' => session('user_email'),
          'bill_addr1' => session('address'),
          'bill_city' => 'Dubai',
          'bill_country' => 'AE',
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
      curl_setopt($ch, CURLOPT_POST, count($params));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
      $results = curl_exec($ch);
      curl_close($ch);
      //   print_r($results);
      // exit(0);
      $results = json_decode($results,true);
        
      $ref= trim($results['order']['ref']);
      $url= trim($results['order']['url']);

      session()->put('order_ref',$ref);
      session()->save();
      
      if(isset($url))
      {
        echo '<form id="telr_payment_form" action="'.$url.'" method="POST">
          <input type="hidden" name="order_ref" id="order_ref" value="'.$ref.'" />
          </form>';
        echo '<script type="text/javascript">document.getElementById("telr_payment_form").submit();</script>';  
      }else{
        echo "no data found";
      }

       
        // return view('en-SA/Front.payment-success')->with($data);
        // return redirect()->route('PaymentSuccess');
   }
  
  public function userPaymentForCashOnDelivery(Request $request)
  {
      
      $requestData  = $request->all();     
      // $amount = $requestData['amount'];
      // $amount = round(\Cart::getTotal()).'.00';

      $amount = session('totalAmountForPaidAfterDiscountAndGST');
      $userId = session('user_id');
      // $totalGst = $requestData['totalGst'];
      $totalGst = 15;
      $userDetails = DB::table('user_authentication_details')->select('email')->where('id','=',$userId)->first();
      
       $n=10;
       $generator = "1928374656372845918446";
       $orderId = ""; 
   
    $orderId.="sagabagscod"; 
    for ($i = 1; $i <= $n; $i++) { 
            $orderId .= substr($generator, (rand()%(strlen($generator))), 1); 
        }
         
$cartCollection = \Cart::getContent();

foreach( $cartCollection as $item)
{
$cartItemArray[] = array('id'=>$item->id,
'name'=>$item->name,
'price'=>$item->price,
'quantity'=>$item->quantity,
'image'=>$item->attributes->image,
'slug'=>$item->attributes->slug,
'totalAmountForPaid'=>session('totalAmountForPaid'),
'Discount'=>session('Discount'),
'discountAmount'=>session('discountAmount'),
'totalAmountForPaidAfterDiscount'=>session('totalAmountForPaidAfterDiscount'),
'totalAmountForPaidAfterDiscountAndGST'=>session('totalAmountForPaidAfterDiscountAndGST'),
'totalGst'=>session('vatToPay')
 );
 
}

  $cartCollectionEncodedData = json_encode($cartItemArray);

  $shipping_address = ['name' => @$requestData['fname'] .' '.@$requestData['lname'], 'email' => @$requestData['email'], 'company' => @$requestData['company'], 'address' => @$requestData['address'], 'city' => @$requestData['city'],'country' => @$requestData['country'],'state' => @$requestData['state'],'keep_me' => @$requestData['keep_me'],'postcode' => @$requestData['postcode'],'phone' => @$requestData['phone']];

  $userDetails = DB::table('user_authentication_details')->select('email')->where('id','=',$userId)->update(['shipping_address' => json_encode($shipping_address)]);

  $orderDetails = array(

    'user_id'=>$userId,
    'billing_name'=>session('user_name'),
    'billing_address'=>(session('address')) ? : json_encode($shipping_address),
    'billing_tel'=>'7042481438',
    'billing_email'=>session('user_email'),
    'billing_order_details'=>$cartCollectionEncodedData,
    'order_id'=>$orderId,
    'txn_amount'=>$amount,
    'vat_amt'=>session('vatToPay'),
    'discount_details'=>session('discountAmount'),
    'payment_type'=>'cod',
    // 'payment_type'=>$requestData['payment_type'],
    'currency'=>'INR',
    'status'=>'pending',
    'ip_address'=>$_SERVER['REMOTE_ADDR'],
    'session_id'=>Session::getId(),
    'txn_date'=>date('Y-m-d H:i:s')

);

session()->put('order_id',$orderId);
session()->put('amount',$amount);
session()->save();

$subject = 'User Order Details';
$email = session('user_email');
$UserBody = $this->UserMailHtml($orderDetails,$cartItemArray);

$AdminBody = $this->AdminMailHtml($orderDetails,$cartItemArray);

$UserBodyMailStatus = Common::SendMail($email, 'info@cureroot.com', '', '', $subject, $UserBody);
// $UserBodyMailStatus = Common::SendMail($email, 'er.krishna.mishra@gmail.com', '', '', $subject, $UserBody);
// $AdminBodyMailStatus = Common::SendMail('nktkmr461@gmail.com','info@cureroot.com', '', '', $subject, $AdminBody);
// $AdminBodyMailStatus = Common::SendMail('er.krishna.mishra@gmail.com','info@cureroot.com', '', '', $subject, $AdminBody);

$UserMessageStatus=$this->sendMessageForCashOnDelivery($orderDetails['billing_tel'],'register',$orderDetails,$cartItemArray );
$UserwhatsupMessageStatus=$this->sendWhatsupMessageForCashOnDelivery($orderDetails['billing_tel'],'register',$orderDetails,$cartItemArray);
$AdminMessageStatus=$this->AdminsendMessage('9990588986','register',$orderDetails,$cartItemArray );
$AdminwhatsupMessageStatus=$this->AdminsendWhatsupMessage('9990588986','register',$orderDetails,$cartItemArray);
$orderStatus= $this->productModel->AddOrdersDetails($orderDetails);

return redirect()->route('PaymentSuccess');

}
  
 
 public function sendMessageForCashOnDelivery($mobile,$type,$orderDetails,$cartItemArray)
{

$productName = array();
    foreach($cartItemArray as $items){
    $productName[] =$items['name']; 
    }

    $productNameStr = implode(',',$productName);

    $message = rawurlencode('Your order has been Successfully Ordered  and Your order id is '.$orderDetails["order_id"].' and items are '.$productNameStr.' and total price is Rs.'.session('totalAmountForPaidAfterDiscountAndGST').'' );
    // $smsmessage = rawurlencode($message);
    $ch = curl_init('http://sms.clickconnectmedia.in/http-tokenkeyapi.php?authentic-key=32394f4a415356494e3633351612865765&senderid=CUROOT&route=1&number='.$mobile.'&message='.$message);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return 'success';  
 
}
  
 public function sendWhatsupMessageForCashOnDelivery($mobile ,$type,$orderDetails,$cartItemArray)
{
   $productName = array();
    foreach($cartItemArray as $items){
     $productName[] =$items['name']; 
    }
 
  $productNameStr = implode(',',$productName);
  $message = rawurlencode('Your order has been Successfully Ordered and Your order id is '.$orderDetails["order_id"].' and items are '.$productNameStr.' and total price is Rs.'.session('totalAmountForPaidAfterDiscountAndGST').'' );
  $url="http://promomessages.com/wapp/api/send?apikey=fc380814b4a9431caa6c844ecbfb13b8&mobile=".$mobile."%20&msg=".$message."";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $curl_scraped_page = curl_exec($ch);
  curl_close($ch);
  return 'success';  

}
 
  
  
public function sendMessage($mobile,$type,$orderDetails,$cartItemArray)
{

$productName = array();
    foreach($cartItemArray as $items){
    $productName[] =$items['name']; 
    }

    $productNameStr = implode(',',$productName);

    $message = rawurlencode('Your order has been Successfully Ordered and Your Payment is Done and Your order id is '.$orderDetails["order_id"].' and items are '.$productNameStr.' and total price is Rs.'.session('totalAmountForPaidAfterDiscountAndGST').'' );
    // $smsmessage = rawurlencode($message);
    
        $ch = curl_init('http://sms.clickconnectmedia.in/http-tokenkeyapi.php?authentic-key=32394f4a415356494e3633351612865765&senderid=CUROOT&route=1&number='.$mobile.'&message='.$message);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return 'success';  
 
}

public function sendWhatsupMessage($mobile ,$type,$orderDetails,$cartItemArray)
{
   $productName = array();
    foreach($cartItemArray as $items){

    $productName[] =$items['name']; 
    }
 
   $productNameStr = implode(',',$productName);
   
   $message = rawurlencode('Your order has been Successfully Ordered and Your Payment is Done and Your order id is '.$orderDetails["order_id"].' and items are '.$productNameStr.' and total price is Rs.'.session('totalAmountForPaidAfterDiscountAndGST').'' );
  
   $url="http://promomessages.com/wapp/api/send?apikey=fc380814b4a9431caa6c844ecbfb13b8&mobile=".$mobile."%20&msg=".$message."";
   
 

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curl_scraped_page = curl_exec($ch);
curl_close($ch);
return 'success';  

}





public function AdminsendMessage($mobile,$type,$orderDetails,$cartItemArray)
{
   
    $productName = array();
    foreach($cartItemArray as $items){
    $productName[] =$items['name']; 
    }

    $productNameStr = implode(',',$productName);
    $message = rawurlencode('An order has been made and order id is '.$orderDetails["order_id"].' and items are '.$productNameStr.' and total price is Rs.'.session('totalAmountForPaidAfterDiscountAndGST').'' );
    // $smsmessage = rawurlencode($message);
    
    $ch = curl_init('http://sms.clickconnectmedia.in/http-tokenkeyapi.php?authentic-key=32394f4a415356494e3633351612865765&senderid=CUROOT&route=1&number='.$mobile.'&message='.$message);

    
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return 'success';  
 
}


public function AdminsendWhatsupMessage($mobile ,$type,$orderDetails,$cartItemArray)
{
   $productName = array();
    foreach($cartItemArray as $items){

    $productName[] =$items['name']; 
    }
   $productNameStr = implode(',',$productName);
   $message = rawurlencode('An order has been made and order id is '.$orderDetails["order_id"].' and items are '.$productNameStr.' and total price is Rs.'.session('totalAmountForPaidAfterDiscountAndGST').'' );


    $url="http://promomessages.com/wapp/api/send?apikey=fc380814b4a9431caa6c844ecbfb13b8&mobile=".$mobile."%20&msg=".$message."";
    
   

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curl_scraped_page = curl_exec($ch);
curl_close($ch);
return 'success';  

}



    public function PaymentSuccess1(Request $request)
    {
        $data['Category'] = $this->productModel->CategoryList();
        $data['manuPage'] = $this->productModel->manuPage();
        $data['notification'] = $this->productModel->getProductNotification();
        
        \Cart::clear();
        Session::forget('totalAmountForPaidAfterDiscountAndGST');
        Session::forget('CategoryWiseGST');
        Session::forget('totalAmountForPaid');
        Session::forget('totalAmountForPaidAfterDiscount');
        Session::forget('discountAmount');
        Session::forget('DiscountCoupenCode');
        Session::forget('Discount');
        Session::forget('address');


        return view('New.payment-success')->with($data);
    
    }
    

    public function UserMailHtml($orderDetails,$cartItemArray)
    {
        
      
    $gst = $this->productModel->gst();
    $html ='';
    $html.='<html>';
    $html.='<head>';
    $html.='<meta charset="utf-8">';
    $html.='<meta http-equiv="x-ua-compatible" content="ie=edge">';
    $html.='<title>User Order</title>';
    $html.='<meta name="viewport" content="width=device-width, initial-scale=1">';
    
    	
    $html.='</head>';
    $html.='<body style="background-color: #EFF2F7;padding: 25px 0 !important;">';
    $html.='<div class="logo ">';
    $html.='<center><a href="'.route("Home").'">Saga Bags</a></center>';
    $html.='</div>';

    $html.='<table border="0" cellpadding="0" cellspacing="0" width="100%">';
    
    $html.='<tr>';
    $html.='<td align="left">';
    $html.='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;margin: auto;background: #fff;">';
    $html.='<tr>';
    $html.='<td align="left" valign="top" style="padding: 20px;">';
    $html.='Hi '.$orderDetails["billing_name"].',';
    
    
    $html.='<br/>';
    $html.=' <br/>';
    $html.='Your payment is successful.</br>';
    $html.='Your Order Id is '.$orderDetails["order_id"].'.</br></br>';
    $html.='<b>Need help? </b>';
    $html.='<br>';
    $html.='If there is anything else you would like to know or make amendment to your order,';
    $html.='<br/>';
    $html.='Please Call:- <b>02086927236</b>';
    $html.='<br/>';
    $html.='<br/>';
    $html.='<br/>';
    $html.='<b>ORDER SUMMARY.</b>';
    $html.='<br/>';
    $html.='<br/>';
    $html.='Order Ref: '.$orderDetails["order_id"];
    $html.='<br/>';
    $html.='Payment Type: '.$orderDetails["payment_type"];
    $html.='<br/>';
    $html.='Order Date: '.$orderDetails["txn_date"];
    $html.='<br/>';
    $html.='<br/>';

    if(!empty($orderDetails['billing_address'])){
        $address=$orderDetails['billing_address']; 
          $cus_address = json_decode($address);   


          $html.='<b>Delivery Address.</b>';
          $html.='<br/>';
          $html.='<br/>';
          $html.='<b>Country:- '.$cus_address->country.'</b>';
          $html.='<br/>';
          $html.='<br/>';      
          $html.='<b> Street Number:- '.@$cus_address->address.'</b>';
          $html.='<br/>';
          $html.='<br/>';  
          $html.='<b> City:- '.$cus_address->city.'</b>';
          $html.='<br/>';
          $html.='<br/>';  
          $html.='<b>State:- '.$cus_address->state.'</b>';
          $html.='<br/>';
          $html.='<br/>';  
          $html.='<b>Post Code:- '.$cus_address->postcode.'</b>';
          $html.='<br/>';




    }
    else{

        $html.='<b>Delivery Address.</b>';
          $html.='<br/>';
          $html.='<br/>';
          $html.='<b>Country:- </b>';
          $html.='<br/>';
          $html.='<br/>';      
          $html.='<b> Street Number:- </b>';
          $html.='<br/>';
          $html.='<br/>';  
          $html.='<b> City:- </b>';
          $html.='<br/>';
          $html.='<br/>';  
          $html.='<b>State:- </b>';
          $html.='<br/>';
          $html.='<br/>';  
          $html.='<b>Post Code:- </b>';
          $html.='<br/>';


    }

   
    $html.=' </td>';
    $html.='</tr>';
    $html.='</table>';
    $html.='</td>';
    $html.='</tr>';
    $html.='<tr>';
   
    $html.='<td align="left" style="padding: 10px;">';
          
    $html.='<table style=" font-family: arial, sans-serif;border-collapse: collapse;width: 600px;max-width: 100%;margin: auto;background: #fff;">';
    $html.='<tr>';
    $html.='<th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">#</th>   
    
                <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">ITEM</th>
                <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">QTY</th>
                <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">Unit Rs.
              </th>
              <th style="border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;">Price
            </th>
    
          </tr>';


          $i = 1;
          foreach($cartItemArray as $items){
      
          $html.='<tr>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$i.'</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$items['name'].'</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$items['quantity'].'</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$items['price'].' SAR</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$items['quantity']*$items['price'].' SAR</td>';
          $html.='</tr>';
      
       $i++;
          }
        $html.='<tr>';
          

          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">SUB TOTAL</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.session('totalAmountForPaidAfterDiscountAndGST').' SAR</td>';
    
          $html.='</tr>';
     $html.='<tr>';
          
          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">DISCOUNT</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.session('discountAmount').' SAR</td>';
    
          $html.='</tr>';
          $html.='<tr>';
          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">ORDER TOTAL:</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.session('totalAmountForPaidAfterDiscountAndGST').' SAR</td>';
          $html.='</tr>';

          $html.='<tr>';
          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">VAT(15%):</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.session('vatToPay').' SAR</td>';
          $html.='</tr>';

          $html.='<tr>';
          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">You Pay:</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.session('totalAmountForPaidAfterDiscountAndGST').'SAR</td>';
          $html.='</tr>';


          $html.='</table>
    
        <tr>
          <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;text-align: center;"><br>Warm regards, <br>
            <strong>Saga Bags</strong><br>
            <br>
          </td>
        </tr>
    
      </td>
    </tr>
    </table>
    
    </table>
    
    
    </body>
    </html>';
    
        return $html;
        
    }
    
    public function AdminMailHtml($orderDetails,$cartItemArray)
    {
      
      $gst = $this->productModel->gst();
 
    $html ='';
    $html.='<html>';
    $html.='<head>';
    $html.='<meta charset="utf-8">';
    $html.='<meta http-equiv="x-ua-compatible" content="ie=edge">';
    $html.='<title>Registration</title>';
    $html.='<meta name="viewport" content="width=device-width, initial-scale=1">';
    
    	
    $html.='</head>';
    $html.='<body style="background-color: #EFF2F7;padding: 25px 0 !important;">';
    $html.='<div class="logo ">';
    $html.='<center><a href="'.route("Home").'">Saga Bags</a></center>';
    $html.='</div>';
    $html.='<table border="0" cellpadding="0" cellspacing="0" width="100%">';
    $html.='<tr>';
    $html.='<td align="left">';
    $html.='<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;margin: auto;background: #fff;">';
    $html.='<tr>';
    $html.='<td align="left" valign="top" style="padding: 20px;">';
   
    $html.='<b>ORDER SUMMARY.</b>';
    $html.='<br/>';
    $html.='<br/>';

    $html.='Order Date: '.$orderDetails["txn_date"];
    $html.='<br/>';
    $html.='<br/>';
    $html.='Ordered By:'.$orderDetails["billing_name"];
    $html.='<br/>';
    $html.='<br/>';
    $html.='Payment Type: '.$orderDetails["payment_type"];
    $html.='<br/>';
    $html.='<br/>';

    $html.='Delivery Date: '.$orderDetails["txn_date"];
    $html.='<br/>';
     $html.='<br/>';
    $html.='Delivery Time: '.$orderDetails["txn_date"];
    $html.=' <br/>';
    $html.=' </td>';
    $html.='<b>Customer Address:-</b>';
    $html.='<br/>';
    $html.='<br/>';
 

 
 if(!empty($orderDetails['billing_address'])){
  $address=$orderDetails['billing_address']; 
    $cus_address = json_decode($address);   
     
     
   $html.='<b>Country:- '.$cus_address->country.'</b>';
    $html.='<br/>';
    $html.='<br/>';      
    $html.='<b> Street Number:- '.$cus_address->address.'</b>';
    $html.='<br/>';
    $html.='<br/>';  
    $html.='<b> City:- '.$cus_address->city.'</b>';
    $html.='<br/>';
    $html.='<br/>';  
    $html.='<b>State:- '.$cus_address->state.'</b>';
    $html.='<br/>';
    $html.='<br/>';  
    $html.='<b>Post Code:- '.$cus_address->postcode.'</b>';
    $html.='<br/>';
    $html.='<br/>';    
     
     
     
     
 }else{
     
  
   $html.='<b>Country:- </b>';
    $html.='<br/>';
    $html.='<br/>';      
    $html.='<b> Street Number:- </b>';
    $html.='<br/>';
    $html.='<br/>';  
    $html.='<b> City:- </b>';
    $html.='<br/>';
    $html.='<br/>';  
    $html.='<b>State:- </b>';
    $html.='<br/>';
    $html.='<br/>';  
    $html.='<b>Post Code:- </b>';
    $html.='<br/>';
    $html.='<br/>'; 
  
     
     
     
 }

    $html.='</tr>';
    $html.='</table>';
    $html.='</td>';
    $html.='</tr>';
    $html.='<tr>';
   
    $html.='<td align="left" style="padding: 10px;">';
          
    $html.='<table style=" font-family: arial, sans-serif;border-collapse: collapse;width: 600px;max-width: 100%;margin: auto;background: #fff;">';
    $html.='<tr>';
    $html.='<th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">#</th>   
    
                <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">ITEM</th>
                <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">QTY</th>
                <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">Unit Rs.
              </th>
              <th style="border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;">Price
            </th>
    
          </tr>';
          $i = 1;
          foreach($cartItemArray as $items){
      
          $html.='<tr>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$i.'</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$items['name'].'</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$items['quantity'].'</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.$items['price'].'</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.$items['quantity']*$items['price'].'</td>';
          $html.='</tr>';
      
       $i++;
          }
       $html.='<tr>';
          

          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">SUB TOTAL</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.session('totalAmountForPaid').'</td>';
    
          $html.='</tr>';
    $html.='<tr>';
          
          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">DISCOUNT('.session('Discount').'%)</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.session('discountAmount').'</td>';
    
          $html.='</tr>';
          $html.='<tr>';
          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">ORDER TOTAL:</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.session('totalAmountForPaidAfterDiscount').'</td>';
          $html.='</tr>';

          $html.='<tr>';
          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">GST:</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.$gst->GST.'</td>';
          $html.='</tr>';

          $html.='<tr>';
          $html.='<td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">You Pay:</td>';
          $html.='<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.session('totalAmountForPaidAfterDiscountAndGST').'</td>';
          $html.='</tr>';

          $html.='</table>
    
        <tr>
          <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;text-align: center;"><br>Warm regards, <br>
            <strong>Cure Root</strong><br>
            <br>
          </td>
        </tr>
    
      </td>
    </tr>
    </table>
    
    </table>
    
    
    </body>
    </html>';
    

        return $html;
        
    }
    
 
}
