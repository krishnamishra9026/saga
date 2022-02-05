    <html>  
  <head>  
  <meta charset="utf-8">  
  <meta http-equiv="x-ua-compatible" content="ie=edge">  
  <title>Recover Password</title>  
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  </head>  
  <body >  
    <table border="0" cellpadding="0" cellspacing="0" width="100%">  

      <tr>  
        <td align="center" >  
         <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">  
            <tr>  
              <td align="center" valign="top" style="padding: 5px 5px;">  
              
              </td>  
            </tr>  
          </table>  
        </td>  
      </tr>  
      <tr>  
        <td align="center" >  
         <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">  
            <tr>  
              <td >Dear {{$EmailData["first_name"]}}<span>{{$EmailData["last_name"]}},  
                <br/><br/><b>Congratulations.</b> You have successfully registered with the following details:.  
             </td>  
            </tr>  
            <tr>  
              <td height="53">  
                Your Email Id: <b>{{$EmailData["Email"]}}</b><br>  
                Your Password: <b>{{$EmailData["Password"]}}</b>  
              </td>  
          </tr> <br> <br>  
         <tr>  
             <td ><br>Warm regards, <br>  
                <strong>Saga Bags</strong><br>  
                <br>  
            </td>  
          </tr>  
          </table>  
       </td>  
      </tr>  
    </table>  
  </body>
</html>  



