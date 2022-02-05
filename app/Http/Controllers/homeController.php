<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\ProductsModel;
use App\Http\Models\Admin\BlogsModel;
use App\Http\Models\Front\HomeModel;
use App\Mail\UserOrder;
use App\Contact;
use App\Http\Controllers\homeController;
use App\Http\Models\Admin\CategoryModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Helpers\Common;
use Cart;
use Session;


class homeController extends Controller
{
   
    public function __construct(Request $request)
    {

        $this->ProductModel  = new ProductsModel();
        $this->BlogsModel = new BlogsModel();
        $this->CategoryModel = new CategoryModel();
        $this->HomeModel = new HomeModel();
    }

    public function fetchCountries()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://ws.dev.aramex.net/ShippingAPI.V2/Location/Service_1_0.svc/json/FetchCountries',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "ClientInfo": {
                "UserName": "reem@reem.com", 
                "Password": "123456789",
                "Version": "1.0",
                "AccountNumber":"4004636",
                "AccountPin": "432432",
                "AccountEntity": "RUH",
                "AccountCountryCode": "SA",
                "Source": 24
                },
                "Transaction": {
                    "Reference1": "",
                    "Reference2": "",
                    "Reference3": "",
                    "Reference4": "",
                    "Reference5": ""
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        $country_data = json_decode($response,true);

        // echo "<pre>";print_r($country_data['Countries']);"</pre>";exit;

        foreach($country_data['Countries'] as $country){

            // DB::statement("INSERT INTO `countries` (`Code`, `Name`, `IsoCode`, `StateRequired`, `PostCodeRequired`, `InternationalCallingNumber`, `created_at`) VALUES ('', '', '', '', '', '', '')");
            // SQL: INSERT INTO `countries` (`Code`, `Name`, `IsoCode`, `StateRequired`, `PostCodeRequired`, `InternationalCallingNumber`, `created_at`) VALUES ('AD', 'Andorra', 'AND', '1', '', '376', '2022-02-05 09:33:33'))

          DB::statement("INSERT INTO `countries` (`Code`, `Name`, `IsoCode`, `StateRequired`, `PostCodeRequired`, `InternationalCallingNumber`, `created_at`) VALUES ('".$country['Code']."', '".$country['Name']."', '".$country['IsoCode']."', '".$country['StateRequired']."', '".$country['PostCodeRequired']."', '".$country['InternationalCallingNumber']."', '".NOW()."')");
      }

        echo "<pre>";print_r($response);"</pre>";exit;

        curl_close($curl);
        echo $response;

    }

    public function fetchStates()
    {
        ini_set('max_execution_time', 18000);

        $curl = curl_init();

        $countries = DB::table('countries')->get(['Code']);

        foreach ($countries as $key => $country) {

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://ws.dev.aramex.net/ShippingAPI.V2/Location/Service_1_0.svc/json/FetchStates',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "ClientInfo": {
                "UserName": "reem@reem.com",
                "Password": "123456789",
                "Version": "v1",
                "AccountNumber": "20016",
                "AccountPin": "331421",
                "AccountEntity": "AMM",
                "AccountCountryCode": "JO",
                "Source": 24
                },
                "CountryCode": "'.$country->Code.'",
                "Transaction": {
                    "Reference1": "",
                    "Reference2": "",
                    "Reference3": "",
                    "Reference4": "",
                    "Reference5": ""
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        $data = json_decode($response,true);

        $state_data = $data['States'];

        foreach ($state_data as $key => $state) {

            DB::statement("INSERT INTO `states` (`CountryCode`, `Code`, `Name`, `created_at`) VALUES ('".$country->Code."', '".@$state['Code']."', '".addslashes(@$state['Name'])."', '".NOW()."')");
        }

    }
        curl_close($curl);

        die('completed');

    }


    public function calculateRate($CountryCode='',$StateOrProvinceCode='',$City='',$PostCode='',$Line1='',$Line2='',$Line3='')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://ws.dev.aramex.net/ShippingAPI.V2/RateCalculator/Service_1_0.svc/json/CalculateRate',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "ClientInfo": {
                "UserName": "reem@reem.com",
                "Password": "123456789",
                "Version": "1.0",
                "AccountNumber": "4004636",
                "AccountPin": "432432",
                "AccountEntity": "RUH",
                "AccountCountryCode": "SA",
                "Source": 24
                },
                "DestinationAddress": {
                    "Line1": "XYZ Street",
                    "Line2": "Unit # 1",
                    "Line3": "",
                    "City": "Delhi",
                    "StateOrProvinceCode": "Delhi",
                    "PostCode": "110093",
                    "CountryCode": "IN",
                    "Longitude": 0,
                    "Latitude": 0,
                    "BuildingNumber": null,
                    "BuildingName": null,
                    "Floor": null,
                    "Apartment": null,
                    "POBox": null,
                    "Description": null
                    },
                    "OriginAddress": {
                        "Line1": "ABC Street",
                        "Line2": "Unit # 1",
                        "Line3": "",
                        "City": "Amman",
                        "StateOrProvinceCode": "",
                        "PostCode": "",
                        "CountryCode": "JO",
                        "Longitude": 0,
                        "Latitude": 0,
                        "BuildingNumber": null,
                        "BuildingName": null,
                        "Floor": null,
                        "Apartment": null,
                        "POBox": null,
                        "Description": null
                        },
                        "PreferredCurrencyCode": "SAR",
                        "ShipmentDetails": {
                            "Dimensions": null,
                            "ActualWeight": {
                                "Unit": "KG",
                                "Value": 1
                                },
                                "ChargeableWeight": null,
                                "DescriptionOfGoods": null,
                                "GoodsOriginCountry": null,
                                "NumberOfPieces": 1,
                                "ProductGroup": "EXP",
                                "ProductType": "PPX",
                                "PaymentType": "P",
                                "PaymentOptions": "",
                                "CustomsValueAmount": null,
                                "CashOnDeliveryAmount": null,
                                "InsuranceAmount": null,
                                "CashAdditionalAmount": null,
                                "CashAdditionalAmountDescription": null,
                                "CollectAmount": null,
                                "Services": "",
                                "Items": null,
                                "DeliveryInstructions": null
                                },
                                "Transaction": {
                                    "Reference1": "",
                                    "Reference2": "",
                                    "Reference3": "",
                                    "Reference4": "",
                                    "Reference5": ""
                                }
                            }',
                            CURLOPT_HTTPHEADER => array(
                                'Content-Type: application/json',
                                'Accept: application/json'
                            ),
                        ));

$response = curl_exec($curl);

$result = json_decode($response,true);

if ($result['HasErrors']) {
    foreach ($result['Notifications'] as $key => $Notifications) {
        echo $Notifications['Message'];
    }
}

curl_close($curl);


// echo $response;
echo "<pre>";print_r($result['TotalAmount']);"</pre>";exit;
die();

}


public function createShipment($value='')
{

    $curl = curl_init();

    $date = '10/02/2022';
    $date1 = '12/02/2022';

   $shiping_date_time = \Carbon\Carbon::parse($date)->timestamp;
 $end_date_time = \Carbon\Carbon::parse($date1)->timestamp;

$arrayVar = [
    "ClientInfo" => [
        "UserName" => "reem@reem.com",
        "Password" => "123456789",
        "Version" => "1.0",
        "AccountNumber" => "4004636",
        "AccountPin" => "432432",
        "AccountEntity" => "RUH",
        "AccountCountryCode" => "SA",
        "Source" => 24,
    ],
    "LabelInfo" => null,
    "Shipments" => [
        [
            "Reference1" => "",
            "Reference2" => "",
            "Reference3" => "",
            "Shipper" => [
                "Reference1" => "",
                "Reference2" => "",
                "AccountNumber" => "4004636",
                "PartyAddress" => [
                    "Line1" => "Test",
                    "Line2" => "",
                    "Line3" => "",
                    "City" => "Amman",
                    "StateOrProvinceCode" => "",
                    "PostCode" => "",
                    "CountryCode" => "JO",
                    "Longitude" => 0,
                    "Latitude" => 0,
                    "BuildingNumber" => null,
                    "BuildingName" => null,
                    "Floor" => null,
                    "Apartment" => null,
                    "POBox" => null,
                    "Description" => null,
                ],
                "Contact" => [
                    "Department" => "",
                    "PersonName" => "aramex",
                    "Title" => "",
                    "CompanyName" => "aramex",
                    "PhoneNumber1" => "009625515111",
                    "PhoneNumber1Ext" => "",
                    "PhoneNumber2" => "",
                    "PhoneNumber2Ext" => "",
                    "FaxNumber" => "",
                    "CellPhone" => "9677956000200",
                    "EmailAddress" => "test@test.com",
                    "Type" => "",
                ],
            ],
            "Consignee" => [
                "Reference1" => "",
                "Reference2" => "",
                "AccountNumber" => "",
                "PartyAddress" => [
                    "Line1" => "Test",
                    "Line2" => "",
                    "Line3" => "",
                    "City" => "Duabi",
                    "StateOrProvinceCode" => "",
                    "PostCode" => "",
                    "CountryCode" => "AE",
                    "Longitude" => 0,
                    "Latitude" => 0,
                    "BuildingNumber" => "",
                    "BuildingName" => "",
                    "Floor" => "",
                    "Apartment" => "",
                    "POBox" => null,
                    "Description" => "",
                ],
                "Contact" => [
                    "Department" => "",
                    "PersonName" => "aramex",
                    "Title" => "",
                    "CompanyName" => "aramex",
                    "PhoneNumber1" => "009625515111",
                    "PhoneNumber1Ext" => "",
                    "PhoneNumber2" => "",
                    "PhoneNumber2Ext" => "",
                    "FaxNumber" => "",
                    "CellPhone" => "9627956000200",
                    "EmailAddress" => "test@test.com",
                    "Type" => "",
                ],
            ],
            "ThirdParty" => [
                "Reference1" => "",
                "Reference2" => "",
                "AccountNumber" => "",
                "PartyAddress" => [
                    "Line1" => "",
                    "Line2" => "",
                    "Line3" => "",
                    "City" => "",
                    "StateOrProvinceCode" => "",
                    "PostCode" => "",
                    "CountryCode" => "",
                    "Longitude" => 0,
                    "Latitude" => 0,
                    "BuildingNumber" => null,
                    "BuildingName" => null,
                    "Floor" => null,
                    "Apartment" => null,
                    "POBox" => null,
                    "Description" => null,
                ],
                "Contact" => [
                    "Department" => "",
                    "PersonName" => "",
                    "Title" => "",
                    "CompanyName" => "",
                    "PhoneNumber1" => "",
                    "PhoneNumber1Ext" => "",
                    "PhoneNumber2" => "",
                    "PhoneNumber2Ext" => "",
                    "FaxNumber" => "",
                    "CellPhone" => "",
                    "EmailAddress" => "",
                    "Type" => "",
                ],
            ],
            "ShippingDateTime" => "/Date(".$shiping_date_time."000-0500)/",
            "DueDate" => "/Date(".$end_date_time."000-0500)/",
            "Comments" => "",
            "PickupLocation" => "",
            "OperationsInstructions" => "",
            "AccountingInstrcutions" => "",
            "Details" => [
                "Dimensions" => null,
                "ActualWeight" => ["Unit" => "KG", "Value" => 0.5],
                "ChargeableWeight" => null,
                "DescriptionOfGoods" => "Bags",
                "GoodsOriginCountry" => "SAU",
                "NumberOfPieces" => 1,
                "ProductGroup" => "EXP",
                "ProductType" => "PDX",
                "PaymentType" => "P",
                "PaymentOptions" => "",
                "CustomsValueAmount" => null,
                "CashOnDeliveryAmount" => null,
                "InsuranceAmount" => null,
                "CashAdditionalAmount" => null,
                "CashAdditionalAmountDescription" => "",
                "CollectAmount" => null,
                "Services" => "",
                "Items" => [],
            ],
            "Attachments" => [],
            "ForeignHAWB" => "",
            "TransportType " => 0,
            "PickupGUID" => "",
            "Number" => null,
            "ScheduledDelivery" => null,
        ],
    ],
    "Transaction" => [
        "Reference1" => "",
        "Reference2" => "",
        "Reference3" => "",
        "Reference4" => "",
        "Reference5" => "",
    ],
];

$myArrayVar = json_encode($arrayVar,1);

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreateShipments',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$myArrayVar,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json'
    ),
  ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo "<pre>";print_r($response);"</pre>";exit;
    echo $response;

}

public function createPickup($value='')
{
  $pickup_date = '2022-02-08';
  $ready_time = '2022-01-08';
  $last_pickup_time = '2022-02-09';
  $closing_time = '2022-02-09';

  $shipping_date_time = '2022-02-14';
  $due_date = '2022-02-14';

  $pickup_date = \Carbon\Carbon::parse($pickup_date)->timestamp; //  Monday, February 7, 2022 6:30:00 PM
  $ready_time = \Carbon\Carbon::parse($ready_time)->timestamp;
  $last_pickup_time = \Carbon\Carbon::parse($last_pickup_time)->timestamp;//Tuesday, February 8, 2022 6:30:00 PM
  $closing_time = \Carbon\Carbon::parse($closing_time)->timestamp;
  $shipping_date_time = \Carbon\Carbon::parse($shipping_date_time)->timestamp;
  $due_date = \Carbon\Carbon::parse($due_date)->timestamp;


  $arrayVar = [
    "ClientInfo" => [
        "UserName" => "reem@reem.com",
        "Password" => "123456789",
        "Version" => "1.0",
        "AccountNumber" => "4004636",
        "AccountPin" => "432432",
        "AccountEntity" => "RUH",
        "AccountCountryCode" => "SA",
        "Source" => 24,
    ],
    "LabelInfo" => ["ReportID" => 9201, "ReportType" => "URL"],
    "Pickup" => [
        "PickupAddress" => [
            "Line1" => "Horizons Rareness Trading EST",
            "Line2" => "office No.2",
            "Line3" => "floor No. 1",
            "City" => "Riyadh",
            "StateOrProvinceCode" => "Saudi Arabia",
            "PostCode" => "12173",
            "CountryCode" => "SA",
            "Longitude" => 0,
            "Latitude" => 0,
            "BuildingNumber" => 2,
            "BuildingName" => null,
            "Floor" => 1,
            "Apartment" => null,
            "POBox" => null,
            "Description" => null,
        ],
        "PickupContact" => [
            "Department" => "",
            "PersonName" => "test",
            "Title" => "",
            "CompanyName" => "test",
            "PhoneNumber1" => "1111111111111",
            "PhoneNumber1Ext" => "",
            "PhoneNumber2" => "",
            "PhoneNumber2Ext" => "",
            "FaxNumber" => "",
            "CellPhone" => "11111111111111",
            "EmailAddress" => "test@test.com",
            "Type" => "",
        ],
        "PickupLocation" => "test",
        "PickupDate" => "/Date(".$pickup_date."000-0800)/",
        "ReadyTime" => "/Date(".$ready_time."000-1000)/",
        "LastPickupTime" => "/Date(".$last_pickup_time."000-0500)/",
        "ClosingTime" => "/Date(".$closing_time."000-1000)/",
        "Comments" => "",
        "Reference1" => "001",
        "Reference2" => "",
        "Vehicle" => "",
        "Shipments" => [
            [
                "Reference1" => "123",
                "Reference2" => "",
                "Reference3" => "",
                "Shipper" => [
                    "Reference1" => "",
                    "Reference2" => "",
                    "AccountNumber" => "20016",
                    "PartyAddress" => [
                        "Line1" => "Test",
                        "Line2" => "",
                        "Line3" => "",
                        "City" => "Amman",
                        "StateOrProvinceCode" => "",
                        "PostCode" => "",
                        "CountryCode" => "JO",
                        "Longitude" => 0,
                        "Latitude" => 0,
                        "BuildingNumber" => null,
                        "BuildingName" => null,
                        "Floor" => null,
                        "Apartment" => null,
                        "POBox" => null,
                        "Description" => null,
                    ],
                    "Contact" => [
                        "Department" => "",
                        "PersonName" => "Test",
                        "Title" => "",
                        "CompanyName" => "Test",
                        "PhoneNumber1" => "5555",
                        "PhoneNumber1Ext" => "",
                        "PhoneNumber2" => "",
                        "PhoneNumber2Ext" => "",
                        "FaxNumber" => "",
                        "CellPhone" => "5555",
                        "EmailAddress" => "m@m.com",
                        "Type" => "",
                    ],
                ],
                "Consignee" => [
                    "Reference1" => "",
                    "Reference2" => "",
                    "AccountNumber" => "",
                    "PartyAddress" => [
                        "Line1" => "Test",
                        "Line2" => "",
                        "Line3" => "",
                        "City" => "Dubai",
                        "StateOrProvinceCode" => "",
                        "PostCode" => "",
                        "CountryCode" => "AE",
                        "Longitude" => 0,
                        "Latitude" => 0,
                        "BuildingNumber" => "",
                        "BuildingName" => "",
                        "Floor" => "",
                        "Apartment" => "",
                        "POBox" => null,
                        "Description" => "",
                    ],
                    "Contact" => [
                        "Department" => "",
                        "PersonName" => "Test",
                        "Title" => "",
                        "CompanyName" => "Test",
                        "PhoneNumber1" => "555",
                        "PhoneNumber1Ext" => "",
                        "PhoneNumber2" => "",
                        "PhoneNumber2Ext" => "",
                        "FaxNumber" => "",
                        "CellPhone" => "555",
                        "EmailAddress" => "f@f.com",
                        "Type" => "",
                    ],
                ],
                "ThirdParty" => [
                    "Reference1" => "",
                    "Reference2" => "",
                    "AccountNumber" => "",
                    "PartyAddress" => [
                        "Line1" => "",
                        "Line2" => "",
                        "Line3" => "",
                        "City" => "",
                        "StateOrProvinceCode" => "",
                        "PostCode" => "",
                        "CountryCode" => "",
                        "Longitude" => 0,
                        "Latitude" => 0,
                        "BuildingNumber" => null,
                        "BuildingName" => null,
                        "Floor" => null,
                        "Apartment" => null,
                        "POBox" => null,
                        "Description" => null,
                    ],
                    "Contact" => [
                        "Department" => "",
                        "PersonName" => "",
                        "Title" => "",
                        "CompanyName" => "",
                        "PhoneNumber1" => "",
                        "PhoneNumber1Ext" => "",
                        "PhoneNumber2" => "",
                        "PhoneNumber2Ext" => "",
                        "FaxNumber" => "",
                        "CellPhone" => "",
                        "EmailAddress" => "",
                        "Type" => "",
                    ],
                ],
                "ShippingDateTime" => "/Date(".$shipping_date_time."000-0500)/",
                "DueDate" => "/Date(".$due_date."000-0500)/",
                "Comments" => "Comments ...",
                "PickupLocation" => "Reception",
                "OperationsInstructions" => "Fragile",
                "AccountingInstrcutions" => "Get us a discount please",
                "Details" => [
                    "Dimensions" => null,
                    "ActualWeight" => ["Unit" => "KG", "Value" => 0.5],
                    "ChargeableWeight" => null,
                    "DescriptionOfGoods" => "Docs",
                    "GoodsOriginCountry" => "SAU",
                    "NumberOfPieces" => 1,
                    "ProductGroup" => "EXP",
                    "ProductType" => "PDX",
                    "PaymentType" => "P",
                    "PaymentOptions" => "",
                    "CustomsValueAmount" => null,
                    "CashOnDeliveryAmount" => null,
                    "InsuranceAmount" => null,
                    "CashAdditionalAmount" => null,
                    "CashAdditionalAmountDescription" => "",
                    "CollectAmount" => null,
                    "Services" => "",
                    "Items" => [],
                    "DeliveryInstructions" => null,
                ],
                "Attachments" => [],
                "ForeignHAWB" => "12212121212121",
                "TransportType " => 0,
                "PickupGUID" => null,
                "Number" => "",
                "ScheduledDelivery" => null,
            ],
        ],
        "PickupItems" => [
            [
                "ProductGroup" => "EXP",
                "ProductType" => "PDX",
                "NumberOfShipments" => 1,
                "PackageType" => "Box",
                "Payment" => "P",
                "ShipmentWeight" => ["Unit" => "KG", "Value" => 0.5],
                "ShipmentVolume" => null,
                "NumberOfPieces" => 1,
                "CashAmount" => null,
                "ExtraCharges" => null,
                "ShipmentDimensions" => [
                    "Length" => 0,
                    "Width" => 0,
                    "Height" => 0,
                    "Unit" => "",
                ],
                "Comments" => "Test",
            ],
        ],
        "Status" => "Ready",
        "ExistingShipments" => null,
        "Branch" => "",
        "RouteCode" => "",
    ],
    "Transaction" => [
        "Reference1" => "",
        "Reference2" => "",
        "Reference3" => "",
        "Reference4" => "",
        "Reference5" => "",
    ],
];

$myArrayVar = json_encode($arrayVar, true);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreatePickup',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$myArrayVar,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json'
),
));

$response = curl_exec($curl);

$result = json_decode($response,true);

if ($result['HasErrors']) {
  foreach ($result['Notifications'] as $key => $Notifications) {
   echo $Notifications['Message'];
}
}else{
    //$result['ProcessedPickup']['ID']
  echo "<pre>";print_r($result['ProcessedPickup']);"</pre>";exit;

}


curl_close($curl);
  // echo $response;

}
  

public function index(Request $request)
{

    if(!Session::has('locale')){
        Session::put('locale','ar');
        Session::save();
        \App::setLocale(\Session::get('locale'));
    }

    $productCategoryList = array();
    $productConcernList =  array();
    $productConcernAndCategoryList = array();
    $data = array();
    $productTypeArray = array();
    $trendingItemsProductId = array();
    $newLaunchItemProductId = array();
    $featuredProductsItemProductId = array();

    if(session('user_id'))
    {
    $userId = session('user_id');
    $data['usersInfo'] = $this->ProductModel->getUserInfoByUserId($userId);
    if(empty(session('address')))
    {
    	Session::put('address', $data['usersInfo']->address);
    	Session::save();

    }
    elseif(empty($data['usersInfo']->shipping_address)){

    	Session::put('address', $data['usersInfo']->address);
    	Session::save();

    }
    else{

        Session::put('address', $data['usersInfo']->address); 
    	Session::save(); 
    }
    }

    $data['Category']               = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['SubCategories']          = $this->ProductModel->SubcategoryList();
    $data['manuPage']               = $this->ProductModel->manuPage();
    $data['Banners']                = $this->HomeModel->BannerList();
    $data['NewProduct']             = $this->ProductModel->getNewProductList();
    $data['WomenBags']              = $this->ProductModel->getWomenBagsList();
    $data['WomenWallets']           = $this->ProductModel->getWomenWalletsList();
    $data['MensBags']               = $this->ProductModel->getMensBagsList();
    $data['Luggages']               = $this->ProductModel->getLuggagesList();
    $data['LaptopBags']             = $this->ProductModel->getLaptopBagsList();
    $data['OtherBags']              = $this->ProductModel->getOtherList();

    
    if(session('locale')=='en'){
        return view('en-SA/Front.index')->with($data);  
    }
    else{
        return view('ar-SA/Front.index')->with($data);  
    }
}


public function singleBlog(Request $request ,$blog_title)
{

   

$blogDetailsWithCommentCount = array();
$userComment = array();
$userCommenCount = 0;
$blogList = $this->ProductModel->getBlogList();

foreach( $blogList as $key=>$value )
{ 
    
    $commentCountByBlogId = $this->ProductModel->getcommentCountAccToBlogId($value->blog_id);
    $blogDetailsWithCommentCount[] = array('blog_id'=>$value->blog_id,
    'blog_title'=>$value->blog_title,
    'blog_title_display_name'=>$value->blog_title_display_name,
    'blog_description'=>$value->blog_description,
    'updated_at'=>$value->updated_at,

    'image'=>$value->images,
    'count'=>$commentCountByBlogId
);

}



$blogDetailsByBloagName = $this->ProductModel->getBlogDetailsByBlogName($blog_title);


if(count($blogDetailsByBloagName)>0)
{
foreach($blogDetailsByBloagName as $blogDet)
{
    $blogId = $blogDet->blog_id;
    $userComment = $this->ProductModel->getAllUsersComment($blogId);
    $userCommenCount = count($userComment);
  }
}

$productList = $this->ProductModel->getProductList();
$notificationList = $this->ProductModel->getProductNotification();
$data['Category'] = $this->ProductModel->CategoryList();
$data['manuPage'] = $this->ProductModel->manuPage();
$data['notification'] = $this->ProductModel->getProductNotification();


return view('New.single-blog',compact('blogList','notificationList','blogDetailsByBloagName','productList','userComment','userCommenCount','blogDetailsWithCommentCount'))->with($data);

}

public function about(Request $request)
{

    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();

    if(session('locale')=='en'){
        return view('en-SA/Front.about')->with($data); 
    }
    else{
        return view('ar-SA/Front.about')->with($data); 
    }


}

public function contact(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();


    if(session('locale')=='en'){
        return view('en-SA/Front.contact')->with($data); 
    }
    else{
        return view('ar-SA/Front.contact')->with($data); 
    }

}


public function OurStores(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();

    if(session('locale')=='en'){
        return view('en-SA/Front.our-stores')->with($data); 
    }
    else{
        return view('ar-SA/Front.our-stores')->with($data); 
    }

}

public function ShippingAndReturns(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();

    if(session('locale')=='en'){
        return view('en-SA/Front.shipping-and-returns')->with($data); 
    }
    else{
        return view('ar-SA/Front.shipping-and-returns')->with($data); 
    }

}

public function TermsAndConditions(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();

    if(session('locale')=='en'){
        return view('en-SA/Front.terms-and-conditions')->with($data); 
    }
    else{
        return view('ar-SA/Front.terms-and-conditions')->with($data); 
    }

}

public function AccessibilityStatement(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();

    if(session('locale')=='en'){
        return view('en-SA/Front.accessibility-statement')->with($data); 
    }
    else{
        return view('ar-SA/Front.accessibility-statement')->with($data); 
    }

}

public function PrivacyPolicy(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();

    if(session('locale')=='en'){
        return view('en-SA/Front.privacy-policy')->with($data); 
    }
    else{
        return view('ar-SA/Front.privacy-policy')->with($data); 
    }

}

public function RetainAndRefundPolicy(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();

    if(session('locale')=='en'){
        return view('en-SA/Front.retain-and-refund-policy')->with($data); 
    }
    else{
        return view('ar-SA/Front.retain-and-refund-policy')->with($data); 
    }

}

public function ShippingPolicy(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();

    if(session('locale')=='en'){
        return view('en-SA/Front.shipping-policy')->with($data); 
    }
    else{
        return view('ar-SA/Front.shipping-policy')->with($data); 
    }

}

public function philosophy(Request $request)
{

$data['Category'] = $this->ProductModel->CategoryList();
$data['manuPage'] = $this->ProductModel->manuPage();
$data['notification'] = $this->ProductModel->getProductNotification();
return view('New.philosophy')->with($data);

}


public function blog(Request $request)
{

$Data['Category'] = $this->ProductModel->CategoryList();
$Data['manuPage'] = $this->ProductModel->manuPage();
$Data['notification'] = $this->ProductModel->getProductNotification();
$Data['Blogs'] = $this->ProductModel->BlogsList();

    return view('New.blog')->with($Data);

}



public function cart(Request $request)
{

$data['Category'] = $this->ProductModel->CategoryList();
$data['CategoryA'] = $this->ProductModel->CategoryAList();
$data['manuPage'] = $this->ProductModel->manuPage();
$data['notification'] = $this->ProductModel->getProductNotification();
return view('New.cart')->with($data);

}

public function checkout(Request $request)
{
    if(session('user_id')){

        $userId = session('user_id');

        $data['usersInfo'] = $this->ProductModel->getUserInfoByUserId($userId);
        $data['Category'] = $this->ProductModel->CategoryList();
        $data['CategoryA'] = $this->ProductModel->CategoryList();
        $data['manuPage'] = $this->ProductModel->manuPage();
        $data['notification'] = $this->ProductModel->getProductNotification();
        $data['gst'] = $this->ProductModel->gst();

        $cartCollection = \Cart::getContent();
        $data['cartCollection']               = $cartCollection;

        if(session('locale')=='en'){
            return view('en-SA/Front.checkout')->with($data);
        }
        else{
            return view('ar-SA/Front.checkout')->with($data);
        } 

        }
        else
        {
        return redirect()->route('Home');
    }


}



public function forgetPass(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['manuPage'] = $this->ProductModel->manuPage();

    $data['notification'] = $this->ProductModel->getProductNotification();
    return view('New.forget-pass')->with($data);

}
public function login(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
$data['manuPage'] = $this->ProductModel->manuPage();
$data['notification'] = $this->ProductModel->getProductNotification();
    return view('New.login')->with($data);

}
public function register(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
$data['manuPage'] = $this->ProductModel->manuPage();
$data['notification'] = $this->ProductModel->getProductNotification();
print_r($data['manuPage']);
exit();
    return view('New.register')->with($data);

}

public function MenusPage(Request $request,$page)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['MenuPageDetails'] = $this->ProductModel->MenuPageDetails($page);
$data['manuPage'] = $this->ProductModel->manuPage();
$data['notification'] = $this->ProductModel->getProductNotification();

    return view('New.menu-page')->with($data);

}

public function shopSingle(Request $request ,$name_slug)
{
  
    $data['RelatedProductList'] = array();
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA'] = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();
    $data['productDetails']=$this->ProductModel->getProductDetailsByProductId($name_slug);

    $data['attributes']=$this->ProductModel->getProductAttributes($name_slug);
    $data['RelatedProductDetailsIds']=$this->ProductModel->getProductCategoryDetailsByProductId($name_slug);
   
    if(!empty($data['RelatedProductDetailsIds']))
    {
        $data['CategoryGst']=$this->ProductModel->geGstByCategoryId($data['RelatedProductDetailsIds']->category_id);
    }else{
        print_r("<h2>Products Are Not Found</h2> ");
        exit();
    }
   
    if (!empty($data['RelatedProductDetailsIds'])) 
    {
  
//    $data['RelatedProductDetailsAccToCategoryId']=$this->ProductModel->getRelatedProductDetailsAccToCategoryId($data['RelatedProductDetailsIds']->category_id);
   $data['RelatedProductDetailsAccToSubCategoryId']=$this->ProductModel->getRelatedProductDetailsAccToSubCategoryId($data['RelatedProductDetailsIds']->sub_category_id);



   //$data['RelatedProductDetailsAccToConcernId']=$this->ProductModel->getRelatedProductDetailsAccToConcernId($data['RelatedProductDetailsIds']->concern_id);

  

//    foreach($data['RelatedProductDetailsAccToCategoryId']  as  $RPCID )
//    {
//     $CatProductId[] =  $RPCID->id;

//    }
   foreach($data['RelatedProductDetailsAccToSubCategoryId'] as $RPSCID )
   {

    $SubCatProductId[] =  $RPSCID->id;

   }
   /*foreach($data['RelatedProductDetailsAccToConcernId'] as  $RPConID )
   {
$ConProductId[] =  $RPConID->id;
    }*/
    
   $RelatedProductIds = array_unique(array_merge($SubCatProductId));

$array = array_diff($RelatedProductIds, [$data['productDetails']->id]);



   $data['RelatedProductList']=$this->ProductModel->getRelatedProductListIds($array);
}
    


$data['review']=$this->ProductModel->getAllReview();
     
      $totalStars = array();
      foreach( $data['review'] as $key)
      { 
        $totalStars[]= $key->rating;

      }



      if(count($data['review']) == 0){
          
      $data['count'] = '';
      
      }
      else{
          
        $starCount = array_sum($totalStars)/count($data['review']);
        $data['count'] = round($starCount);
          
          
      }
    
    if(session('locale')=='en'){
        return view('en-SA/Front.shop-single')->with($data);
    }
    else{
        return view('ar-SA/Front.shop-single')->with($data);
    }      
}


public function ProductListingOfSubcategory(Request $request, $sub_category_slug)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['NewProduct']             = $this->ProductModel->getNewProductList();
    $data['SubcategoryProductList'] = $this->ProductModel->getProductListAccToSubcategoryIds($sub_category_slug);
    $data['categoryProductList']    = $this->ProductModel->getProductListCategoryWise($sub_category_slug);
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification(); 
    
    if(session('locale')=='en'){
        return view('en-SA/Front.product-listing-subcategory')->with($data);
    }
    else{
        return view('ar-SA/Front.product-listing-subcategory')->with($data);
    }

}

public function ProductListingBySlug(Request $request)
{
    $data = $request->all();
    //dd($data);
    $Search['short_by']         = $data['short_by'];
    $Search['slug']             = $data['slug'];
    $Search['fromVal']          = $data['fromVal'];
    $Search['toVal']            = $data['toVal'];
    
    // $page                       = $data['page'];
    // $numofrecords               = $data['no_of_page'];
    
    // $cur_page                   = $page;
    // $Limitpage                  = $page-1;
    // $start                      = $Limitpage * $numofrecords;
    
    $Result                     = $this->ProductModel->getProductListBySlug($Search);
    $Result_arr                 = $Result['Res'];
    $Count                      = $Result['Count'];
    
    foreach($Result_arr as $row){ 
        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
        $subcategory = DB::table('sub-category')->where('id','=',$row->sub_category_id)->where('status','=','1')->where('language_id','=',$languageId->id)->first();
        $Status = '<a href="javascript:void(0)" onclick="OpenModal('.$row->id.',1)"><span class="badge badge-danger m-1">In-active</span></a>';
        if($row->status==1){
            $Status = '<a href="javascript:void(0)" onclick="OpenModal('.$row->id.',0)"><span class="badge badge-success m-1">Active</span></a>';
        }
    ?>

    <div class="col-lg-3 col-md-3 col-sm-3 col-6 pb-1">
        <div class="product-item bg-light mb-4">
            <div class="product-img position-relative overflow-hidden">
                <div id="prdSlider_8" class="carousel slide" data-ride="carousel" data-interval="15000">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img class="d-block w-100" src="<?=asset('images/products/'.$row->image)?>" alt="">
                    </div>
                  </div>
                </div>

                <div class="product-action">
                    <form action="<?=route('cart.store')?>" method="POST">
                        <?=csrf_field()?>
                        <input type="hidden" value="<?=$row->id?>" id="id" name="id">
                        <input type="hidden" value="main_page" id="id" name="page">
                        <input type="hidden" value="<?=$row->name?>" id="name" name="name">
                        <input type="hidden" value="<?=$row->name_slug?>" id="slug" name="slug">
                        <input type="hidden" name="quantity[1]" id="get-quantity-count"  value="1">
                        <input type="hidden" value="<?=$row->quantity?>" id="product_quantity" name="product_quantity">
                        <input type="hidden" value="<?=asset('images/products/'.$row->image)?>"  id="img" name="img">
                        <?php
                        $productPrice = 0;
                        if(isset($row->discount_price) && !empty($row->discount_price))
                            {
                                $productPrice = $row->discount_price;
                                $gstAmount = (0/100)*$productPrice;
                                $ProductPriceWithGst = $productPrice+$gstAmount;
                            }
                        ?>
                        <input type="hidden" value="<?=isset($ProductPriceWithGst) ? $ProductPriceWithGst : '' ?>" id="price" name="price">
                        <button class="btn btn-outline-dark btn-square" ><i class="fa fa-shopping-cart"></i></button>
                    </form>
                    <a href="<?=route('DemoSingleProduct',['id'=>$row->id]) ?>" class="btn btn-outline-dark btn-square" href="Javascript:void(0);"><i class="far fa-eye"></i></a>
                    <!-- <a class="btn btn-outline-dark btn-square" href="Javascript:void(0);"><i class="far fa-heart"></i></a> -->
                </div>
            </div>

            <?php 
            if(session('locale')=='en'){
                $simbel = "SRA";
            }else{
                $simbel = "ريال سعودي";
            } 
            ?>

            <div class="text-center py-4 pl-2 pr-2">
                <h2 class="h5"><a class="text-dark text-decoration-none text-truncate" href="<?=route('DemoSingleProduct',['id'=>$row->id]) ?>"><?=isset($subcategory->name) ? $subcategory->name : ''?> <?php if(session('locale')=='en') ; else ;  ?></a></h2>
                <div class="d-flex align-items-center justify-content-center mt-2">
                    <h5><?=isset($row->discount_price) ? $row->discount_price : ''?> <?php echo $simbel; ?></h5><h6 class="text-muted ml-2"><del><?=isset($row->price) ? $row->price : ''?> <?php echo $simbel; ?></del></h6>
                </div>

                <!-- <div class="d-flex align-items-center justify-content-center mb-1">
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                </div> -->
            </div>
        </div>
    </div>


   <?php
   }
        //echo '<tr><td colspan="20">'.Common::Pagination($numofrecords, $Count, $page).'</td></tr>';
    //return view('Front.product-listing-subcategory')->with($data);

}

public function ProductListingOfConcern(Request $request,$concern_slug)
{
    
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['ConcernProductList'] = $this->ProductModel->getProductListAccToConcernIds($concern_slug);
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();
    return view('New.product-listing-concern')->with($data);

}

public function categoryProducts(Request $request,$category_slug)
{
   
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();  
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['CategoryProductList'] = $this->ProductModel->getProductListAccToCategoryIds($category_slug);
    $data['notification'] = $this->ProductModel->getProductNotification();
    return view('New.product-listing-category')->with($data);

}





public function faqs(Request $request)
{
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
$data['manuPage'] = $this->ProductModel->manuPage();
$data['notification'] = $this->ProductModel->getProductNotification();
    return view('New.faqs')->with($data);

}


public function myOrders(Request $request)
{
    $userId= session('user_id');
       
      
      
    if(!empty(session('user_id')))
    {
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['UserDetails'] = $this->HomeModel->UserDetails($userId);
    $data['OrdersDetails'] = $this->HomeModel->OrdersDetails($userId);
    $data['notification'] = $this->ProductModel->getProductNotification();
    $data['gst'] = $this->ProductModel->gst();

    return view('en-SA/User.order')->with($data);
    }
    else
    {
    return redirect()->route('Login');
    }
}


public function myAccount(Request $request)
{
    $userId= session('user_id');           
    if(!empty(session('user_id')))
    {
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['UserDetails'] = $this->HomeModel->UserDetails($userId);
    $data['OrdersDetails'] = $this->HomeModel->OrdersDetails($userId);
    $data['notification'] = $this->ProductModel->getProductNotification();
    $data['gst'] = $this->ProductModel->gst();

    return view('en-SA/User.myaccount')->with($data);
    }
    else
    {
    return redirect()->route('Login');
    }
}


public function orders(Request $request)
{
    $userId= session('user_id');           
    if(!empty(session('user_id')))
    {
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['UserDetails'] = $this->HomeModel->UserDetails($userId);
    $data['OrdersDetails'] = $this->HomeModel->OrdersDetails($userId);
    $data['notification'] = $this->ProductModel->getProductNotification();
    $data['gst'] = $this->ProductModel->gst();

    if(session('locale')=='en'){
        return view('en-SA/User.order')->with($data); 
    }
    else{
        return view('ar-SA/User.order')->with($data); 
    }

    }
    else
    {
    return redirect()->route('Login');
    }
}

public function saveAddress(Request $request)
{
    $userId= session('user_id');           
    if(!empty(session('user_id')))
    {

        $Count = DB::table('user_authentication_details')->where('id',$userId)->where('status',1)->update(['shipping_address' => json_encode($request->except('_token'))]);
        return "updated";
    }
}

public function address(Request $request)
{
    $userId= session('user_id');           
    if(!empty(session('user_id')))
    {
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['UserDetails'] = $this->HomeModel->UserDetails($userId);
    $data['OrdersDetails'] = $this->HomeModel->OrdersDetails($userId);
    $data['notification'] = $this->ProductModel->getProductNotification();
    $data['gst'] = $this->ProductModel->gst();

    if(session('locale')=='en'){
        return view('en-SA/User.address')->with($data); 
    }
    else{
        return view('ar-SA/User.address')->with($data); 
    }

    }
    else
    {
    return redirect()->route('Login');
    }
}



public function userProfile(Request $request)
{
    $userId= session('user_id');
       
      
      
    if(!empty(session('user_id')))
    {
    $data['Category'] = $this->ProductModel->CategoryList();
    $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['UserDetails'] = $this->HomeModel->UserDetails($userId);
    $data['OrdersDetails'] = $this->HomeModel->OrdersDetails($userId);
    $data['notification'] = $this->ProductModel->getProductNotification();
    $data['gst'] = $this->ProductModel->gst();

    if(session('locale')=='en'){
        return view('en-SA/User.myaccount')->with($data); 
    }
    else{
        return view('ar-SA/User.myaccount')->with($data); 
    }
    }
    else
    {
    return redirect()->route('Login');
    }
}

public function MenuCertificates(Request $request)
{
   $data['Category'] = $this->ProductModel->CategoryList();
   $data['CategoryA']              = $this->ProductModel->CategoryAList();
    $data['manuPage'] = $this->ProductModel->manuPage();
    $data['notification'] = $this->ProductModel->getProductNotification();

    return view('New.certificates')->with($data);
 
    
}

public function contactSave(Request $request)
{
    $contact = new Contact;
    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->country_code = $request->country_code;
    $contact->mobile = $request->mobile;
    $contact->show_city_id = $request->show_city_id;
    $contact->subject = $request->subject;
    $contact->message = $request->message;
    $contact->save();

    return redirect('/contact');
}
   
}
