<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use App\Http\Models\Front\HomeModel;
use Validator;
use Session;
use Redirect;
use DB;

class checkoutController extends Controller
{
	public function __construct(Request $request)
	{
		session_start();
		$this->HomeModel 	= new HomeModel();
		$this->Cart = new Cart();
	}

    public function checkout(){

    	$cartCollection = \Cart::getContent();
    	$Data['Settings']               = $this->HomeModel->Settings();
        $Data['cartCollection']               = $cartCollection;


        if(session('locale')=='en'){
            return view('en-SA/Front.checkout')->with($data);
        }
        else{
            return view('ar-SA/Front.checkout')->with($data);
        }

        //return view('Front.checkout')->withTitle('E-COMMERCE STORE | CART')->with($Data);
	}


	
	public function Payment(Request $request)
	{
		$UserID = Session::get('user_id');
		if(!isset($UserID)){
			return redirect(url('/login'));
		}else{

			$Data = $request->all();
			$User = DB::table('users')->where('id',$UserID)->first();

			$TOTAL 		= $Data['amount'];
			//$TOTAL 		= 1;
			$success_url 		= $Data['success_url'];
			$failure_url 		= $Data['failure_url'];
			$add_date = date('Y-m-d H:i:s');
			
			$OrderIdDetails = DB::table('order_id')->where('id',1)->first();
			$order_id = $OrderIdDetails->ordertype.$OrderIdDetails->orderno;
			$UpdateSerialNo = $OrderIdDetails->orderno+1;
			DB::table('order_id')->where('id',1)->update(['orderno'=>$UpdateSerialNo]);

			$ProID = explode(",", $Data['ProID']);
			$quantity = explode(",", $Data['quantity']);
			$qtyprice = explode(",", $Data['price']);
			$i = 0;
			$T_QTY = 0;

			$saveData['fullname'] 	= $Data['fullname'];
			$saveData['email'] 		= $Data['email'];
			$saveData['mobile'] 	= $Data['phone'];
			$saveData['fullAddress']= $Data['fullAddress'];	
			$saveData['city'] 		= $Data['city'];	
			$saveData['state'] 		= $Data['state'];	
			$saveData['country'] 	= $Data['country'];
			$saveData['pincode'] 	= $Data['zip_code'];
			$saveData['ref_name'] 	= $Data['ref_name'];
			$saveData['ref_mobile'] = $Data['ref_mobile'];
			$saveData['user_id'] 	= $UserID;
			$saveData['created_at'] = $add_date;
			
			$AddressId = $this->HomeModel->SaveBillingAddress($saveData);

			foreach ($ProID as $key => $itemId) {			
				$pro = DB::table('products')->select('id','title','price')->where('id',$itemId)->first();
				$Save['user_id'] 		= $UserID;
				$Save['product_id'] 	= $pro->id;
				$Save['order_id'] 		= $order_id;
				$Save['crt_quantity']	= $quantity[$i];
				$Save['product_price'] 	= $qtyprice[$i];
				$Save['status'] 		= '0';
				$Save['created_at'] 	= $add_date;
				$OrderItem = $this->HomeModel->SaveOrderItem($Save);
				$T_QTY += $quantity[$i];
				$i++;
			}

			$TXN_QTY = $T_QTY;
			$TXN_AMOUNT = $TOTAL;
			$country = 'IND';
			$currency = 'INR';
			$txn_type = 'SALE';
			$channel = 'WEB';

			$merchant_id = '201812240003';	
			$merchant_key = 'q1KE1ZsbAYi7UyofoCu658ZkxAIdVHHomTohFbyCufE=';
			$aggregator_id = "paygate";
			$avanthgarde_payment_url = "https://www.avantgardepayments.com/agcore/payment";

			/*$merchant_id = '201710270001';	
			$merchant_key = 'oqUl4D0LqA4plZw4reAX/K3UKJoQdet0k/N6X6K4Y5k=';
			$aggregator_id = "paygate";
			$avanthgarde_payment_url = "https://test.avantgardepayments.com/agcore/payment";*/
			
			$pg_id = '';	
			$paymode = '';	
			$scheme = '';	
			$emi_months = '';	

			$card_no = '';	
			$exp_month = '';	
			$exp_year = '';	
			$cvv2 = '';	
			$card_name = '';

			$bill_address = '';	
			$bill_city = '';	
			$bill_state = '';	
			$bill_country = '';	
			$bill_zip = '';	

			$ship_address = '';	
			$ship_city = '';	
			$ship_state = '';	
			$ship_country = '';	
			$ship_zip = '';	
			$ship_days = '';	
			$address_count = '';	

			$item_count = '';	
			$item_value = '';	
			$item_category = '';	

			$udf_1 = $AddressId;	
			$udf_2 = $TXN_QTY;	
			$udf_3 = '';	
			$udf_4 = '';	
			$udf_5 = '';	

			$return_elements = array();
			$return_elements['me_id'] = $merchant_id;
			$txn_details = $aggregator_id.'|'.$merchant_id.'|'.$order_id.'|'.$TXN_AMOUNT.'|'.$country.'|'.$currency.'|'.$txn_type.'|'.$success_url.'|'.$failure_url.'|'.$channel;
			$return_elements['txn_details'] = $this->encrypt($txn_details, $merchant_key, 256);
			
			$pg_details = $pg_id.'|'. $paymode . '|' . $scheme . '|' . $emi_months;
			$return_elements['pg_details'] = $this->encrypt($pg_details, $merchant_key, 256);
			
			$card_details = $card_no. '|' . $exp_month . '|' . $exp_year . '|' . $cvv2 . '|' . $card_name;
			$return_elements['card_details'] = $this->encrypt($card_details, $merchant_key, 256);
			
			$cust_details = $User->name . '|' . $User->email . '|' . $User->mobile . '|' . $UserID . '|Y';
			$return_elements['cust_details'] = $this->encrypt($cust_details, $merchant_key, 256);
			
			$bill_details = $bill_address . '|' . $bill_city . '|' . $bill_state . '|' . $bill_country . '|' . $bill_zip;
			$return_elements['bill_details'] = $this->encrypt($bill_details, $merchant_key, 256);
			
			$ship_details = $ship_address . '|' . $ship_city . '|' . $ship_state . '|' . $ship_country . '|' . $ship_zip . '|' . $ship_days . '|' . $address_count;
			$return_elements['ship_details'] = $this->encrypt($ship_details, $merchant_key, 256);
			
			$item_details = $item_count . '|' . $item_value . '|' . $item_category;
			$return_elements['item_details'] = $this->encrypt($item_details, $merchant_key, 256);
			
			$other_details = $udf_1 . '|' . $udf_2 . '|' . $udf_3 . '|' . $udf_4 . '|' . $udf_5;
			$return_elements['other_details'] = $this->encrypt($other_details, $merchant_key, 256);
			//echo "<pre>";print_r($return_elements);die;

			if (isset($return_elements))
			{
				echo '<form id="avanthgarde_payment_form" action="'.$avanthgarde_payment_url.'" method="POST">
						<input type="hidden" name="me_id" id="" value="' . $return_elements['me_id'] . '" />
						<input type="hidden" name="txn_details" id="" value="' . $return_elements['txn_details'] . '" />
						<input type="hidden" name="pg_details" id="" value="' . $return_elements['pg_details'] . '" />
						<input type="hidden" name="card_details" id="" value="' . $return_elements['card_details'] . '" />
						<input type="hidden" name="cust_details" id="" value="' . $return_elements['cust_details'] . '" />
						<input type="hidden" name="bill_details" id="" value="' . $return_elements['bill_details'] . '" />
						<input type="hidden" name="ship_details" id="" value="' . $return_elements['ship_details'] . '" />
						<input type="hidden" name="item_details" id="" value="' . $return_elements['item_details'] . '" />
						<input type="hidden" name="other_details" id="" value="' . $return_elements['other_details'] . '" />
					</form>';
				echo '<script type="text/javascript">document.getElementById("avanthgarde_payment_form").submit();</script>';	
			}else{
				echo "no data found";
			}
			
		}	
	}

	public function payResponse(Request $request)
	{
		$Data = $request->all();
		$USERID = Session::get('user_id');
		$aggregator_id = "paygate";
		if(isset($Data['txn_response']) && !empty($Data['txn_response']))
		{
			$merchant_key = "q1KE1ZsbAYi7UyofoCu658ZkxAIdVHHomTohFbyCufE=";
			$return_elements = array();
			$Data['txn_response']								= isset($Data['txn_response']) ? $Data['txn_response'] : '';
			$txn_response 										= $this->decrypt($Data['txn_response'], $merchant_key, 256);
			$txn_response_arr									= explode('|', $txn_response);

			$Data['other_details']								= isset($Data['other_details']) ? $Data['other_details'] : '';
			$other_details 										= $this->decrypt($Data['other_details'], $merchant_key, 256);
			$other_details_arr									= explode('|', $other_details);
			
			$return_elements['other_details']['address_id'] 	= isset($other_details_arr[0]) ? $other_details_arr[0] : '';
			$return_elements['other_details']['quantity'] 		= isset($other_details_arr[1]) ? $other_details_arr[1] : '';

			$return_elements['txn_response']['ag_id'] 			= isset($txn_response_arr[0]) ? $txn_response_arr[0] : '';
			$return_elements['txn_response']['me_id'] 			= isset($txn_response_arr[1]) ? $txn_response_arr[1] : '';
			$return_elements['txn_response']['order_no'] 		= isset($txn_response_arr[2]) ? $txn_response_arr[2] : '';
			$return_elements['txn_response']['amount'] 			= isset($txn_response_arr[3]) ? $txn_response_arr[3] : '';
			$return_elements['txn_response']['country'] 		= isset($txn_response_arr[4]) ? $txn_response_arr[4] : '';
			$return_elements['txn_response']['currency'] 		= isset($txn_response_arr[5]) ? $txn_response_arr[5] : '';
			$return_elements['txn_response']['txn_date'] 		= isset($txn_response_arr[6]) ? $txn_response_arr[6] : '';
			$return_elements['txn_response']['txn_time'] 		= isset($txn_response_arr[7]) ? $txn_response_arr[7] : '';
			$return_elements['txn_response']['ag_ref'] 			= isset($txn_response_arr[8]) ? $txn_response_arr[8] : '';
			$return_elements['txn_response']['pg_ref'] 			= isset($txn_response_arr[9]) ? $txn_response_arr[9] : '';
			$return_elements['txn_response']['status'] 			= isset($txn_response_arr[10]) ? $txn_response_arr[10] : '';
			$return_elements['txn_response']['res_code'] 		= isset($txn_response_arr[11]) ? $txn_response_arr[11] : '';
			$return_elements['txn_response']['res_message'] 	= isset($txn_response_arr[12]) ? $txn_response_arr[12] : '';
			
			$PMTSave['user_id']			=	$USERID;
			$PMTSave['quantity']		=	$return_elements['other_details']['quantity'];
			$PMTSave['address_id']		=	$return_elements['other_details']['address_id'];
			$PMTSave['ORDERID_PMT']		=	$return_elements['txn_response']['order_no'];
			$PMTSave['TXNAMOUNT_PMT']	=	$return_elements['txn_response']['amount'];
			$PMTSave['AGREFID_PMT']		=	$return_elements['txn_response']['ag_ref'];
			$PMTSave['PGREFID_PMT']		=	$return_elements['txn_response']['pg_ref'];
			$PMTSave['STATUS_PMT']		=	$return_elements['txn_response']['status'];
			$PMTSave['TXNDATE_PMT']		=	$return_elements['txn_response']['txn_date'].' '.$return_elements['txn_response']['txn_time'];
			$PMTSave['CURRENCY_PMT']	=	$return_elements['txn_response']['currency'];
			$PMTSave['RESPCODE_PMT']	=	$return_elements['txn_response']['res_code'];
			$PMTSave['IPADDRESS_PMT']	=	$_SERVER['REMOTE_ADDR'];
            $PMTSave['SESSIONID_PMT']  	=	Session::getId();
            
			if($PMTSave['STATUS_PMT']== "Successful") {
				DB::table('order_items')->where('order_id',$PMTSave['ORDERID_PMT'])->update(['status'=>'1']);
				$redirect_url = route('SuccessOrder',['OrderID'=>base64_encode($PMTSave['ORDERID_PMT'])]);
			}else{
				$redirect_url = route('FailureOrder',['OrderID'=>base64_encode($PMTSave['ORDERID_PMT'])]);
			}
			$PMTSave = $this->HomeModel->SaveOrders($PMTSave);
			return redirect($redirect_url);
			exit();
		}
		else{
			return redirect(url('/'));
			exit();
		}
	}

	public function encrypt($text, $key, $type)
	{ 
		$iv = "0123456789abcdef"; 
		$size =16;
		$pad = $size - (strlen($text) % $size);
		$padtext = $text . str_repeat(chr($pad) , $pad);
		$crypt = openssl_encrypt($padtext,"AES-256-CBC", base64_decode($key), OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,$iv); 
		return base64_encode($crypt);
	}

	public function decrypt($crypt, $key, $type)
	{
		$iv = "0123456789abcdef";
		$crypt = base64_decode($crypt);
	    $padtext = openssl_decrypt($crypt,"AES-256-CBC", base64_decode($key), OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,$iv); 
	    return $padtext;
	}


	public function FailureOrder($OrderID){
		$OrderID = base64_decode($OrderID);
		$Count = $this->HomeModel->CheckPMTOrderID($OrderID);
		if($Count==0){
			return redirect()->route('Home');
      exit();
		}
		$OrderDetails = $this->HomeModel->GetPMTOrderIDDetails($OrderID);
		$Data['Title'] 				= 'Payment Failed';
		$Data['Menu'] 				= 'Home';
		$Data['DivClass'] 			= 'buy';
		$Data['OrderDetails'] 		= $OrderDetails;
		return View('Front.FailedOrder')->with($Data);
	}

	public function SuccessOrder($OrderID){
		\Cart::clear();
		//$OrderID = "ORD1000038";
		$OrderID = base64_decode($OrderID);
		$Count = $this->HomeModel->CheckPMTOrderID($OrderID);
		if($Count==0){
			return redirect()->route('Home');
      		exit();
		}
		$OrderDetails = $this->HomeModel->GetPMTOrderIDDetails($OrderID);
		$OrderItems = $this->HomeModel->GetPMTOrderItems($OrderID);
		$OrderAddress = $this->HomeModel->GetPMTOrderAddress($OrderDetails->address_id);
		$OrderTotalPrice = 0;
		
		foreach ($OrderItems as $items) {
			$OrderPriceItem[] = $items->product_price;
			$OrderQtyItem[] = $items->crt_quantity;
			$OrderProduct[] = $this->HomeModel->ProductsDetails($items->product_id);
		}
		
		foreach ($OrderPriceItem as $key=>$itemPrice) {
		    $OrderTotalPrice +=  $itemPrice * $OrderQtyItem[$key];
		}

		$Data['Title'] 				= 'Payment Success';
		$Data['Menu'] 				= 'Home';
		$Data['DivClass'] 			= 'buy';
		$Data['OrderDetails'] 		= $OrderDetails;
		$Data['OrderItems'] 		= $OrderItems;
		$Data['OrderProduct'] 		= $OrderProduct;
		$Data['OrderTotalPrice'] 	= $OrderTotalPrice;
		$Data['OrderAddress'] 		= $OrderAddress;
		return View('Front.SuccessOrder')->with($Data);
	}

}
