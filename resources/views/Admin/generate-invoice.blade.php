<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Order Invoice</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
  body,
  table,
  td,
  a {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
  }
  table,
  td {
    mso-table-rspace: 0pt;
    mso-table-lspace: 0pt;
  }
  img {
    -ms-interpolation-mode: bicubic;
  }
  a[x-apple-data-detectors] {
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
    text-decoration: none !important;
  }
  div[style*="margin: 16px 0;"] {
    margin: 0 !important;
  }
  body {
    width: 100% !important;
    height: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
  }
  table {
    border-collapse: collapse !important;
  }
  a {
    color: #1a82e2;
  }
  img {
    height: auto;
    line-height: 100%;
    text-decoration: none;
    border: 0;
    outline: none;
  }
  </style>

</head>
<body style="background-color: #ffffff;">
    
   <div class="logo ">
   {{-- <center><a href="{{route("Home")}}"><img src="{{asset('/images/logo-01.png')}}" alt="Cure Root - The Power of Ayurveda" title="Cure Root - The Power of Ayurveda" width="150"></a></center> --}}
   <center><a href="{{route("Home")}}">Saga Bags</a><button style="float:right;" onclick="window.print();" class="noPrint">
Print Page
</button></center>
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">

    <tr>
      <td align="left" bgcolor="#ffffff">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="left" valign="top" style="padding: 5px 5px;">
            <b>ORDER SUMMARY.</b><br/><br/> 

            <?php 
               
                 if(isset($orderData))
                 {
 

          

                 }
                   ?>  
                    
            Order Date: {{$orderData->txn_date}}<br/><br/>
             Order Recived By: {{$orderData->billing_name}},
             <br/>
              <br/>
              Transaction id:-  {{ $orderData->transaction_id }}.<br/><br/>
              Order id:-  {{ $orderData->order_id }}.<br/><br/>
              Payment Type:-  {{ $orderData->payment_type }}.<br/><br/>
              Order Type:-  {{ $orderData->payment_mode	}}.<br/><br/>

              Customer Mobile:- {{$orderData->billing_tel}}
             <br/>
             <br/>
             <?php 
       
             if(isset($orderData->billing_address))
             {

           $address=$orderData->billing_address; 
          $cus_address = json_decode($address); 
                 
               ?>  
                
               <b>Customer Address:-</b><br/>
              <br/>Country:- {{$cus_address->country}}<br/><br/>
              Street Number:- {{$cus_address->address}}<br/><br/>
              City:- {{$cus_address->city}}<br/><br/>
              State:- {{$cus_address->state}}<br/><br/>
              Pin Code:- {{$cus_address->postcode}}
             
              <br/>
              <br/>  
                
                
                 
              <?php   
             }
             else
             {

              $address=$billingAddress->shipping_address; 
          $cus_address = json_decode($address); 
               ?>  
              
               <b>Customer Address:-</b><br/>
              <br/>Country:- {{@$cus_address->country}}<br/><br/>
              Street Number:- {{@$cus_address->address}}<br/><br/>
              City:- {{@$cus_address->city}}<br/><br/>
              State:- {{@$cus_address->state}}<br/><br/>
              Pin Code:- {{@$cus_address->postcode}}
             
              <br/>
              <br/>
              
              
              
                 
             <?php    
             }
            
             ?>
            
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left" bgcolor="#ffffff">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
      <br>
        
     <table style=" font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">
  <tr>
    <th style="border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;">#</th>   
  
  <th style="border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;">Item</th>
     <th style="border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;">Qty</th>
   <th style="border: 1px solid #dddddd;
   text-align: left;
   padding: 8px;">Size</th>
     <th style="border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;">Unit Rs.
</th>
 <th style="border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;">Price
</th>
 <th style="border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;">Total Price
</th>

    
  </tr>
 
      <?php
      $sum=0;
      $i=1;
      
         $orderDetails=$orderData->billing_order_details; 
          $orderDetailsArray = json_decode($orderDetails); 
          
         
         
        foreach($orderDetailsArray as $item){  
        
         $productCtegoryDetails = DB::table('products')->select('category_id')->where('id','=',$item->id)->first();
         $GstOnProduct = DB::table('category')->select('gst')->where('id','=',$productCtegoryDetails->category_id)->first();
            $gstAmount = ($GstOnProduct->gst/100)*($item->price*$item->quantity);
		      	$ProductPriceWithGst = ($item->price*$item->quantity)+$gstAmount;
            $totalProductPriceWithGst[] =  $ProductPriceWithGst;
            $TotalGst[] =  $GstOnProduct->gst;
            
     
      ?>
<tr>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$i}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$item->name}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$item->quantity}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{@$item->size}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$item->price}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$item->quantity*$item->price}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$ProductPriceWithGst}}</td>
    
</tr>
   <?php
  $i++;
        }
      
       
      ?>
     
      <tr>
        <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">SUB TOTAL:</td>
       
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderData->txn_amount}}</td>

</tr>


   <?php
          
        if(!empty($orderData->billing_address))
        {
          
             
    ?>
           
                <tr>
        <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">DISCOUNT({{$orderDetailsArray[0]->Discount}}%)</td>
       
     
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderDetailsArray[0]->discountAmount}}</td>

</tr>
<tr>
        <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >ORDER TOTAL:</td>
       
        
       
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderDetailsArray[0]->totalAmountForPaidAfterDiscount}}</td>

</tr>
<tr>
        <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >VAT(15%):</td>
       
        
       
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderData->vat_amt}}</td>

</tr>
<tr>
        <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >You Pay :</td>
       
        
       
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderDetailsArray[0]->totalAmountForPaidAfterDiscountAndGST}}</td>

</tr>      
        <?php    
        }else
        {
            ?>
            
                 <tr>
        <td  colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >DISCOUNT(0%)</td>
      
     
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">SAR .0</td>

</tr>
<tr>
        <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >:</td>
       
        
       
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">SAR .{{$sum}}</td>

</tr>
            
            
          <?php  
        }
        ?>
        
     


 
 
</table>

        <tr><br/>
            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;"><br>Warm regards, <br>
              <strong><a onclick="window.print()" >Saga Bags</a></strong><br>
              <br>
          </td>
        </tr>
      
      </td>
    </tr>
  </table>
  <!--  <button onclick="window.print()">         -->
  <!--    print-->
  <!--</button>  -->
    </table>
        
   
</body>
</html>