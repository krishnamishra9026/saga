<?php
namespace App\Http\Models\Front;
use Illuminate\Database\Eloquent\Model;
use DB;

class HomeModel extends Model 
{
	
	public function UserDetails($userId){
		$Count = DB::table('user_authentication_details')->where('id',$userId)->where('status',1)->first();
		return $Count;
	}
	
	public function OrdersDetails($userId){
	    
		$Count = DB::table('orders')->where('user_id',$userId)->get();
		return $Count;
		
	}
	
	
	public function CheckProducts($ProID){
		$Count = DB::table('menus')->where('id',$ProID)->where('status',1)->count();
		return $Count;
	}
	
	public function GetUserDetails($UserID){
		$result = DB::table('users')->where('id',$UserID)->where('status','1')->first();
		return $result;
	}

	public function SaveOrderItem($Details){
		$result = DB::table('order_items')->insertGetId($Details);
    	return $result;
	}

	public function GetPMTOrderItems($OrderID){
		$result = DB::table('order_items')->where('order_id',$OrderID)->where('status',1)->get();
		return $result;
	}

	public function GetPMTOrderAddress($AddressID){
		$result = DB::table('address')->where('id',$AddressID)->first();
		return $result;
	}

	public function SaveOrders($Details){
		$result = DB::table('orders')->insertGetId($Details);
    return $result;
	}

	public function SaveBillingAddress($Details){
		$result = DB::table('address')->insertGetId($Details);
		$lastInsertId  = DB::getPDO()->lastInsertId();
    return $lastInsertId;
	}

	public function SavePaymentNow($Details){
		$result = DB::table('payment_now')->insertGetId($Details);
    return $result;
	}

	public function SavePayment($Details){
		$result = DB::table('payment')->insertGetId($Details);
    return $result;
	}

	/*public function CheckOrderID($OrderID){
		$Count = DB::table('payment_now')->where('order_id',$OrderID)->count();
		return $Count;
	}*/

	public function CheckOrderID($OrderID){
		$Count = DB::table('payment')->where('ORDERID_PMT',$OrderID)->count();
		return $Count;
	}

	public function CheckPMTOrderID($OrderID){
		$Count = DB::table('orders')->where('ORDERID_PMT',$OrderID)->count();
		return $Count;
	}

	/*public function GetOrderIDDetails($OrderID){
		$result = DB::table('payment_now')->where('order_id',$OrderID)->first();
		return $result;
	}*/

	public function GetOrderIDDetails($OrderID){
		$result = DB::table('payment')->where('ORDERID_PMT',$OrderID)->first();
		return $result;
	}

	public function GetPMTOrderIDDetails($OrderID){
		$result = DB::table('orders')->where('ORDERID_PMT',$OrderID)->first();
		return $result;
	}

	public function ProductsDetails($ProID){
		$result = DB::table('menus')->where('id',$ProID)->first();
		return $result;
	}

	public function GetProductsBidDetails($ProID){
		$result = DB::table('menus')->where('id',$ProID)->first();
		return $result;
	}
	
	/*------Slider---------*/
	public function BannerList()
	{
		$Result = DB::table('banner')->where('status','1')->get();
		return $Result;
	}

	public function MenuList()
	{
		$Result = DB::table('menus')->where('status','1')->get();
		return $Result;
	}
	
	public function CategoriesList()
	{
		$Result = DB::table('category')->where('status','1')->get();
		return $Result;
	}

	public function CustomersList()
	{
		$Result = DB::table('ourcustomers')->where('status','1')->get();
		return $Result;
	}

	public function DiscountList()
	{
		$Result = DB::table('discount')->where('status','1')->get();
		return $Result;
	}

	public function OffersList()
	{
		$Result = DB::table('offers')->where('status','1')->get();
		return $Result;
	}

	public function Settings()
	{
		$Result = DB::table('user_authentication_details')->where('status','1')->first();
		return $Result;
	}

}