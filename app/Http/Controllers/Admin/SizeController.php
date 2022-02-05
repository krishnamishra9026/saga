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
use App\Http\Models\Admin\SizeModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Admin\CategoryModel;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class SizeController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->SizeModel = new SizeModel();
		$this->CategoryModel = new CategoryModel();
	}

	public function Size(){
		
		$Data['Title'] 		= 'Size List';
		$Data['Menu'] 		= 'Size';
		$Data['SubMenu'] 	= 'Size';
		$Data['SelectMenu'] = 'Size';
		$Data['Size'] = $this->SizeModel->SizeList();
		return View('Admin/Size/List')->with($Data);

	}

	public function AddSize(){
		$Data['Title'] 		= 'Add Size';
		$Data['Menu'] 		= 'Size';
		$Data['SubMenu'] 	= 'Size';
		$Data['SelectMenu'] = 'Size';
		$Data['category']   	= DB::table('category')->select('*')->get();
		$Data['Language'] = $this->CategoryModel->Language();
		return View('Admin/Size/Add')->with($Data);
	}

	public function InsertSize(Request $request){
		$Data = $request->all();
		$Save['category_id'] 	= $Data['category_id'];
		$Save['sub_category_id']= $Data['sub_category_id'];
		$Save['name'] 			= $Data['name'];
		$Save['status'] 		= $Data['status'];
		$Save['created_at'] 	= date('Y-m-d H:i:s');
		
		$Pro_id = $this->SizeModel->AddSize($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Size Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Size');
	}

	public function EditSize($id){
		$Id = base64_decode($id);
		$CheckID = $this->SizeModel->CheckSize(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->SizeModel->GetSize($Id);
		$Data['Language'] = $this->CategoryModel->Language();
		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Size';
		$Data['Menu'] 		= 'Size';
		$Data['SubMenu'] 	= 'Size';
		$Data['SelectMenu'] = 'Size';
		return View('Admin/Size/Edit')->with($Data);
	}

	public function SaveSize(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];
		$Save['category_id'] 	= $Data['category_id'];
		$Save['sub_category_id']= $Data['sub_category_id'];
		$Save['name'] 			= $Data['name'];
		$Save['status'] 		= $Data['status'];
		$Save['updated_at'] 	= date('Y-m-d H:i:s');

		$Result = $this->SizeModel->UpdateSize($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Size Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Size');
	}

	public function DeleteSize($ID){
		$id = base64_decode($ID);
		DB::table('sizes')->where('id',$id)->delete();	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

	public function fetchCategoryList(Request $request)
    {
		$finalArray = array();
		$requestData = $request->all();
		$categoryId = $requestData['category_id'];
		$category=DB::table('sub-category')->where('category_id',$categoryId)->get();	
		$categoryHtml = $this->getcategoryHtml($category);
		$finalArray= array('status'=>'success',
		'data_cate'=>$categoryHtml
		);
		print_r(json_encode($finalArray));
		exit();
	}

	private function getcategoryHtml($category)
	{
		$html='';

		$html.='<select class="form-control required" name="sub_category_id" id="sub_category_id"  onchange="getSizeList(this)">';
		                             
		$html .='<option value="0">Select</option>';

		foreach($category as $rs)
		{
		$html .='<option value="'.$rs->id.'">'.$rs->name.'</option>';

		}

		$html.='</select>';
		return $html;
	}

	public function fetchColorList(Request $request)
	{
	  
		$finalArray = array();
		$requestData = $request->all();
		$sizeId = $requestData['sizeId'];
		$colors=DB::table('colors')->where('size_id',$sizeId)->get();	

		$colorHtml = $this->getColorHtml($colors);

		$finalArray= array('status'=>'success',
		'data_color'=>$colorHtml
		);
		print_r(json_encode($finalArray));
		exit();
	}

	private function getColorHtml($colors)
	{
		$html='';

		$html.='<select class="form-control required" name="color_id" id="color_id"  >';
		                         
		$html .='<option value="0">Select</option>';

		foreach($colors as $rs)
		{
		$html .='<option value="'.$rs->id.'">'.$rs->name.'</option>';

		}

		$html.='</select>';
		return $html;
	}

}