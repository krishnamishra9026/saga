  <html> 
     <head> 
     <meta charset="utf-8"> 
     <meta http-equiv="x-ua-compatible" content="ie=edge"> 
     <title>Registration</title> 
     <meta name="viewport" content="width=device-width, initial-scale=1"> 
    
    	
     </head> 
     <body style="background-color: #EFF2F7;padding: 25px 0 !important;"> 
     <div class="logo "> 
     <center><a href="'.route("Home").'"><img src="'.asset('/images/logo-01.png').'" alt="Cure Root - The Power of Ayurveda" title="Cure Root - The Power of Ayurveda" width="150"></a></center> 
     </div> 
     <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
     <tr> 
     <td align="left"> 
     <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;margin: auto;background: #fff;"> 
     <tr> 
     <td align="left" valign="top" style="padding: 20px;"> 
   
     <b>ORDER SUMMARY.</b> 
     <br/> 
     <br/> 

     Order Date: '.$orderDetails["txn_date"];
     <br/> 
     <br/> 
     Ordered By:'.$orderDetails["billing_name"];
     <br/> 
     <br/> 
     Payment Type: '.$orderDetails["payment_type"];
     <br/> 
     <br/> 

     Delivery Date: '.$orderDetails["txn_date"];
     <br/> 
      <br/> 
     Delivery Time: '.$orderDetails["txn_date"];
      <br/> 
      </td> 
     <b>Customer Address:-</b> 
     <br/> 
     <br/> 
 

 
 if(!empty($orderDetails['billing_address'])){
  $address=$orderDetails['billing_address']; 
    $cus_address = json_decode($address);   
     
     
    <b>Country:- '.$cus_address->country.'</b> 
     <br/> 
     <br/>       
     <b> Street Number:- '.$cus_address->street_Address.'</b> 
     <br/> 
     <br/>   
     <b> City:- '.$cus_address->city.'</b> 
     <br/> 
     <br/>   
     <b>State:- '.$cus_address->state.'</b> 
     <br/> 
     <br/>   
     <b>Post Code:- '.$cus_address->pin_code.'</b> 
     <br/> 
     <br/>     
     
     
     
     
 }else{
     
  
    <b>Country:- </b> 
     <br/> 
     <br/>       
     <b> Street Number:- </b> 
     <br/> 
     <br/>   
     <b> City:- </b> 
     <br/> 
     <br/>   
     <b>State:- </b> 
     <br/> 
     <br/>   
     <b>Post Code:- </b> 
     <br/> 
     <br/>  
  
     
     
     
 }

     </tr> 
     </table> 
     </td> 
     </tr> 
     <tr> 
   
     <td align="left" style="padding: 10px;"> 
          
     <table style=" font-family: arial, sans-serif;border-collapse: collapse;width: 600px;max-width: 100%;margin: auto;background: #fff;"> 
     <tr> 
     <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">#</th>   
    
                <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">ITEM</th>
                <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">QTY</th>
                <th style="border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;">Unit Rs.
              </th>
              <th style="border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;">Price
            </th>
    
          </tr> 
          $i = 1;
          foreach($cartItemArray as $items){
      
           <tr> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$i.'</td> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$items['name'].'</td> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">'.$items['quantity'].'</td> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.$items['price'].'</td> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.$items['quantity']*$items['price'].'</td> 
           </tr> 
      
       $i++;
          }
        <tr> 
          

           <td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">SUB TOTAL</td> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.session('totalAmountForPaid').'</td> 
    
           </tr> 
     <tr> 
          
           <td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">DISCOUNT('.session('Discount').'%)</td> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.session('discountAmount').'</td> 
    
           </tr> 
           <tr> 
           <td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">ORDER TOTAL:</td> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.session('totalAmountForPaidAfterDiscount').'</td> 
           </tr> 

           <tr> 
           <td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">GST:</td> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.$gst->GST.'</td> 
           </tr> 

           <tr> 
           <td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">You Pay:</td> 
           <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Rs.'.session('totalAmountForPaidAfterDiscountAndGST').'</td> 
           </tr> 

           </table>
    
        <tr>
          <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;text-align: center;"><br>Warm regards, <br>
            <strong>Cure Root</strong><br>
            <br>
          </td>
        </tr>
    
      </td>
    </tr>
    </table>
    
    </table>
    
    
    </body>
    </html> 