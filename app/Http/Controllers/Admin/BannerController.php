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
use App\Http\Models\Admin\BannerModel;
use App\Http\Models\Admin\CategoryModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class BannerController extends Controller 
{
	public function __construct(Request $request)
	{		
		$this->BannerModel = new BannerModel();
		$this->CategoryModel = new CategoryModel();

	}

	public function Banner(){
		$Data['Title'] 		= 'Banner List';
		$Data['Menu'] 		= 'Banner';
		$Data['SubMenu'] 	= 'Banner';
		$Data['SelectMenu'] = 'Banner';
		$Data['Banner']   = $this->BannerModel->BannerList();
		$Data['Language'] = $this->CategoryModel->Language();
		return View('Admin/Banner/List')->with($Data);
	}

	public function AddBanner(){
		$Data['Title'] 		= 'Add Banner';
		$Data['Menu'] 		= 'Banner';
		$Data['SubMenu'] 	= 'Banner';
		$Data['SelectMenu'] = 'Banner';
		$Data['Language'] = $this->CategoryModel->Language();

		return View('Admin/Banner/Add')->with($Data);
	}
    
    public function InsertBanner(Request $request)
    {
        $Data = $request->all();
        $Save['name'] 		= $Data['name'];
		$Save['language_id'] 		= $Data['language_id'];
        $Save['status'] 		= $Data['status'];
		$Save['created_at'] 	= date('Y-m-d H:i:s');
		
		if(!empty($Data['image'])){
			$image = $Data['image'];
			$Path = 'images/banner';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}
		
		$Banner_id = $this->BannerModel->AddBanner($Save);
		if($Banner_id){
			$msg = Common::AlertErrorMsg('Success','Banner Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Banner');
    }
    
    public function EditBanner($id){
		$Id = base64_decode($id);
		$CheckID = $this->BannerModel->CheckBannerName(['id'=>$Id]);
		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->BannerModel->GetBannerDetails($Id);
		$Data['Language'] = $this->CategoryModel->Language();
		$Data['Result'] 	= $Result;
		$Data['Title'] 		= 'Edit Banner';
		$Data['Menu'] 		= 'Banner';
		$Data['SubMenu'] 	= 'Banner';
		$Data['SelectMenu'] = 'Banner';
		return View('Admin/Banner/Edit')->with($Data);
	}
	
	public function SaveBanner(Request $request)
	{
		$Data = $request->all();
		$EditID	= $Data['edit_id'];
		$Save['name'] 			= $Data['name'];
		$Save['language_id'] 	= $Data['language_id'];
		$Save['status'] 		= $Data['status'];
		$Save['updated_at'] 	= date('Y-m-d H:i:s');
		
		if(!empty($Data['image'])){
			$image = $Data['image'];
			$Path = 'images/banner/';
			$extension = $image->getClientOriginalExtension();
			$ImageName = 'IMG_'.date('YmdHis').'.'.$extension;
			$Upload = $image->move($Path, $ImageName);
			$Save['image'] 	= $ImageName;
		}

		$Result = $this->BannerModel->UpdateBanner($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Banner Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Banner');
	}

	public function DeleteBanner($ID){
		$id = base64_decode($ID);
		DB::table('banner')->where('id',$id)->delete();	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

}