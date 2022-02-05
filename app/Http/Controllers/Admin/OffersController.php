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
use App\Http\Models\Admin\OffersModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\CategoryModel;
use App\Helpers\Common;

class OffersController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->OffersModel = new OffersModel();
		$this->CategoryModel = new CategoryModel();
	}

	public function Offers(){
		
		$Data['Title'] 		= 'Offers List';
		$Data['Menu'] 		= 'Offers';
		$Data['SubMenu'] 	= 'Offers';
		$Data['SelectMenu'] = 'Offers';
		$Data['Offers'] = $this->OffersModel->OffersList();
		return View('Admin/Offers/List')->with($Data);

	}

	public function AddOffers(){
		$Data['Title'] 		= 'Offers';
		$Data['Menu'] 		= 'Offers';
		$Data['SubMenu'] 	= 'Offers';
		$Data['SelectMenu'] = 'Offers';
		$Data['Language'] = $this->CategoryModel->Language();
		return View('Admin/Offers/Add')->with($Data);
	}

	public function InsertOffers(Request $request){
		$Data = $request->all();
		$Save['offer_title'] 		= isset($Data["offer_title"])? trim($Data["offer_title"]) : null;
		$Save['offer_description'] 	= isset($Data["offer_description"])? trim($Data["offer_description"]) : null;
		$Save['spent_amount'] 		= isset($Data["spent_amount"])? trim($Data["spent_amount"]) : null;
		$Save['offer_for'] 			= isset($Data["offer_for"])? trim($Data["offer_for"]) : null;
		$Save['offer_day'] 			= isset($Data["offer_day"])? json_encode($Data['offer_day']) : null;
		$Save['first_order_offer'] 	= isset($Data["first_order_offer"])? trim($Data["first_order_offer"]) : null;
		$Save['default_offer'] 		= isset($Data["default_offer"])? trim($Data["default_offer"]) : null;
		$Save['status'] 			= $Data['status'];
		$Save['created_at'] 		= date('Y-m-d H:i:s');

		if(!empty($Data['image'])){
			$image = $Data['image'];
			$Path = 'upload/offers';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}
		
		$Offers_id = $this->OffersModel->AddOffers($Save);
		if($Offers_id){
			$msg = Common::AlertErrorMsg('Success','Offers Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Offers');
	}

	public function EditOffers($id){
		$Id = base64_decode($id);
		$CheckID = $this->OffersModel->CheckOffers(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->OffersModel->GetOffers($Id);
		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Offers';
		$Data['Menu'] 		= 'Offers';
		$Data['SubMenu'] 	= 'Offers';
		$Data['SelectMenu'] = 'Offers';
		return View('Admin/Offers/Edit')->with($Data);
	}

	public function SaveOffers(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];
		$Save['offer_title'] 		= isset($Data["offer_title"])? trim($Data["offer_title"]) : null;
		$Save['offer_description'] 	= isset($Data["offer_description"])? trim($Data["offer_description"]) : null;
		$Save['spent_amount'] 		= isset($Data["spent_amount"])? trim($Data["spent_amount"]) : null;
		$Save['offer_for'] 			= isset($Data["offer_for"])? trim($Data["offer_for"]) : null;
		$Save['offer_day'] 			= isset($Data["offer_day"])? json_encode($Data['offer_day']) : null;
		$Save['first_order_offer'] 	= isset($Data["first_order_offer"])? trim($Data["first_order_offer"]) : null;
		$Save['default_offer'] 		= isset($Data["default_offer"])? trim($Data["default_offer"]) : null;
		$Save['status'] 			= $Data['status'];
		$Save['updated_at'] 		= date('Y-m-d H:i:s');

		if(!empty($Data['image'])){
			$image = $Data['image'];
			$Path = 'upload/offers/';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}

		$Result = $this->OffersModel->UpdateOffers($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Offers Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Offers');
	}

	public function DeleteOffers($ID){
		$id = base64_decode($ID);
		DB::table('offers')->where('id',$id)->delete();	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

	public function gst(){
		
		$Data['Title'] 		= 'GST List';
		$Data['Menu'] 		= 'GST';
		$Data['SubMenu'] 	= 'GST';
		$Data['SelectMenu'] = 'GST';
		$Data['GST'] = $this->OffersModel->GSTList();
	
		return View('Admin/GST/List')->with($Data);

	}

	public function addGst(){
		$Data['Title'] 		= 'GST';
		$Data['Menu'] 		= 'GST';
		$Data['SubMenu'] 	= 'GST';
		$Data['SelectMenu'] = 'GST';
				$Data['Language'] = $this->CategoryModel->Language();

		return View('Admin/GST/Add')->with($Data);
	}
	public function InsertGST(Request $request){
		$Data = $request->all();
		$Save['gst'] 	            = $Data['gst'];
		$Save['status'] 	        = $Data['status'];
		$Save['language_id'] 	    = $Data['language_id'];

		$Save['created_at'] 		= date('Y-m-d H:i:s');

		$gst_id = $this->OffersModel->AddGst($Save);
		if($gst_id){
			$msg = Common::AlertErrorMsg('Success','GST Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('GST');
	}


	public function EditGST($id){
		$Id = base64_decode($id);
		$CheckID = $this->OffersModel->CheckGst(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->OffersModel->GetGst($Id);
		$Data['Result'] 	= $Result;
		$Data['Language'] = $this->CategoryModel->Language();
		$Data['Title'] 		= 'Edit GST';
		$Data['Menu'] 		= 'GST';
		$Data['SubMenu'] 	= 'GST';
		$Data['SelectMenu'] = 'GST';
		return View('Admin/GST/Edit')->with($Data);
		
	}
	
	public function SaveGst(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];
		$Save['gst'] 		= $Data['gst'];
		$Save['status'] 	= $Data['status'];
		$Save['language_id'] 	    = $Data['language_id'];
		$Save['updated_at'] = date('Y-m-d H:i:s');
		$Result = $this->OffersModel->UpdateGst($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','GST Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('GST');
	}

	public function DeleteGst($ID){
		$id = base64_decode($ID);
		DB::table('gst')->where('id',$id)->delete();	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}
	
}