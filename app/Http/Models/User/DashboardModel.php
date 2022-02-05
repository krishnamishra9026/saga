<?php
namespace App\Http\Models\User;
use Illuminate\Database\Eloquent\Model;
use DB;
class DashboardModel extends Model 
{

	public function TotalBid($id)
	{
		$result = DB::table('bid_now')
		        ->where('user_id', $id)
		        ->where('status', 'Success')
		        ->count();
    return $result;
	}

	public function TodayTotalBid($id)
	{
		$CurrentDate = date('Y-m-d');
		$result = DB::table('bid_now')
		        ->where(DB::raw("(STR_TO_DATE(add_date,'%Y-%m-%d'))"),$CurrentDate)
				->where('user_id', $id)
				->where('status', 'Success')
				->count();
    return $result;
	}

	public function TotalBidPaymentTransfer($id)
	{
		$Total = DB::table('payment')->where('STATUS_PMT','Successful')
										 ->where('USERID',$id)->sum('TXNAMOUNT_PMT');
    return $Total;
	}
	
	public function TotalBuyPaymentTransfer($id)
	{
		$Total = DB::table('orders')->where('STATUS_PMT','Successful')
										 ->where('user_id',$id)->sum('TXNAMOUNT_PMT');
    return $Total;
	}
	
	public function TodayBidPaymentTransfer($id)
	{
		$CurrentDate = date('Y-m-d');
		$Total = DB::table('payment')
							->where(DB::raw("(STR_TO_DATE(TXNDATE_PMT,'%Y-%m-%d'))"),$CurrentDate)
							->where('USERID',$id)
							->where('STATUS_PMT','Successful')->sum('TXNAMOUNT_PMT');
    return $Total;
	}
	
	public function TodayBuyPaymentTransfer($id)
	{
		$CurrentDate = date('Y-m-d');
		$Total = DB::table('orders')
							->where(DB::raw("(STR_TO_DATE(TXNDATE_PMT,'%Y-%m-%d'))"),$CurrentDate)
							->where('user_id',$id)
							->where('STATUS_PMT','Successful')->sum('TXNAMOUNT_PMT');
    return $Total;
	}
	
	public function TotalOrder($id)
	{
		$Total = DB::table('orders')
		                    ->where('user_id',$id)
		                    ->where('STATUS_PMT','Successful')
							->count();
    return $Total;
	}
	
	public function TodayOrder($id)
	{
		$CurrentDate = date('Y-m-d');
		$Total = DB::table('orders')
							->where(DB::raw("(STR_TO_DATE(TXNDATE_PMT,'%Y-%m-%d'))"),$CurrentDate)
							->where('user_id',$id)
							->where('STATUS_PMT','Successful')
							->count();
    return $Total;
	}
	
}

