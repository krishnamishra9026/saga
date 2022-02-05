@extends('ar-SA.layouts.default')
@section('content')



<section class="wish_list_page mt-4 pt-5 pb-5 login_page">

	<div class="container-fluid">

		<h2 class="section-title position-relative text-center text-uppercase mx-xl-5 mb-4">

			<span class="bg-secondary pr-3">تسجيل الدخول</span>

		</h2>

		<div class="row px-xl-5 align-items-center justify-content-center">

			<div class="col-md-6">

				<span id="Return_msg">
                  <?php
                  if(Session::has('message')){
                    echo Session::get('message');
                  }
                  ?>
                </span>	

				<form class="form" action="{{ route('Userlogin') }}"  method="POST"  id="loginForm">
		        {{ csrf_field() }}
		          <div class="form-group">
		            <label>@if(session('locale')=='en')  Email address @else   البريد الاكتروني      @endif   <sup class="text-danger">*</sup></label>
		            <input type="email" class="form-control" name="email" id="email" placeholder="@if(session('locale')=='en')  Enter Your Email Id  @else   ادخل بريدك الالكتروني   @endif" onkeyup="HideErr('email_msg')">
		            <span id="email_msg"></span>
		          </div>

		          <div class="form-group">
		            <label>@if(session('locale')=='en')  Password  @else     كلمة المرور     @endif <sup class="text-danger">*</sup></label>
		            <input type="password" class="form-control" name="password" id="password" placeholder="@if(session('locale')=='en')  Password  @else  كلمة المرور   @endif" onkeyup="HideErr('password_msg')">
		            <span id="password_msg"></span>
		          </div>   

		          <button type="button" class="btn w-100 btn-primary" id="login">@if(session('locale')=='en')  Login  @else الدخول   @endif</button>
		          <p class="text-center mt-3"><a href="{{ route('ForgotPassword') }}" class="text-dark">@if(session('locale')=='en')  Forgot your password?  @else  نسيت كلمة المرور    @endif</a></p>
		          <a href="{{ route('Register') }}" class="btn btn-outline-warning w-100">@if(session('locale')=='en')  Create an Account  @else  انشاء حساب جديد   @endif</a>
		        </form>

			</div>

		</div>

	</div>

</section>



@endsection
@section('javascript')

<script>
    $("#login").click(function(){

    var flag=1;
    var email = $('#email').val();
    var password = $('#password').val();
    if(email == '')
        {   
          $("#email_msg").css('color','red');
          $("#email_msg").show();
          $("#email_msg").html('Please Enter Email');
          flag=0;
        }

        if(password == '')
        {
          $("#password_msg").css('color','red');
          $("#password_msg").show();
          $("#password_msg").html('Please Enter Password');
          flag=0;
        }


        if(flag==1)
        {
        $( "#loginForm" ).submit();
        }
    });
function HideErr(id)
{ 
  $("#"+id).hide();
}
</script>

@endsection