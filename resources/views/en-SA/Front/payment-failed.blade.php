@extends('en-SA.layouts.default')
@section('content')


<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h2>Payment Failed</h2>
                <br>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mb-5" style="width: 400px;text-align: center;box-shadow: none;max-width: 100%;margin: 28px auto 0;font-size: 35px;border: 0;">
                <div class="alert alert-danger mb-0 pb-5">
                        <span class="card__success" style="position: absolute;top: -50px;left: 145px;width: 100px;height: 100px;border-radius: 100%;background-color: #60c878;border: 5px solid #fff;padding: 20px;color: #fff;">
                            <i class="fa fa-check"></i>
                        </span>
                        <h1 style="color: #000;margin: 68px 0 27px;font-size: 25px;"> <br><span style="font-size: 16px;">{{ __('home.Your payment is Not successfully Processed, TRY AGAIN!!!') }}</span></h1>
                        <a href="{{ route('Home') }}}" class="btn btn-danger text-white">{{ __('home.Back to Payment Page') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
  
@endsection
@section('javascript')
@endsection