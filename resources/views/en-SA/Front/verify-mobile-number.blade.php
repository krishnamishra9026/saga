@extends('layouts.default')
@section('content')

<section class="inner_banner" style="background: url('images/slide/banner3.jpg') no-repeat;background-position: center;background-size: cover;background-position: 50% 30%;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="vl-filter-text-box">
                    <h1>Sign Up</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="register-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <p>Please fill the below fields and then click to register button</p>
                <span id="Register_msg"></span>
                <form action="javascript:void(0)" method="post" id="FormRegister" name="FormRegister" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="margin-b-40">
                    <div class="form_main mb-4">
                        <label>Enter your name *</label>
                        <input type="text" class="form-control" name="name" id="name" required="">
                    </div>
                    <div class="form_main mb-4">
                        <label for="pass">Enter your email *</label>
                        <input  type="email" class="form-control" name="email" id="email" required="">
                    </div>
                      <div class="form_main mb-4">
                        <label for="pass">Enter your phone number *</label>
                        <input  type="number" class="form-control" maxlength="10" name="mobile" id="mobile" required="">
                    </div>
                    <div class="form_main mb-4">
                        <label for="pass">Enter password *</label>
                        <input  type="password" class="form-control" name="password" id="password" required="">
                    </div>
                    <div class="form_main mb-4">
                        <label for="pass">Re-enter Password *</label>
                        <input  type="password" class="form-control" name="password_confirm" id="password_confirm" required="">
                    </div>
                     <div class="form_main mb-4">
              <label for="country">Country/Region</label>
              <input type="text" class="form-control"  id="country" name="country" value=" ">
            </div>
              <div class="form_main mb-4">
              <label for="name">Street number</label>
              <input type="text" class="form-control" id="street_number" name="street_number" value=" ">
            </div>
              <div class="form_main mb-4">
              <label for="city">City</label>
              <input type="text" class="form-control" id="city" name="city" value=" ">
            </div>
              <div class="form_main mb-4">
              <label for="state">State/Province/Region</label>
              <input type="text" class="form-control"  id="state" name="state" value=" ">
            </div>

            <div class="form_main mb-4">
              <label for="pin_code">PIN Code</label>
              <input type="text"  class="form-control" id="pin_code" name="pin_code" value=" ">
            </div>
                    <div class="form_main mt-4">
                        <input type="submit" id="RegisterSubmitBtn" name="SignUp" class="btn btn-primary w-100" value="Sign Up">
                    </div>
                </div>
                    <hr class="w-100 divider_line text-center">
                    <div class="text-center">If you have an account? <a href="sign-up.php" class="text-primary" data-toggle="modal" data-target="#loginform">Log In</a></div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
@endsection