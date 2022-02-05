<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function checkUserAuthentication(Request $request)
    {

    if(!session('user_id'))
    {
// Redirecting to login page

return redirect('/login');

   

    //  $publicRedirectUrl = $request->url();
    
    
    //     session()->put('publicRedirectUrl', $publicRedirectUrl);
    
    //     session()->save();

        // $redirectUrl = '/login?action=login&url='.$publicRedirectUrl;

 
// User tracking 

// $this->userTracking($request);

// User Tracking



    }
    else
    {

        $user_id = session('user_id');
        
			return Redirect()->route('Checkout');

       

    //     if($test_id != 'none' && $exam_name !='none')
    // {
    //     $publicRedirectUrl = "/test-process-welcome/$exam_name/$test_name/$test_id";
       
    // }
    // else
    // {
    //     $publicRedirectUrl = '/user-panel/my-tests';
    
    
    // }



// Redirecting to redirect page , authenticate user ( subscribe ) , for particular exam , test  , / log details



// $responseSubs = $this->fpanel()->userExamSubscribeOnly($user_id,$exam_id);



// User tracking 

// $this->userTracking($request);

// User Tracking

// return redirect($publicRedirectUrl);

    }

exit();


    }
    //
}
