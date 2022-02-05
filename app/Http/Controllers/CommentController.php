<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\CommentModel;

use Cart;
use Session;


class CommentController extends Controller
{

    public function __construct(Request $request)
    {
        $this->commentModel  = new CommentModel();
      
    }


    public function userRating(Request $request)
    {

     
        if(session('user_id'))
{

    if($request->isMethod('post'))
    {
    
    $requestDataArray = $request->all();
    
$productId = $requestDataArray['product_id'];
    $userRatingArray= array(
        'user_id'=>session('user_id'),
   'product_id'=>$requestDataArray['product_id'],
   'rating'=>$requestDataArray['rate'],
    'review'=>$requestDataArray['message'],
    'created_at'=>date('Y-m-d H:i:s')
);

$userRatingData = $this->commentModel->insertUserRating($userRatingArray);
return Redirect()->route('Home');

}
}
else
{
    return Redirect()->route('Login');

}
}


    public function userComment(Request $request)
    {

     
        if(session('user_id'))
{

    if($request->isMethod('post'))
    {
    
    $requestDataArray = $request->all();

    
    $userCommentArray= array(
        'user_id'=>session('user_id'),
   
    'user_comment'=>$requestDataArray['user_comment'],
    'blog_id'=>$requestDataArray['blog_id']
    
    );
  
    $userCommentData = $this->commentModel->insertUserComment($userCommentArray);

    if($userCommentData)
    {
        
        $userId = session('user_id');
        $userComment = $this->commentModel->getUserComment($userId);
        $userCommentHtml = $this->getUserCommentHtml($userComment);
      
        $finalArray = array('status'=>'success',
        'commentHtml'=>$userCommentHtml,
        'count'=>count($userComment)
        
        
    );
  
    print_r(json_encode($finalArray));
    exit();

    }else{

        $finalArray = array('status'=>'failure'
        
        
        );
            
    print_r(json_encode($finalArray));
    exit();
    }
    }
    }
}


public function showUserComment(Request $request)
{

    
      
        $userComment = $this->commentModel->getUserCommentWithoutUserId();
        $userCommentHtml = $this->getUserCommentHtml($userComment);
        
        $finalArray = array('status'=>'success',
        'commentHtml'=>$userCommentHtml,
        'count'=>count($userComment)

    );
    
    print_r(json_encode($finalArray));
    exit();
    

}


public function getUserCommentHtml($userComment){

$html = '';
foreach($userComment as $userCom)
{
   
  
		$convert_date = strtotime($userCom->comment_add_date);

        $convertdateReply = strtotime($userCom->user_comment_reply_date);

        $time = date('H:i',$convert_date);

        $month = date('F',$convert_date);
        $year = date('Y',$convert_date);
        $name_day = date('l',$convert_date);
        $day = date('j',$convert_date);	


        $timeR = date('H:i',$convertdateReply);
        $monthR = date('F',$convertdateReply);
        $yearR = date('Y',$convertdateReply);
        $name_dayR = date('l',$convertdateReply);
        $dayR = date('j',$convertdateReply);	


$html.='<div class="single-comment">';
$html.='<img src="https://via.placeholder.com/80x80" alt="#">';
$html.='<div class="content">';
$html.='<h4>'.session('user_name').' <span>At '.$time.', '.$day.' '.$month.' ,'.$year.', '.$name_day.'</span></h4>';


$html.='<p>'.$userCom->user_comment.'</p>';

if($userCom->user_comment_reply == null)
{

$html.='<div class="button">';
$html.='<a href="#demo'.$userCom->comment_id.'"   data-toggle="collapse"  class="btn"><i class="fa fa-reply" aria-hidden="true"></i>Reply</a>';
$html.='  <div id="demo'.$userCom->comment_id.'" class="collapse">
<form id="userCommentReplyForm" >
<input type="text"  id="user_comment_reply'.$userCom->comment_id.'"name="firstName" value="" class="form-control">
<button type="button" onclick="ReplyComment('.$userCom->comment_id.')"  class="btn bg-primary p-3 text-white mt-2" id="submit">Submit</button>
</form>
</div> ';
$html.='</div>';

}else{

    $html.='<div class="button">';
    $html.='<div style="margin-right:150px;">';
$html.='<h4>Admin<span>At '.$timeR.', '.$dayR.' '.$monthR.' ,'.$yearR.', '.$name_dayR.'</span></h4>';


$html.='<p>'.$userCom->user_comment_reply.'</p>';
$html.='</div>';
    $html.='</div>';


}



$html.='</div>';
$html.='</div>';


}


return $html;


}

public function ReplyUserComment(Request $request)
{

$requestData = $request->all();

$commentId = $requestData['user_comment_id'];
unset($requestData['user_comment_id']);
$requestData['user_comment_reply_date'] = date('Y-m-d H:i:s');

 $result=DB::table('user_comment')->where('comment_id','=',$commentId)->update($requestData);

 $finalArray = array('status'=>'success',
 

);

print_r(json_encode($finalArray));
exit();



}
  
    //
}
