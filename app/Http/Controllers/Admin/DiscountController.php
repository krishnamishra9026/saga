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
use App\Http\Models\Admin\DiscountModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class DiscountController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->DiscountModel = new DiscountModel();
	}

	public function Discount(){
		
		$Data['Title'] 		= 'Discount List';
		$Data['Menu'] 		= 'Discount';
		$Data['SubMenu'] 	= 'Discount';
		$Data['SelectMenu'] = 'Discount';
		$Data['Discount'] = $this->DiscountModel->DiscountList();
		return View('Admin/Discount/List')->with($Data);

	}

	public function AddDiscount(){
		$Data['Title'] 		= 'Add Discount';
		$Data['Menu'] 		= 'Discount';
		$Data['SubMenu'] 	= 'Discount';
		$Data['SelectMenu'] = 'Discount';
		return View('Admin/Discount/Add')->with($Data);
	}

	public function InsertDiscount(Request $request)
	{
		$Data = $request->all();

	

		$Save['discount_title'] 		= isset($Data["discount_title"])? trim($Data["discount_title"]) : null;
		$Save['discount_description'] 	= isset($Data["discount_description"])? trim($Data["discount_description"]) : null;
		$Save['spent_amount'] 			= isset($Data["spent_amount"])? trim($Data["spent_amount"]) : null;
		$Save['discount_amount'] 		= isset($Data["discount_amount"])? trim($Data["discount_amount"]) : null;
		$Save['discount_for'] 			= isset($Data["discount_for"])? trim($Data["discount_for"]) : null;
		$Save['discount_day'] 			= isset($Data["discount_day"])? json_encode($Data['discount_day']) : null;
		$Save['first_order_discount'] 	= isset($Data["first_order_discount"])? trim($Data["first_order_discount"]) : null;
		$Save['default_offer'] 			= isset($Data["default_offer"])? trim($Data["default_offer"]) : null;
		$Save['coupen_code'] 			= isset($Data["coupen_code"])? trim($Data["coupen_code"]) : null;

		$Save['status'] 				= $Data['status'];
		$Save['created_at'] 			= date('Y-m-d H:i:s');
	
		if(!empty($Data['image'])){
			$image = $Data['image'];
			$Path = 'upload/discount';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}

	

		$Discount_id = $this->DiscountModel->AddDiscount($Save);
		
		if($Discount_id){
			$msg = Common::AlertErrorMsg('Success','Discount Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Discount');
	}

	public function EditDiscount($id){
		$Id = base64_decode($id);
		$CheckID = $this->DiscountModel->CheckDiscount(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->DiscountModel->GetDiscount($Id);
		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Discount';
		$Data['Menu'] 		= 'Discount';
		$Data['SubMenu'] 	= 'Discount';
		$Data['SelectMenu'] = 'Discount';
		return View('Admin/Discount/Edit')->with($Data);
	}

	public function SaveDiscount(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];
		$Save['discount_title'] 		= isset($Data["discount_title"])? trim($Data["discount_title"]) : null;
		$Save['discount_description'] 	= isset($Data["discount_description"])? trim($Data["discount_description"]) : null;
		$Save['spent_amount'] 			= isset($Data["spent_amount"])? trim($Data["spent_amount"]) : null;
		$Save['discount_amount'] 		= isset($Data["discount_amount"])? trim($Data["discount_amount"]) : null;
		$Save['discount_for'] 			= isset($Data["discount_for"])? trim($Data["discount_for"]) : null;
		$Save['discount_day'] 			= isset($Data["discount_day"])? json_encode($Data['discount_day']) : null;
		$Save['first_order_discount'] 	= isset($Data["first_order_discount"])? trim($Data["first_order_discount"]) : null;
		$Save['default_offer'] 			= isset($Data["default_offer"])? trim($Data["default_offer"]) : null;
		$Save['coupen_code'] 			= isset($Data["coupen_code"])? trim($Data["coupen_code"]) : null;

		$Save['status'] 				= $Data['status'];
		$Save['updated_at'] 			= date('Y-m-d H:i:s');

		if(!empty($Data['image'])){
			$image = $Data['image'];
			$Path = 'upload/discount/';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}

		
		$Result = $this->DiscountModel->UpdateDiscount($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Discount Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Discount');
	}

	public function DeleteDiscount($ID){
		$id = base64_decode($ID);
		DB::table('discount')->where('id',$id)->delete();	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

}