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
use App\Http\Models\Admin\OurCustomersModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class OurCustomersController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->OurCustomersModel = new OurCustomersModel();
	}

	public function OurCustomers(){
		
		$Data['Title'] 		= 'Our Customers List';
		$Data['Menu'] 		= 'Customers';
		$Data['SubMenu'] 	= 'Customers';
		$Data['SelectMenu'] = 'Customers';
		$Data['OurCustomers'] = $this->OurCustomersModel->OurCustomersList();
	
		return View('Admin/OurCustomers/List')->with($Data);

	}

	public function OurReview(){
		
		$Data['Title'] 		= 'Review List';
		$Data['Menu'] 		= 'Review';
		$Data['SubMenu'] 	= 'Review';
		$Data['SelectMenu'] = 'Review';
		$Data['OurReviewList'] = $this->OurCustomersModel->ReviewList();
		

	
		return View('Admin/Reviews/List')->with($Data);

	}

public function OurUserComment(){
		
		$Data['Title'] 		= 'Comment List';
		$Data['Menu'] 		= 'Comment';
		$Data['SubMenu'] 	= 'Comment';
		$Data['SelectMenu'] = 'Comment';
		$Data['OurUserComment'] = $this->OurCustomersModel->CommentList();



	    return View('Admin/Comment/List')->with($Data);

	}


	public function AddOurCustomers(){
		$Data['Title'] 		= 'Add Our Customers';
		$Data['Menu'] 		= 'Customers';
		$Data['SubMenu'] 	= 'Customers';
		$Data['SelectMenu'] = 'Customers';
		return View('Admin/OurCustomers/Add')->with($Data);
	}

	public function InsertOurCustomers(Request $request){
		$Data = $request->all();
		$Save['title'] 	= $Data['title'];
		$Save['description'] 	= $Data['description'];
		$Save['name'] 	= $Data['name'];
		$Save['status'] = $Data['status'];
		$Save['created_at'] 	= date('Y-m-d H:i:s');
		
		$Pro_id = $this->OurCustomersModel->AddOurCustomers($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Our Customers Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('OurCustomers');
	}

	public function EditOurCustomers($id){
		$Id = base64_decode($id);
		$CheckID = $this->OurCustomersModel->CheckOurCustomers(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->OurCustomersModel->GetOurCustomers($Id);
		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Our Customers';
		$Data['Menu'] 		= 'Customers';
		$Data['SubMenu'] 	= 'Customers';
		$Data['SelectMenu'] = 'Customers';
		return View('Admin/OurCustomers/Edit')->with($Data);
	}

	public function SaveOurCustomers(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];

		$Save['status'] = $Data['status'];
		$Save['title'] 	= $Data['title'];
		$Save['description'] 	= $Data['description'];
		$Save['name'] 	= $Data['name'];
		$Save['updated_at'] = date('Y-m-d H:i:s');

		$Result = $this->OurCustomersModel->UpdateOurCustomers($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Our Customers Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('OurCustomers');
	}

	public function DeleteOurCustomers($ID){
		$id = base64_decode($ID);
		DB::table('ourcustomers')->where('id',$id)->delete();	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

}