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
use DateTime;
use Illuminate\Http\Request;
use App\Http\Models\Admin\OrderModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;


class OrderController extends Controller 
{
	public function __construct(Request $request)
	{
		$this->OrderModel = new OrderModel();	
	}

	public function List(){
		$Data['Title'] 				= 'Order';
		$Data['Menu'] 				= 'Order';
		$Data['SubMenu'] 			= '';
    $Data['SelectMenu']         = '';
    $Data['OrderArr']           = $this->OrderModel->Listing();
    
	return View('Admin/Order/List')->with($Data);
	
	}

  public function genearteSipment($id)
  {

$curl = curl_init();
$date  = \Carbon\Carbon::now()->timestamp;

$dataArry = [
  'ClientInfo' => [
    'UserName' => 'reem@reem.com',
    'Password' => '123456789',
    'Version' => 'v1',
    'AccountNumber' => '20016',
    'AccountPin' => '331421',
    'AccountEntity' => 'AMM',
    'AccountCountryCode' => 'JO',
    'Source' => 24,
  ],
  'LabelInfo' => NULL,
  'Shipments' => [
    0 => [
      'Reference1' => '',
      'Reference2' => '',
      'Reference3' => '',
      'Shipper' => [
        'Reference1' => '',
        'Reference2' => '',
        'AccountNumber' => '20016',
        'PartyAddress' => [
          'Line1' => 'Test',
          'Line2' => '',
          'Line3' => '',
          'City' => 'Amman',
          'StateOrProvinceCode' => '',
          'PostCode' => '',
          'CountryCode' => 'JO',
          'Longitude' => 0,
          'Latitude' => 0,
          'BuildingNumber' => NULL,
          'BuildingName' => NULL,
          'Floor' => NULL,
          'Apartment' => NULL,
          'POBox' => NULL,
          'Description' => NULL,
        ],
        'Contact' => [
          'Department' => '',
          'PersonName' => 'aramex',
          'Title' => '',
          'CompanyName' => 'aramex',
          'PhoneNumber1' => '009625515111',
          'PhoneNumber1Ext' => '',
          'PhoneNumber2' => '',
          'PhoneNumber2Ext' => '',
          'FaxNumber' => '',
          'CellPhone' => '9677956000200',
          'EmailAddress' => 'test@test.com',
          'Type' => '',
        ],
      ],
      'Consignee' => [
        'Reference1' => '',
        'Reference2' => '',
        'AccountNumber' => '',
        'PartyAddress' => [
          'Line1' => 'Test',
          'Line2' => '',
          'Line3' => '',
          'City' => 'Duabi',
          'StateOrProvinceCode' => '',
          'PostCode' => '',
          'CountryCode' => 'AE',
          'Longitude' => 0,
          'Latitude' => 0,
          'BuildingNumber' => '',
          'BuildingName' => '',
          'Floor' => '',
          'Apartment' => '',
          'POBox' => NULL,
          'Description' => '',
        ],
        'Contact' => [
          'Department' => '',
          'PersonName' => 'aramex',
          'Title' => '',
          'CompanyName' => 'aramex',
          'PhoneNumber1' => '009625515111',
          'PhoneNumber1Ext' => '',
          'PhoneNumber2' => '',
          'PhoneNumber2Ext' => '',
          'FaxNumber' => '',
          'CellPhone' => '9627956000200',
          'EmailAddress' => 'test@test.com',
          'Type' => '',
        ],
      ],
      'ThirdParty' => [
        'Reference1' => '',
        'Reference2' => '',
        'AccountNumber' => '',
        'PartyAddress' => [
          'Line1' => '',
          'Line2' => '',
          'Line3' => '',
          'City' => '',
          'StateOrProvinceCode' => '',
          'PostCode' => '',
          'CountryCode' => '',
          'Longitude' => 0,
          'Latitude' => 0,
          'BuildingNumber' => NULL,
          'BuildingName' => NULL,
          'Floor' => NULL,
          'Apartment' => NULL,
          'POBox' => NULL,
          'Description' => NULL,
        ],
        'Contact' => [
          'Department' => '',
          'PersonName' => '',
          'Title' => '',
          'CompanyName' => '',
          'PhoneNumber1' => '',
          'PhoneNumber1Ext' => '',
          'PhoneNumber2' => '',
          'PhoneNumber2Ext' => '',
          'FaxNumber' => '',
          'CellPhone' => '',
          'EmailAddress' => '',
          'Type' => '',
        ],
      ],
      'ShippingDateTime' => time() + 50000,
      'DueDate' => time() + 60000,
      'Comments' => '',
      'PickupLocation' => '',
      'OperationsInstructions' => '',
      'AccountingInstrcutions' => '',
      'Details' => [
        'Dimensions' => NULL,
        'ActualWeight' => [
          'Unit' => 'KG',
          'Value' => 0.5,
        ],
        'ChargeableWeight' => NULL,
        'DescriptionOfGoods' => 'Books',
        'GoodsOriginCountry' => 'JO',
        'NumberOfPieces' => 1,
        'ProductGroup' => 'EXP',
        'ProductType' => 'PDX',
        'PaymentType' => 'P',
        'PaymentOptions' => '',
        'CustomsValueAmount' => NULL,
        'CashOnDeliveryAmount' => NULL,
        'InsuranceAmount' => NULL,
        'CashAdditionalAmount' => NULL,
        'CashAdditionalAmountDescription' => '',
        'CollectAmount' => NULL,
        'Services' => '',
        'Items' => [
        ],
      ],
      'Attachments' => [
      ],
      'ForeignHAWB' => '',
      'TransportType ' => 0,
      'PickupGUID' => '',
      'Number' => NULL,
      'ScheduledDelivery' => NULL,
    ],
  ],
  'Transaction' => [
    'Reference1' => '',
    'Reference2' => '',
    'Reference3' => '',
    'Reference4' => '',
    'Reference5' => '',
  ],
];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreateShipments',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode($dataArry),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
die();


    $orderDetails = DB::table('orders')
                ->select('*')
                ->where('order_id',$id)
                ->first();

                $data = Aramex::createPickup([
                  'name' => 'MyName',
                  'cell_phone' => '+123123123',
                  'phone' => '+123123123',
                  'email' => 'myEmail@gmail.com',
                  'city' => 'New York',
                  'country_code' => 'US',
                  'zip_code'=> 10001,
                  'line1' => 'The line1 Details',
                  'line2' => 'The line2 Details',
                  'line3' => 'The line2 Details',
                  'pickup_date' => time() + 45000,
                  'ready_time' => time()  + 43000,
                  'last_pickup_time' => time() +  45000,
                  'closing_time' => time()  + 45000,
                  'status' => 'Ready', 
                  'pickup_location' => 'some location',
                  'weight' => 123,
                  'volume' => 1
                ]);

        // extracting GUID
       if (!$data->error)
          $guid = $data->pickupGUID;


    echo "<pre>";print_r($guid);"</pre>";exit;
  }

	public function RefundList(){
		$Data['Title'] 				= 'Refund';
		$Data['Menu'] 				= 'Refund';
		$Data['SubMenu'] 			= '';
        $Data['SelectMenu']         = '';
        $Data['OrderArr']           = $this->OrderModel->RefundListing();
		return View('Admin/Refund/List')->with($Data);
		
	}

	public function DeliveredOrderList(){
		$Data['Title'] 				= 'DeliveredOrder';
		$Data['Menu'] 				= 'DeliveredOrder';
		$Data['SubMenu'] 			= '';
        $Data['SelectMenu']         = '';
        $Data['OrderArr']           = $this->OrderModel->DeliveredOrderListing();
		return View('Admin/DeliveredOrder/List')->with($Data);
		
	}
	
	public function OrderTracking(){
		$Data['Title'] 				= 'OrderTracking';
		$Data['Menu'] 				= 'OrderTracking';
		$Data['SubMenu'] 			= '';
        $Data['SelectMenu']         = '';
        $Data['OrderArr']           = $this->OrderModel->OrderTrackingListing();
		return View('Admin/OrderTracking/List')->with($Data);
		
	}
	
	
	public function GenerateInvoice($id){
        
      
		$orderDetails = DB::table('orders')
								   ->select('*')
								   ->where('order_id',$id)
								   ->first();

                   $billingAddress = DB::table('user_authentication_details')
                   ->select('*')
                   ->where('email',$orderDetails->billing_email)
                   ->first();
                      
						  $orders['orderData']   =  $orderDetails;
              $orders['billingAddress']   =  $billingAddress;
						  $orders['gst'] = $this->OrderModel->gst();
					

return View('Admin/generate-invoice')->with($orders);
	   
   }
   
   	public function GetOrderDetails($id){
        
      
		$orderDetails = DB::table('orders')
								   ->select('*')
								   ->where('order_id',$id)
								   ->first();
   
 
						  $orders['orderData']   =  $orderDetails;
						  $orders['Title']   =  'Order Details';
              $orders['Menu'] 				= 'User';
              $orders['SubMenu'] 			= '';
              $orders['SelectMenu']         = '';

return View('Admin/Order/order_detials')->with($orders);
	   
   }
   
   public function ShipUserOrder(Request $request)
   {
     $shipping_time_initial = time()+50000;
     $shipping_time = $shipping_time_initial.'303-0500';
     $due_time_initial = time()+60000;
     $due_time = $due_time_initial.'303-0500';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreateShipments");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
    "{\"ClientInfo\":{\"UserName\":\"reem@reem.com\",\"Password\":\"123456789\",\"Version\":\"1.0\",\"AccountNumber\":\"4004636\",\"AccountPin\":\"432432\",\"AccountEntity\":\"RUH\",\"AccountCountryCode\":\"SA\",\"Source\":24},\"LabelInfo\":null,\"Shipments\":[{\"Reference1\":\"\",\"Reference2\":\"\",\"Reference3\":\"\",\"Shipper\":{\"Reference1\":\"\",\"Reference2\":\"\",\"AccountNumber\":\"4004636\",\"PartyAddress\":{\"Line1\":\"Test\",\"Line2\":\"\",\"Line3\":\"\",\"City\":\"Amman\",\"StateOrProvinceCode\":\"\",\"PostCode\":\"\",\"CountryCode\":\"JO\",\"Longitude\":0,\"Latitude\":0,\"BuildingNumber\":null,\"BuildingName\":null,\"Floor\":null,\"Apartment\":null,\"POBox\":null,\"Description\":null},\"Contact\":{\"Department\":\"\",\"PersonName\":\"aramex\",\"Title\":\"\",\"CompanyName\":\"aramex\",\"PhoneNumber1\":\"009625515111\",\"PhoneNumber1Ext\":\"\",\"PhoneNumber2\":\"\",\"PhoneNumber2Ext\":\"\",\"FaxNumber\":\"\",\"CellPhone\":\"9677956000200\",\"EmailAddress\":\"test@test.com\",\"Type\":\"\"}},\"Consignee\":{\"Reference1\":\"\",\"Reference2\":\"\",\"AccountNumber\":\"\",\"PartyAddress\":{\"Line1\":\"Test\",\"Line2\":\"\",\"Line3\":\"\",\"City\":\"Duabi\",\"StateOrProvinceCode\":\"\",\"PostCode\":\"\",\"CountryCode\":\"AE\",\"Longitude\":0,\"Latitude\":0,\"BuildingNumber\":\"\",\"BuildingName\":\"\",\"Floor\":\"\",\"Apartment\":\"\",\"POBox\":null,\"Description\":\"\"},\"Contact\":{\"Department\":\"\",\"PersonName\":\"aramex\",\"Title\":\"\",\"CompanyName\":\"aramex\",\"PhoneNumber1\":\"009625515111\",\"PhoneNumber1Ext\":\"\",\"PhoneNumber2\":\"\",\"PhoneNumber2Ext\":\"\",\"FaxNumber\":\"\",\"CellPhone\":\"9627956000200\",\"EmailAddress\":\"test@test.com\",\"Type\":\"\"}},\"ThirdParty\":{\"Reference1\":\"\",\"Reference2\":\"\",\"AccountNumber\":\"\",\"PartyAddress\":{\"Line1\":\"\",\"Line2\":\"\",\"Line3\":\"\",\"City\":\"\",\"StateOrProvinceCode\":\"\",\"PostCode\":\"\",\"CountryCode\":\"\",\"Longitude\":0,\"Latitude\":0,\"BuildingNumber\":null,\"BuildingName\":null,\"Floor\":null,\"Apartment\":null,\"POBox\":null,\"Description\":null},\"Contact\":{\"Department\":\"\",\"PersonName\":\"\",\"Title\":\"\",\"CompanyName\":\"\",\"PhoneNumber1\":\"\",\"PhoneNumber1Ext\":\"\",\"PhoneNumber2\":\"\",\"PhoneNumber2Ext\":\"\",\"FaxNumber\":\"\",\"CellPhone\":\"\",\"EmailAddress\":\"\",\"Type\":\"\"}},\"ShippingDateTime\":\"\\/Date($shipping_time)\\/\",\"DueDate\":\"\\/Date($due_time)\\/\",\"Comments\":\"\",\"PickupLocation\":\"\",\"OperationsInstructions\":\"\",\"AccountingInstrcutions\":\"\",\"Details\":{\"Dimensions\":null,\"ActualWeight\":{\"Unit\":\"KG\",\"Value\":0.5},\"ChargeableWeight\":null,\"DescriptionOfGoods\":\"Books\",\"GoodsOriginCountry\":\"JO\",\"NumberOfPieces\":1,\"ProductGroup\":\"EXP\",\"ProductType\":\"PDX\",\"PaymentType\":\"P\",\"PaymentOptions\":\"\",\"CustomsValueAmount\":null,\"CashOnDeliveryAmount\":null,\"InsuranceAmount\":null,\"CashAdditionalAmount\":null,\"CashAdditionalAmountDescription\":\"\",\"CollectAmount\":null,\"Services\":\"\",\"Items\":[]},\"Attachments\":[],\"ForeignHAWB\":\"\",\"TransportType \":0,\"PickupGUID\":\"\",\"Number\":null,\"ScheduledDelivery\":null}],\"Transaction\":{\"Reference1\":\"\",\"Reference2\":\"\",\"Reference3\":\"\",\"Reference4\":\"\",\"Reference5\":\"\"}}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = [
      'Content-Type: application/json',
      'Accept: application/json',
     ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $results = curl_exec($ch);
    curl_close($ch);
      print_r($results);
    exit(0);
    $results = json_decode($results,true);

            
  
           
   }
   
  public function placeOrder($token,$orderDetails,$billingAddress,$billingOrderDetails,$request)
  {
      $length= $request->length;
      $breadth= $request->breadth;
      $height= $request->height;
      $weight= $request->weight;
    //   dd($weight);

    //  dd($orderDetails);
    //  dd($billingAddress);
    //  dd($billingOrderDetails);

$orderId =$orderDetails->order_id;

$html='';
$i=1;
foreach($billingOrderDetails as $key=>$value )
{
   $html.='{
       "name": "'.$value->name.'",
       "sku": "sku'.$i.'",
      "units": "'.$value->quantity.'",
       "selling_price": "'.$value->price.'",
       "discount": "",
       "tax": "",
       "hsn": 441122
    },';
 $i++;   
}

$html = rtrim($html,",");
// dd($html);
//   dd($billingOrderDetails); 

    // $data = '{"order_id": "'.$orderId.'",
    //   "order_date": "'.$orderDetails->txn_date.'",
    //   "pickup_location": "cureroot",
    //   "billing_customer_name": "'.$orderDetails->billing_name.'",
    //   "billing_last_name": "",
    //   "billing_address": "'.$billingAddress->street_Address.'",
    //   "billing_address_2": "",
    //   "billing_city": "'.$billingAddress->city.'",
    //   "billing_pincode": "'.$billingAddress->pin_code.'",
    //   "billing_state": "'.$billingAddress->state.'",
    //   "billing_country": "'.$billingAddress->country.'",
    //   "billing_email": "'.$orderDetails->billing_email.'",
    //   "billing_phone": "'.$orderDetails->billing_tel.'",
    //   "shipping_is_billing": true,
    //   "shipping_customer_name": "",
    //   "shipping_last_name": "",
    //   "shipping_address": "",
    //   "shipping_address_2": "",
    //   "shipping_city": "",
    //   "shipping_pincode": "",
    //   "shipping_country": "",
    //   "shipping_state": "",
    //   "shipping_email": "",
    //   "shipping_phone": "",
    //   "order_items": ['.$html.'],
    //   "payment_method": "Prepaid",
    //   "shipping_charges": 100,
    //   "giftwrap_charges": 0,
    //   "transaction_charges": 0,
    //   "total_discount": 0,
    //   "sub_total": "'.$orderDetails->txn_amount.'",
    //   "length": '.$length.',
    //   "breadth": '.$breadth.',
    //   "height": '.$height.',
    //   "weight": '.$weight.'
    // 	}';
    	
    // dd($data);





     $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>'{"order_id": "'.$orderId.'",
  "order_date": "'.$orderDetails->txn_date.'",
  "pickup_location": "ojasvin",
  "billing_customer_name": "'.$orderDetails->billing_name.'",
  "billing_last_name": "",
  "billing_address": "'.$billingAddress->street_Address.'",
  "billing_address_2": "",
  "billing_city": "'.$billingAddress->city.'",
  "billing_pincode": "'.$billingAddress->pin_code.'",
  "billing_state": "'.$billingAddress->state.'",
  "billing_country": "'.$billingAddress->country.'",
  "billing_email": "'.$orderDetails->billing_email.'",
  "billing_phone": "'.$orderDetails->billing_tel.'",
  "shipping_is_billing": true,
  "shipping_customer_name": "",
  "shipping_last_name": "",
  "shipping_address": "",
  "shipping_address_2": "",
  "shipping_city": "",
  "shipping_pincode": "",
  "shipping_country": "",
  "shipping_state": "",
  "shipping_email": "",
  "shipping_phone": "",
  "order_items": ['.$html.'],
  "payment_method": "Prepaid",
  "shipping_charges": 1,
  "giftwrap_charges": 0,
  "transaction_charges": 0,
  "total_discount": 0,
  "sub_total": "'.$orderDetails->txn_amount.'",
   "length": '.$length.',
   "breadth": '.$breadth.',
   "height": '.$height.',
   "weight": '.$weight.'
	}',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
	   "Authorization: Bearer $token"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  
  return $SR_login_Response;
  
  //$SR_login_Response_out = json_decode($SR_login_Response);
  echo '<pre>';
  
//   print_r($SR_login_Response);
//         exit();

      
  }
  
    public function userOrdertracking($token)
    {

        
        $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/courier/track?order_id=656756667",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
	CURLOPT_HTTPGET  => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_HTTPHEADER => array(
	   "Authorization: Bearer $token"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  //$SR_login_Response_out = json_decode($SR_login_Response);
  echo '<pre>';
  print_r($SR_login_Response);
  exit();
    }
    
        public function CancelOrder($token,$request)
    {
     $orderId = DB::table('order_shipping_details')->select('s_order_id')->where(['ordered_order_id'=>$request->order_id])->first();  
     $shipmentorderid =$orderId->s_order_id;

    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/cancel",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"ids\": [$shipmentorderid]\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer $token"
  ),
));

$response = curl_exec($curl);
curl_close($curl);

return $response;

    }
    
public function GenerateAWBforShipment($token,$shipment_id)
{
     
        // dd($shipment_id);
    //  $orderId = DB::table('order_shipping_details')->select('s_order_id')->where(['ordered_order_id'=>$request->order_id])->first();  
    //  $shipmentorderid =$orderId->s_order_id;

  $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/assign/awb',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "shipment_id": '.$shipment_id.',
    "courier_id": "",
    "status": ""
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer $token'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;


    }   
   
   
public function ShipOrder($token)
    {
        
     $orderId = DB::table('order_shipping_details')->select('s_shipment_id')->where(['ordered_order_id'=>$request->order_id])->first();  
     $shipmentorderid =$orderId->s_shipment_id;

    
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/assign/awb',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "shipment_id": "",
    "courier_id": ""
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer $token'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

return $response;
    }
     
     
public function CheckCourierServiceabilityOrder()
    {
        
             $Data = $this->OrderModel->checkShipingToken(); 
             $token=$Data[0]->token;
             $TokenDate=$Data[0]->add_date;
             $tokenTimeStr = strtotime($TokenDate);
             $currentTimeStr = strtotime(date("Y-m-d H:i:s"));
             $diff_time = $currentTimeStr-$tokenTimeStr;

             if($diff_time < 86400)
             {
                 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>'{
    "shipment_id": "'.$shipment_id.'",
    "courier_id": ""
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer $token'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

// return $response;

             }
             else
             {
             $token = $this->generateToken();
             $status = $requestData['status'];    
             $tokenArray['token'] = $token;
             $tokenArray['add_date'] = date("Y-m-d H:i:s");
             $tokenStatus = $this->OrderModel->submitShiprocketToken($tokenArray);  
             
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer $token'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
// return $response;

             }
    

    }
    
    public function RequestforShipmentPickupOrder($token)
    {
    //  $orderId = DB::table('order_shipping_details')->select('s_shipment_id')->where(['ordered_order_id'=>$request->order_id])->first();  
    //  $shipmentorderid =$orderId->s_shipment_id;

    
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/generate/pickup',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
	"shipment_id": [""]
	
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer $token'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

return $response;

}


	
}