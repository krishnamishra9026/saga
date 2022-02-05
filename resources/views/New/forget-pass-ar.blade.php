@extends('ar-SA.layouts.default')
@section('content')


<section class="wish_list_page mt-4 pt-5 pb-5">

	<div class="container-fluid">

		<h2 class="section-title position-relative text-center text-uppercase mx-xl-5 mb-4">

			<span class="bg-secondary pr-3">@if(session('locale')=='en') Forget Password @else   نسيت كلمة المرور     @endif</span>

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
                <form method="POST" action="{{ route('postforgetPassword') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>@if(session('locale')=='en')  Email address @else   البريد الاكتروني      @endif<sup class="text-danger">*</sup></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="@if(session('locale')=='en')  Enter Your Email Id  @else   ادخل بريدك الالكتروني   @endif" onkeyup="HideErr('email_msg')">
                        <span id="email_msg"></span>
                      </div>

               <div class="form-group row mb-0">
                     <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                @if(session('locale')=='en') Send Password Reset Link @else   إرسال رابط إعادة تعيين كلمة السر    @endif
                                
                            </button>
                        </div>
                    </div>
                </form>
			</div>

		</div>

	</div>

</section>




@endsection