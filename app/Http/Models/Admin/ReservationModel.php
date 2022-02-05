<?php
namespace App\Http\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
class ReservationModel extends Model 
{
	public function Listing(){
	    $Data = DB::table('reservation');
	    $Data->select('*');
	    $Data->orderBy('id','DESC');
	    $Res 	= $Data->get();
    return $Res;
  }
}