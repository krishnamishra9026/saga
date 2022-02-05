<?php
namespace App\Http\Controllers\User;
use Route;
use Mail;
use Auth, Hash;
use Validator;
use Session;
use Redirect;
use DB;
use Crypt;
use Illuminate\Http\Request;
use App\Http\Models\User\UserModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use App\Helpers\Common;

class UserController extends Controller 
{
    public function __construct(Request $request)
    {
        $this->UserModel    = new UserModel();
    }

    public function MyAccount(Request $Request){
        $id = Session::get('user_id');
        $Data['Title']                  = 'Saka Maka | Order Indian Takeaway in Brockley, London';
        $Data['Menu']                   = 'Orders';
        $Data['DivClass']               = '';
        $Data['user']                   = $this->UserModel->GetUserDetails($id);
        $Data['Settings']               = $this->UserModel->Settings();
        return View('User.myaccount')->with($Data);
    }

    public function Addresses(Request $Request){
        $id = Session::get('user_id');
        $Data['Title']                  = 'Saka Maka | Order Indian Takeaway in Brockley, London';
        $Data['Menu']                   = 'Addresses';
        $Data['DivClass']               = '';
        $Data['user']                   = $this->UserModel->GetUserDetails($id);
        $Data['Settings']               = $this->UserModel->Settings();
        return View('User.address')->with($Data);
    }

    public function Orders(Request $Request){
        $id = Session::get('user_id');
        $Data['Title']                  = 'Saka Maka | Order Indian Takeaway in Brockley, London';
        $Data['Menu']                   = 'Orders';
        $Data['DivClass']               = '';
        $Data['user']                   = $this->UserModel->GetUserDetails($id);
        $Data['Settings']               = $this->UserModel->Settings();
        return View('User.myaccount')->with($Data);
    }

    public function UpdateProfile(Request $request){
        $Data = $request->all();
        $Save['name']   = $Data['name'];
        Session::put('user_name', ucfirst($Save['name']));
        Session::save();
        DB::table('users')->where('id',Session::get('user_id'))->update($Save);
        $msg = Common::AlertErrorMsg('Success','Save Successfully');
        Session::flash('message', $msg); 
        return Redirect()->back();
    }

}