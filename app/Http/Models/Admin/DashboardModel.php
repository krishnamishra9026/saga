<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class DashboardModel extends Model 
{
	public function TotalUser()
	{
		$result = DB::table('users')
		            ->count();
        return $result;
	}

	public function TodayTotalUser()
	{
		$CurrentDate = date('Y-m-d');
		$result = DB::table('users')
		            ->where(DB::raw("(STR_TO_DATE(created_at,'%Y-%m-%d'))"),$CurrentDate)
		            ->count();
    return $result;
	}
}

