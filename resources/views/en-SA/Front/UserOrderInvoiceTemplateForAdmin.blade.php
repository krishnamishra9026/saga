<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    /*body,
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
    }*/
  </style>

</head>
<body style="background-color: #EFF2F7;padding: 25px 0 !important;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">

    <tr>
      <td align="left">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;margin: auto;background: #fff;">
          <tr>
            <td align="left" valign="top" style="padding: 20px;">
             Hi {{$billing_name}},
             <br/>
             <br/>
             Your payment is successful. Your transaction id is 
             <h4 style="margin: 20px 0;">{{$txn_id}}.</h4>

             <b>Need help? </b>
             <br>
             If there is anything else you would like to know or make amendment to your order,
             <br/>
             Please Call:- <b>02086927236</b>
             <br/>
             <br/>
             <br/>
             <b>ORDER SUMMARY.</b>
             <br/>
             <br/>
             Order Ref: {{$order_id}}
             <br/>

             Payment Type: Card Paid
             <br/>
             Order Date: {{$txn_date}}
             <br/>
             Delivery Date: {{$txn_date}}
             <br/>
             Delivery Time: {{$txn_date}}
             <br/>
           </td>
         </tr>
       </table>
     </td>
   </tr>
   <tr>

    <td align="left" style="padding: 10px;">
      <!-- <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;margin: auto;background: #fff;">
        <br> -->
        
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
            padding: 8px;">Unit £
          </th>
          <th style="border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;">Price
        </th>

      </tr>
 
      <?php
      $i = 1;
      foreach($cartCollection as $items){
          
      
      ?>
      <tr>
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{ $i }}</td>
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{ $items->name }}</td>
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{ $items->quantity }}</td>
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">£{{ $items->price }}</td>
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">£{{ $items->price*$items->quantity  }}</td>
      </tr>
   <?php
   $i++;
      }
      ?>

      <tr>
        <td colspan="4" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">ORDER TOTAL:</td>
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">£ {{ session()->get('final_amount')}}</td>

      </tr>
</table>

    <tr>
      <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;text-align: center;"><br>Warm regards, <br>
        <strong>The Saka Maka</strong><br>
        <br>
      </td>
    </tr>

  </td>
</tr>
</table>

</table>


</body>
</html>
// <?php
// exit();
// ?>
