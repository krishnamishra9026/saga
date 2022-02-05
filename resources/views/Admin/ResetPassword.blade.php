<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>{{$Title}}</title>
  
  <link rel="icon" href="{{ asset('public')}}/favicon.png" type="image/x-icon">
  <link href="{{ asset('public/Admin')}}/assets/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="{{ asset('public/Admin')}}/assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('public/Admin')}}/assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('public/Admin')}}/assets/css/app-style.css" rel="stylesheet"/>
  <link href="{{ asset('public/Admin')}}/assets/css/local.css" rel="stylesheet"/>
  
</head>
<body>
  
  <input type="hidden" name="url" id="url" value='{{url("Admin/")}}'>
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

  <div id="wrapper">
    <div class="card-authentication1 mx-auto my-5 animated fadeInDown">
      <div class="card-group">
        <div class="card mb-0 bg-dark">
          <div class="card-body">
            <div class="card-content p-3">
              <div class="text-center">
                <img src="{{ asset('public/Front/upload/logo.png')}}"/>
              </div>
              <div class="card-title text-uppercase text-center text-white py-2">Reset Password</div>
              <span id="Reset_msg"></span>
              <form class="color-form" id="ResetForm" name="ResetForm">
                <div class="form-group">
                  <div class="position-relative has-icon-left">
                    <label for="email" class="sr-only">Email Address</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                    <div class="form-control-position">
                      <i class="icon-envelope-open"></i>
                    </div>
                  </div>
                </div>
                <button type="submit" id="ResetBtn" class="btn btn-success btn-block">Reset Password</button>
                <div class="clearfix"></div>
                <div class="text-center pt-3">
                  <hr class="border-secondary">
                  <p class="text-white">Return to the <a href="{{route('Login')}}"> Sign In</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
  </div>
  <script src="{{ asset('public/Admin')}}/assets/js/jquery.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/js/popper.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/js/bootstrap.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/js/waves.js"></script>
  
  <script src="{{ asset('public/Admin')}}/assets/js/jquery.validate.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/js/additional-methods.min.js"></script>  
  <script src="{{ asset('public/Admin')}}/assets/validation/ResetPassword.js"></script> 

</body>
</html>