<?php
namespace App\Http\Controllers\Front;
use Route;
use Mail;
use Auth, Hash;
use Validator;
use Session;
use Redirect;
use DB;
use Crypt;
use Illuminate\Http\Request;
use App\Http\Models\Front\HomeModel;
use Illuminate\Routing\ResponseFactory;
use App\Http\Controllers\Controller;


class HomeController extends Controller 
{
    public function __construct(Request $request)
    {
        $this->HomeModel    = new HomeModel();
    }

    public function HomePage(Request $Request){
        $Data['Title']                  = 'Saka Maka | Order Indian Takeaway in Brockley, London';
        $Data['Menu']                   = 'Home';
        $Data['DivClass']               = '';

        // print_r($Data);
        // exit();

        $Data['Banners']                = $this->HomeModel->BannerList();
        $Data['Categories']             = $this->HomeModel->CategoriesList();
        $Data['Menu']                   = $this->HomeModel->MenuList();
        $Data['Customers']              = $this->HomeModel->CustomersList();
        $Data['Discount']               = $this->HomeModel->DiscountList();
        $Data['Settings']               = $this->HomeModel->Settings();
        return View('Front.index')->with($Data);
    }

    public function Menus(){
        $Data['Title']                  = 'Menus | Order Indian Takeaway in Brockley, London';
        $Data['Menu']                   = 'Home';
        $Data['DivClass']               = 'bid';
        $Data['Banners']                = $this->HomeModel->BannerList();
        $Data['Categories']             = $this->HomeModel->CategoriesList();
        $Data['Menu']                   = $this->HomeModel->MenuList();
        $Data['Settings']               = $this->HomeModel->Settings();
        return View('Front.menus')->with($Data);
    }

    public function About(){
        $Data['Title']                  = 'About Us | Order Indian Takeaway in Brockley, London';
        $Data['Menu']                   = 'Home';
        $Data['DivClass']               = 'bid';
        $Data['Settings']               = $this->HomeModel->Settings();
        return View('Front.about')->with($Data);
    }

    public function Contact(){
        $Data['Title']                  = 'Contact Us | Order Indian Takeaway in Brockley, London';
        $Data['Menu']                   = 'Home';
        $Data['DivClass']               = 'bid';
        $Data['Settings']               = $this->HomeModel->Settings();
        return View('Front.contact')->with($Data);
    }
}