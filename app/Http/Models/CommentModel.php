<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class CommentModel extends Model
{

public function insertUserComment($userCommentArray)
{

$CommentArray = array();
$result = DB::table('user_comment')->insert($userCommentArray);
return $result;

}


public function insertUserRating($userCommentArray)
{

$CommentArray = array();
$result = DB::table('user_rating')->insert($userCommentArray);
return $result;

}

public function getUserComment($userId)
{

    $result = DB::table('user_comment')->select('*')->where('user_id','=',$userId)->get();
    return $result;

}

public function getUserCommentWithoutUserId()
{

    $result = DB::table('user_comment')->select('*')->get();
    return $result;

}


public function verifyUser($userEmailId)
{
    $data =  aaray();

$result = DB::table('user_details')->select('user_email_id')->where('user_email_id','=',$user_email_id)->get()->toArray();

$data = json_decode(json_encode((array) $result),true);

if(isset($data) && count($data)>0)
{

return $data;

}

else{

    return $data;

}

}


}
