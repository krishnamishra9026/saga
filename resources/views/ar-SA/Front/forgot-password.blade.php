@extends('layouts.default')
@section('content')

<section class="inner_banner" style="background: url('images/slide/banner3.jpg') no-repeat;background-position: center;background-size: cover;background-position: 50% 30%;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="vl-filter-text-box">
                    <h1>Forgot Password</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="register-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <!-- <p>Please enter your email address and we will send your password by email immediately.</p> -->
                <span id="Login_msg"></span>
                <form action="javascript:void(0)" method="post" id="FormForgot" name="FormForgot">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="margin-b-40">
                    <div class="form_main mb-4">
                        <label>Enter email*</label>
                        <input class="form-control" type="email" name="ForgotEmail" name="ForgotEmail">
                    </div>
                    <div class="form_main mt-4">
                        <input type="submit" id="ForgotSubmitBtn" name="Submit" class="btn btn-primary w-100" value="Submit">
                    </div>
                </div>
                    <hr class="w-100 divider_line text-center">
                    <div class="text-center">If you have an account? <a href="{{route('Register')}}" class="text-primary" data-toggle="modal" data-target="#loginform"><u>Log In</u></a></div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
@endsection