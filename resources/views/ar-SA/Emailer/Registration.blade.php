<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Registration</title>
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
<body style="background-color: #e9ecef;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%">

    <tr>
      <td align="center" bgcolor="#e9ecef">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="center" valign="top" style="padding: 5px 5px;">
              
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" bgcolor="#e9ecef">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Dear {{$Name}},
              <br/><br/><b>Congratulations.</b> You have successfully registered with the following details:.
            </td>
          </tr>
          <tr>
            <td height="53" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
              Your Email Id: <b>{{ $Email }}</b><br>
              Your Password: <b>{{ $Password }}</b>
            </td>
        </tr> <br> <br>
        <tr>
            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;"><br>Warm regards, <br>
              <strong>The Saka Maka</strong><br>
              <br>
          </td>
        </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>