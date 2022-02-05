<?php
namespace App\Helpers;
use DateTime;
use Date;
use DB;
use Session;
use Anam\Phpcart\Cart;

class Common {	

	public static function AlertErrorMsg($ErrorType,$Msg) {
		if($ErrorType == 'Success'){  
			$AlertErrorMsg = '<div class="alert alert-success alert-dismissible" role="alert">
				    							<button type="button" class="close" data-dismiss="alert">×</button>
				    							<div class="alert-icon"><i class="icon-check"></i></div>
				    							<div class="alert-message">
				      							<span>'.$Msg.'</span>
				    							</div>
                  			</div>';
		}elseif($ErrorType == 'Danger'){
			$AlertErrorMsg = '<div class="alert alert-danger alert-dismissible" role="alert">
				    							<button type="button" class="close" data-dismiss="alert">×</button>
				    							<div class="alert-icon"><i class="icon-close"></i></div>
				    							<div class="alert-message">
				      							<span>'.$Msg.'</span>
				    							</div>
                  			</div>';

		}elseif($ErrorType == 'Info'){
			$AlertErrorMsg = '<div class="alert alert-info alert-dismissible" role="alert">
				    							<button type="button" class="close" data-dismiss="alert">×</button>
				    							<div class="alert-icon"><i class="icon-info"></i></div>
				    							<div class="alert-message">
				      							<span>'.$Msg.'</span>
				    							</div>
                  			</div>';
		}elseif($ErrorType == 'Warning'){
			$AlertErrorMsg = '<div class="alert alert-warning alert-dismissible" role="alert">
				    							<button type="button" class="close" data-dismiss="alert">×</button>
				    							<div class="alert-icon"><i class="icon-exclamation"></i></div>
				    							<div class="alert-message">
				      							<span>'.$Msg.'</span>
				    							</div>
                  			</div>';
		}else{
			$AlertErrorMsg = '';
		}
		return $AlertErrorMsg;
	}

	public static function Pagination($numofrecords, $count, $page){
		$per_page = $numofrecords;
		$previous_btn = true;
		$next_btn = true;
		$first_btn = true;
		$last_btn = true;
		$start = $page * $per_page;
		$cur_page = $page;
		$msg = "";
		$no_of_paginations = ceil($count / $per_page);
		if($count>0)
		{
			if ($cur_page >= 7) {
				$start_loop = $cur_page - 3;
				if ($no_of_paginations > $cur_page + 3)
				$end_loop = $cur_page + 3;
				else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
	    			$start_loop = $no_of_paginations - 6;
	    			$end_loop = $no_of_paginations;
				} else {
	    			$end_loop = $no_of_paginations;
				}
			} else {
				$start_loop = 1;
				if ($no_of_paginations > 7)
	    		$end_loop = 7;
				else
	    		$end_loop = $no_of_paginations;
			}
			$msg .= "<ul class='pagination pagination-outline-secondary'>";
			if ($first_btn && $cur_page > 1) {
				//$msg .= "<li p='1' class='page-item'><a onclick='Pagination(1)' class='page-link' href='javascript:void(0)'>First</a>First</li>";
			} else if ($first_btn) {
				//$msg .= "<li p='1' class='page-item inactive'><a class='page-link' href='javascript:void(0)'>First</a></li>";
			}
			if ($previous_btn && $cur_page > 1) {
				$pre = $cur_page - 1;
				$msg .= "<li p='$pre' class='page-item'><a onclick='Pagination($pre)' class='page-link' href='javascript:void(0)'>Previous</a></li>";
			} else if ($previous_btn) {
				$msg .= "<li class='page-item inactive'><a class='page-link' href='javascript:void(0)'>Previous</a></li>";
			}
			for ($i = $start_loop; $i <= $end_loop; $i++) {
				if ($cur_page == $i)
	    		$msg .= "<li p='$i' class='page-item active'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>";
				else
	    		$msg .= "<li p='$i' class='page-item'><a class='page-link' onclick='Pagination($i)' href='javascript:void(0)'>{$i}</a></li>";
				}
			    if ($next_btn && $cur_page < $no_of_paginations) {
			      $nex = $cur_page + 1;
			      $msg .= "<li p='$nex' class='page-item'><a onclick='Pagination($nex)' class='page-link' href='javascript:void(0)'>Next</a></li>";
			    } else if ($next_btn) {
			      $msg .= "<li class='page-item inactive'><a class='page-link' href='javascript:void(0)'>Next</a></li>";
			    }

				if ($last_btn && $cur_page < $no_of_paginations) {
					//$msg .= "<li p='$no_of_paginations' class='page-item active' onclick='Pagination($no_of_paginations)'>Last</li>";
				} else if ($last_btn) {
					//$msg .= "<li p='$no_of_paginations' class='page-item inactive'>Last</li>";
				}
				$goto = '<select id="CurrentPage" class="form-control" onchange="Search(this.value)">';
				for ($i=1; $i <= $no_of_paginations; $i++) { 
					$Selected = '';
					if($cur_page==$i){
						$Selected = 'selected';
					}
					$goto.= '<option '.$Selected.' value="'.$i.'">'.$i.'</option>';
				}
				$goto.= '</select>';
				//$total_string = "<span class='total' a='$no_of_paginations'>(page<b>" . $cur_page . "</b> of <b>$no_of_paginations</b> )</span>";
				//$msg = $msg . "</ul>" . $goto . $total_string . "</div>";
				//$msg = $msg . "<li>".$total_string.'</li>';
				$msg = $msg . "<li>".$goto.'</li>';
				$msg = $msg . "</ul>";
				return $msg;
		}
		else
		{
			$Msg = '<input type="hidden" id="CurrentPage" value="1">
							<div class="col-md-12 text-center" style="color:red"><strong>No Record Found</strong></div>';
			return $Msg;
		}
	}
	public static function FrontPagination($numofrecords, $count, $page){
		$per_page = $numofrecords;
		$previous_btn = true;
		$next_btn = true;
		$first_btn = true;
		$last_btn = true;
		$start = $page * $per_page;
		$cur_page = $page;
		$msg = "";
		$no_of_paginations = ceil($count / $per_page);
		if($count>0)
		{
			if ($cur_page >= 7) {
				$start_loop = $cur_page - 3;
				if ($no_of_paginations > $cur_page + 3)
				$end_loop = $cur_page + 3;
				else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
	    			$start_loop = $no_of_paginations - 6;
	    			$end_loop = $no_of_paginations;
				} else {
	    			$end_loop = $no_of_paginations;
				}
			} else {
				$start_loop = 1;
				if ($no_of_paginations > 7)
	    		$end_loop = 7;
				else
	    		$end_loop = $no_of_paginations;
			}
			$msg .= "<ul class='pagination pagination-outline-secondary'>";
			if ($first_btn && $cur_page > 1) {
				//$msg .= "<li p='1' class='page-item'><a onclick='Pagination(1)' class='page-link' href='javascript:void(0)'>First</a>First</li>";
			} else if ($first_btn) {
				//$msg .= "<li p='1' class='page-item inactive'><a class='page-link' href='javascript:void(0)'>First</a></li>";
			}
			if ($previous_btn && $cur_page > 1) {
				$pre = $cur_page - 1;
				$msg .= "<li p='$pre' class='page-item'><a onclick='Pagination($pre)' class='page-link' href='javascript:void(0)'>Previous</a></li>";
			} else if ($previous_btn) {
				$msg .= "<li class='page-item inactive'><a class='page-link' href='javascript:void(0)'>Previous</a></li>";
			}
			for ($i = $start_loop; $i <= $end_loop; $i++) {
				if ($cur_page == $i)
	    		$msg .= "<li p='$i' class='page-item active'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>";
				else
	    		$msg .= "<li p='$i' class='page-item'><a class='page-link' onclick='Pagination($i)' href='javascript:void(0)'>{$i}</a></li>";
				}
			    if ($next_btn && $cur_page < $no_of_paginations) {
			      $nex = $cur_page + 1;
			      $msg .= "<li p='$nex' class='page-item'><a onclick='Pagination($nex)' class='page-link' href='javascript:void(0)'>Next</a></li>";
			    } else if ($next_btn) {
			      $msg .= "<li class='page-item inactive'><a class='page-link' href='javascript:void(0)'>Next</a></li>";
			    }

				if ($last_btn && $cur_page < $no_of_paginations) {
					//$msg .= "<li p='$no_of_paginations' class='page-item active' onclick='Pagination($no_of_paginations)'>Last</li>";
				} else if ($last_btn) {
					//$msg .= "<li p='$no_of_paginations' class='page-item inactive'>Last</li>";
				}
				$goto = '<select id="CurrentPage" class="form-control" onchange="Search(this.value)">';
				for ($i=1; $i <= $no_of_paginations; $i++) { 
					$Selected = '';
					if($cur_page==$i){
						$Selected = 'selected';
					}
					$goto.= '<option '.$Selected.' value="'.$i.'">'.$i.'</option>';
				}
				$goto.= '</select>';
				//$total_string = "<span class='total' a='$no_of_paginations'>(page<b>" . $cur_page . "</b> of <b>$no_of_paginations</b> )</span>";
				//$msg = $msg . "</ul>" . $goto . $total_string . "</div>";
				//$msg = $msg . "<li>".$total_string.'</li>';
				//$msg = $msg . "<li>".$goto.'</li>';
				$msg = $msg . "</ul>";
				return $msg;
		}
		else
		{
			$Msg = '<input type="hidden" id="CurrentPage" value="1">
							<div class="col-md-12 text-center" style="color:red"><strong>No Record Found</strong></div>';
			return $Msg;
		}
	}
	public static function GenerateRandomId($length)
	{
    $id_length = $length;
    $alfa = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz";
    $token = "";
    for($i = 1; $i < $id_length; $i ++) {
      @$token .= $alfa[rand(1, strlen($alfa))];
    }
    return $token;
	}
	public static function limitTextWords($content = false, $limit = false, $stripTags = false, $ellipsis = false) 
	{
    if ($content && $limit) {
      $content = ($stripTags ? strip_tags($content) : $content);
      $content = explode(' ', $content, $limit+1);
      array_pop($content);
      if ($ellipsis) {
          array_push($content, '');
      }
      $content = implode(' ', $content);
    }
    return $content;
	}
	public static function DynamicPagination($numofrecords, $count, $page, $OnClick){
		$per_page = $numofrecords;
		$previous_btn = true;
		$next_btn = true;
		$first_btn = true;
		$last_btn = true;
		$start = $page * $per_page;
		$cur_page = $page;
		$msg = "";
		$no_of_paginations = ceil($count / $per_page);
		if($count>0)
		{
			if ($cur_page >= 7) {
				$start_loop = $cur_page - 3;
				if ($no_of_paginations > $cur_page + 3)
				$end_loop = $cur_page + 3;
				else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
	    			$start_loop = $no_of_paginations - 6;
	    			$end_loop = $no_of_paginations;
				} else {
	    			$end_loop = $no_of_paginations;
				}
			} else {
				$start_loop = 1;
				if ($no_of_paginations > 7)
	    		$end_loop = 7;
				else
	    		$end_loop = $no_of_paginations;
			}
			$msg .= "<ul class='pagination pagination-outline-secondary'>";
			if ($first_btn && $cur_page > 1) {
				//$msg .= "<li class='page-item'><a onclick='$OnClick(1)' class='page-link' href='javascript:void(0)'>First</a></li>";
			} else if ($first_btn) {
				//$msg .= "<li class='page-item inactive'><a class='page-link' href='javascript:void(0)'>First</a></li>";
			}
			if ($previous_btn && $cur_page > 1) {
				$pre = $cur_page - 1;
				$msg .= "<li p='$pre' class='page-item'><a onclick='$OnClick($pre)' class='page-link' href='javascript:void(0)'>Previous</a></li>";
			} else if ($previous_btn) {
				$msg .= "<li class='page-item inactive'><a class='page-link' href='javascript:void(0)'>Previous</a></li>";
			}
			for ($i = $start_loop; $i <= $end_loop; $i++) {
				if ($cur_page == $i)
	    		$msg .= "<li p='$i' class='page-item active'><a class='page-link' href='javascript:void(0)'>{$i}</a></li>";
				else
	    		$msg .= "<li p='$i' class='page-item'><a class='page-link' onclick='$OnClick($i)' href='javascript:void(0)'>{$i}</a></li>";
				}
			    if ($next_btn && $cur_page < $no_of_paginations) {
			      $nex = $cur_page + 1;
			      $msg .= "<li class='page-item'><a onclick='$OnClick($nex)' class='page-link' href='javascript:void(0)'>Next</a></li>";
			    } else if ($next_btn) {
			      $msg .= "<li class='page-item inactive'><a class='page-link' href='javascript:void(0)'>Next</a></li>";
			    }

				if ($last_btn && $cur_page < $no_of_paginations) {
					//$msg .= "<li p='$no_of_paginations' class='page-item'><a class='page-link' href='javascript:void(0)' onclick='$OnClick($no_of_paginations)'>Last</a></li>";
				} else if ($last_btn) {
					//$msg .= "<li class='page-item inactive'><a class='page-link' href='javascript:void(0)'>Last</a></li>";
				}
				$msg = $msg . "</ul>";
				return $msg;
		}
		else
		{
			return '<div class="col-md-12 text-center" style="color:red"><strong>No Record Found</strong></div>';
		}
	}
	public static function get_client_ip(){
	  $ipaddress = '';
	  if (getenv('HTTP_CLIENT_IP'))
	    $ipaddress = getenv('HTTP_CLIENT_IP');
	  else if(getenv('HTTP_X_FORWARDED_FOR'))
	    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	  else if(getenv('HTTP_X_FORWARDED'))
	    $ipaddress = getenv('HTTP_X_FORWARDED');
	  else if(getenv('HTTP_FORWARDED_FOR'))
	    $ipaddress = getenv('HTTP_FORWARDED_FOR');
	  else if(getenv('HTTP_FORWARDED'))
	    $ipaddress = getenv('HTTP_FORWARDED');
	  else if(getenv('REMOTE_ADDR'))
	    $ipaddress = getenv('REMOTE_ADDR');
	  else
	    $ipaddress = 'UNKNOWN';
	  return $ipaddress;
	} 



	public static function SendMail($to_email, $from_email, $Cc, $Bcc, $subject, $message) { 
	    
	    $New_Line = "\n";
	    $headers = "MIME-Version: 1.0;" .$New_Line;
	    $headers .= "Content-type: text/html; charset=iso-8859-1" .$New_Line;
	    $headers .= "Content-Transfer-Encode: 7bit " .$New_Line;
	    $headers .= "From: $from_email ".$New_Line;
	    if(!empty($Cc)) {
	      $headers .= "Cc: $Cc" .$New_Line;
	    }
	    if(!empty($Bcc)) {
	      $headers .= "Bcc: $Bcc " .$New_Line;
	    }
	    $headers .= "X-Mailer: PHP " .$New_Line;
	    $headers .= "Return-Path: < $to_email > " .$New_Line;  

	    /*$data = ['message'=>$message];

	    \Mail::raw([], function($message) use($data, $to_email, $subject){
	    	$message->to($to_email);
	    	$message->subject($subject);
	    	$message->setBody($data['message'], 'text/html' );
	    });*/
	   
	    $mail_sent = @mail($to_email, $subject, $message, $headers);
	  
	    return $mail_sent;
	}
	

    public static function SendSMS($TextMessage,$SmsMobile){
		$mobile 	= urlencode($SmsMobile);
		$message 	= urlencode($TextMessage);
		$SenderID = urlencode('KBWINN');
		$username = urlencode('t2kbwinner');
		$password = urlencode('123456');
		$url = "http://sms.promotionkart.com/api/swsendSingle.asp?username=".$username."&password=".$password."&sender=".$SenderID."&sendto=91".$mobile."&message=".$message;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_scraped_page = curl_exec($ch);
		curl_close($ch);
		$data = json_encode(trim($curl_scraped_page),true);
		return $data;
  	}

  	public static function getCountryArray()
  	{
  		return ["Saudi Arabia","Afganistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bonaire","Bosnia & Herzegovina","Botswana","Brazil","British Indian Ocean Ter","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Canary Islands","Cape Verde","Cayman Islands","Central African Republic","Chad","Channel Islands","Chile","China","Christmas Island","Cocos Island","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cote DIvoire","Croatia","Cuba","Curaco","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Ter","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Great Britain","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guyana","Haiti","Hawaii","Honduras","Hong Kong","Hungary","Iceland","Indonesia","India","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea North","Korea Sout","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malaysia","Malawi","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Midway Islands","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Nambia","Nauru","Nepal","Netherland Antilles","Netherlands","Nevis","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Norway","Oman","Pakistan","Palau Island","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Phillipines","Pitcairn Island","Poland","Portugal","Puerto Rico","Qatar","Republic of Montenegro","Republic of Serbia","Reunion","Romania","Russia","Rwanda","St Barthelemy","St Eustatius","St Helena","St Kitts-Nevis","St Lucia","St Maarten","St Pierre & Miquelon","St Vincent & Grenadines","Saipan","Samoa","Samoa American","San Marino","Sao Tome & Principe","Saudi Arabia","Senegal","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Tahiti","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos Is","Tuvalu","Uganda","United Kingdom","Ukraine","United Arab Erimates","United States of America","Uraguay","Uzbekistan","Vanuatu","Vatican City State","Venezuela","Vietnam","Virgin Islands (Brit)","Virgin Islands (USA)","Wake Island","Wallis & Futana Is","Yemen","Zaire","Zambia","Zimbabwe"];
  	}

}