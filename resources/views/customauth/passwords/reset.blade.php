@extends('en-SA.layouts.default')
@section('content')

<section class="wish_list_page mt-4 pt-5 pb-5">
	<div class="container-fluid">
		<h2 class="section-title position-relative text-center text-uppercase mx-xl-5 mb-4">
			<span class="bg-secondary pr-3">Forget Password</span>
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
                <form method="POST" action="{{ route('postResetPassword') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" id="token" value="{{ $token }}">
                    <div class="form-group">
                        <label>@if(session('locale')=='en')  Email address @else   البريد الاكتروني      @endif<sup class="text-danger">*</sup></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="@if(session('locale')=='en')  Enter Your Email Id  @else   ادخل بريدك الالكتروني   @endif" onkeyup="HideErr('email_msg')" required>
                        <span id="email_msg"></span>
                      </div>
                      <div class="form-group">
                        <label>@if(session('locale')=='en')  Password @else   البريد الاكتروني      @endif<sup class="text-danger">*</sup></label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter New Password" required>
                        <span id="email_msg"></span>
                      </div>
                      <div class="form-group">
                        <label>@if(session('locale')=='en') Confirm Password @else   البريد الاكتروني      @endif<sup class="text-danger">*</sup>( <span id='message'></span>)</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter New Password Again" required>
                        <span id="email_msg"></span>
                      </div>
                   <div class="form-group row mb-0">
                     <div class="col-md-6 offset-md-4">
                            <button type="submit" value="message" class="btn btn-primary">
                               Set new password
                            </button>
                        </div>
                    </div>
                    
                </form>
		      	</div>
    		</div>
  	</div>
</section>

@endsection
@section('javascript')

<script>
    $('#password, #confirm_password').on('keyup', function () {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Password and confirm password are same').css('color', 'green');
  } else 
    $('#message').html('Password and confirm password are not same').css('color', 'red');
});

</script>

@endsection