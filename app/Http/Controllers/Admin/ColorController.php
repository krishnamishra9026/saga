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
use App\Http\Models\Admin\ColorModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Models\Admin\CategoryModel;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class ColorController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->ColorModel = new ColorModel();
		$this->CategoryModel = new CategoryModel();
	}

	public function Color(){
		
		$Data['Title'] 		= 'Color List';
		$Data['Menu'] 		= 'Color';
		$Data['SubMenu'] 	= 'Color';
		$Data['SelectMenu'] = 'Color';
		$Data['Color'] = $this->ColorModel->ColorList();
		return View('Admin/Color/List')->with($Data);
	}

	public function AddColor(){
		$Data['Title'] 		= 'Add Color';
		$Data['Menu'] 		= 'Color';
		$Data['SubMenu'] 	= 'Color';
		$Data['SelectMenu'] = 'Color';
		$Data['category']   = DB::table('category')->select('*')->get();
		$Data['Language'] = $this->CategoryModel->Language();
		return View('Admin/Color/Add')->with($Data);
	}

	public function InsertColor(Request $request){
		$Data = $request->all();
		/*$Save['category_id'] 	= $Data['category_id'];
		$Save['sub_category_id']= $Data['sub_category_id'];
		$Save['size_id'] 		= $Data['size_id'];*/
		$Save['language_id'] 	= $Data['language_id'];
		$Save['name'] 			= $Data['name'];
		$Save['status'] 		= $Data['status'];
		$Save['created_at'] 	= date('Y-m-d H:i:s');
		
		$Pro_id = $this->ColorModel->AddColor($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Color Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Color');
	}

	public function EditColor($id){
		$Id = base64_decode($id);
		$CheckID = $this->ColorModel->CheckColor(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->ColorModel->GetColor($Id);
		$Data['Language'] = $this->CategoryModel->Language();
		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Color';
		$Data['Menu'] 		= 'Color';
		$Data['SubMenu'] 	= 'Color';
		$Data['SelectMenu'] = 'Color';
		return View('Admin/Color/Edit')->with($Data);
	}

	public function SaveColor(Request $request){
		$Data = $request->all();
		$EditID	= $Data['edit_id'];
		/*$Save['category_id'] 	= $Data['category_id'];
		$Save['sub_category_id']= $Data['sub_category_id'];
		$Save['size_id'] 		= $Data['size_id'];*/
		$Save['language_id'] 	= $Data['language_id'];
		$Save['name'] 			= $Data['name'];
		$Save['status'] 		= $Data['status'];
		$Save['updated_at'] 	= date('Y-m-d H:i:s');

		$Result = $this->ColorModel->UpdateColor($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Color Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Color');
	}

	public function DeleteColor($ID){
		$id = base64_decode($ID);
		DB::table('colors')->where('id',$id)->delete();	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}


	public function fetchSizeList(Request $request)
	{
		$finalArray = array();
		$requestData = $request->all();
		$category_id = $requestData['category_id'];
		$size=DB::table('sizes')->where('sub_category_id',$category_id)->get();	
		$sizeHtml = $this->getSizeHtml($size);
		$finalArray= array('status'=>'success',
		'data_size'=>$sizeHtml
		);
		print_r(json_encode($finalArray));
		exit();  
	}

	private function getSizeHtml($category)
	{
		$html='';
		$html.='<select class="form-control required" name="size_id" id="size_id" onchange="getColorList(this)">';
		$html .='<option value="0">Select</option>';
		foreach($category as $rs)
		{
		$html .='<option value="'.$rs->id.'">'.$rs->name.'</option>';
		}
		$html.='</select>';
		return $html;
	}

}