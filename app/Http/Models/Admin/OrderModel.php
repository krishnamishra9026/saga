<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class OrderModel extends Model 
{
	public function Listing(){
	    $Data = DB::table('orders');
	    $Data->select('*');
	    $Data->orderBy('id','DESC');
	    $Res 	= $Data->get();
    return $Res;
  }


  public function RefundListing(){
	$Data = DB::table('Refund');
	$Data->select('*');
	$Data->orderBy('id','DESC');
	$Res 	= $Data->get();
return $Res;
}

public function DeliveredOrderListing(){
	$Data = DB::table('delivered_orders');
	$Data->select('*');
	$Data->orderBy('id','DESC');
	$Res 	= $Data->get();
return $Res;
}

public function OrderTrackingListing(){
	$Data = DB::table('tracking');
	$Data->select('*');
	$Data->orderBy('id','DESC');
	$Res 	= $Data->get();
return $Res;
}

public function gst()
{
$Result = DB::table('gst')->select('*')->where('status','=','1')->orderBy('id', 'DESC')->first();
return $Result;
}

public function submitShiprocketToken($requestData)
{
    
    $tokenExists = DB::table('ship_order_token')->where(['id'=>'1'])->get();
if($tokenExists)
{
    $tokenExists = DB::table('ship_order_token')->where(['id'=>'1'])->update($requestData);
    return $tokenExists;
}
else
{
    
        $result = DB::table('ship_order_token')->insert($requestData);
    return $result;
}

    
}

public function updateShiprocketToken($requestData,$Data)
{
    $id= $Data[0]->id;
    unset($requestData['order_id']);
    $result = DB::table('ship_order_token')->where('id','=',$id)->update($requestData);
    return $result;
    
}

public function checkShipingToken()
{
        $result = DB::table('ship_order_token')->select('*')->get();
        return $result;


}
}