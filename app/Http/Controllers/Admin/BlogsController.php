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
use App\Http\Models\Admin\BlogsModel;
use App\Http\Models\Admin\CategoryModel;

use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class BlogsController extends Controller 
{
	public function __construct(Request $request)

	{			$this->CategoryModel = new CategoryModel();
	
		$this->BlogsModel = new BlogsModel();
	}

	public function blogs(){
		
		$Data['Title'] 		= 'Blog List';
		$Data['Menu'] 		= 'Blog';
		$Data['SubMenu'] 	= 'Blog';
		$Data['SelectMenu'] = 'Blog';
		$Data['Blogs'] = $this->BlogsModel->BlogsList();

		

		return View('Admin/Blogs/List')->with($Data);

	}

	public function AddBlog(){
		$Data['Title'] 		= 'Add Blog';
		$Data['Menu'] 		= 'Blog';
		$Data['SubMenu'] 	= 'Blog';
		$Data['SelectMenu'] = 'Blog';
		$Data['categories'] = $this->CategoryModel->CategoryList();
		$Data['Language'] = $this->CategoryModel->Language();


		return View('Admin/Blogs/AddBlogs')->with($Data);
	}

	public function InsertBlog(Request $request){
        $Data = $request->all();
        

        $Save['blog_title'] 	= $Data['blog_title'];
        $Save['blog_title_display_name'] 	= $Data['blog_title_display_name'];
		$Save['language_id'] 	= $Data['language_id'];

        $Save['blog_description'] 	= $Data['blog_description'];


		$Save['status'] = $Data['status'];
		$Save['created_at'] 	= date('Y-m-d H:i:s');
	
        $images=array();
		if($files=$request->file('images')){
			$Path = 'images/blog';
			foreach($files as $file){
				$extension = strtoupper($file->getClientOriginalName());
				$name = 'IMG_'.date('YmdHis').$extension;
				$file->move($Path,$name);
				$images[]=$name;
			}
			$multipleimg = implode("|",$images);
			$Save['images'] = $multipleimg;
		}
       
        
		$Pro_id = $this->BlogsModel->AddBlog($Save);
		if($Pro_id){
			$msg = Common::AlertErrorMsg('Success','Blog Details Has been Saved.');
		}else{
			$msg = Common::AlertErrorMsg('Danger','OOPS! Something Wrong Please Try Again.');
		}
		Session::flash('message', $msg);
		return Redirect()->route('Blog');
	}

	public function EditBlogs($id){
        $Id = base64_decode($id);
      
		$CheckID = $this->BlogsModel->Checkblogs(['blog_id'=>$Id]);
		
	

		if($CheckID==0){
			return Redirect()->back();
		}
		$Result 			= $this->BlogsModel->Getblogs($Id);
		// print_r($Result);
		// exit();
		$Data['Result'] 	= $Result;
		$Data['categories'] = $this->CategoryModel->CategoryList();

		$Data['Language'] = $this->CategoryModel->Language();
		$Data['Title'] 		= 'Edit Blog';
		$Data['Menu'] 		= 'Blog';
		$Data['SubMenu'] 	= 'Blog';
        $Data['SelectMenu'] = 'Blog';
       
		return View('Admin/Blogs/EditBlog')->with($Data);
	}

	public function SaveBlog(Request $request){
		$Data = $request->all();
		$EditID	= $Data['blog_id'];
 
        
        $Save['blog_title'] 	= $Data['blog_title'];
        $Save['blog_title_display_name'] 	= $Data['blog_title_display_name'];
		$Save['language_id'] 	= $Data['language_id'];
		$Save['blog_description'] 	= $Data['blog_description'];
		$Save['status'] = $Data['status'];
        $Save['updated_at'] = date('Y-m-d H:i:s');
        
        $images=array();
		if($files=$request->file('images')){
			$Path = 'images/blog';
			foreach($files as $file){
				$extension = strtoupper($file->getClientOriginalName());
				$name = 'IMG_'.date('YmdHis').$extension;
				$file->move($Path,$name);
				$images[]=$name;
			}
			$multipleimg = implode("|",$images);
			$Save['images'] = $multipleimg;
		}

        // print_r($Save);
        // exit();
		$Result = $this->BlogsModel->Updateblogs($EditID,$Save);
		$msg = Common::AlertErrorMsg('Success','Blog Details Has been Updated.');
		Session::flash('message', $msg);
		return Redirect()->route('Blog');
	}

	public function DeleteBlog($ID){
		$id = base64_decode($ID);
		DB::table('blogs')->where('blog_id',$id)->delete();	
		$msg = Common::AlertErrorMsg('Success','Delete Successfully.');
		Session::flash('message', $msg);
		return Redirect()->back();
	}

}