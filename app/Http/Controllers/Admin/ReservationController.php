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
use Illuminate\Http\Request;
use App\Http\Models\Admin\ReservationModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class ReservationController extends Controller 
{
	public function __construct(Request $request)
	{
		$this->ReservationModel = new ReservationModel();	
	}

	public function List(){
		$Data['Title'] 				= 'Reservation';
		$Data['Menu'] 				= 'Reservation';
		$Data['SubMenu'] 			= '';
        $Data['SelectMenu']         = '';
        $Data['ReservationArr']     = $this->ReservationModel->Listing();
		return View('Admin/Reservation/List')->with($Data);
	}
	
}