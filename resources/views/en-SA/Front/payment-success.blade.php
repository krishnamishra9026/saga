@extends('en-SA.layouts.default')
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h2>Payment Status</h2>
                <br>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mb-5" style="width: 400px;text-align: center;box-shadow: none;max-width: 100%;margin: 28px auto 0;font-size: 35px;border: 0;">
                <div class="alert alert-success mb-0 pb-5">
                        <span class="card__success" style="position: absolute;top: -50px;left: 145px;width: 100px;height: 100px;border-radius: 100%;background-color: #60c878;border: 5px solid #fff;padding: 20px;color: #fff;">
                            <i class="fa fa-check"></i>
                        </span>
                        <h2 style="text-align: center;margin-top: 30px;" >Transaction Details</h2>
                        <table class="table" style="margin-top: 10px;">
                            <thead>
                              <tr>
                                
                                <td scope="col" style="font-size: medium;">Amount</td>
                                <td scope="col" style="font-size: medium;">{{ $data['order']['currency'] }} {{ $data['order']['amount'] }}</td>
                                
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                               
                                <td scope="col" style="font-size: medium;">Status</td>
                                <td scope="col" style="font-size: medium;">{{ $data['order']['status']['text']}}</td>
                             
                              </tr>
                              <tr>

                                <td scope="col" style="font-size: medium;">Transaction ID</td>
                                <td scope="col" style="font-size: medium;">{{ $data['order']['transaction']['ref'] }}</td>
                               
                              </tr>
                              <tr>
                                <td scope="col" style="font-size: medium;">Payment Method</td>
                                <td scope="col" style="font-size: medium;">{{ $data['order']['paymethod'] }}</td>
                               
                              </tr>
                              <tr>
                                <td scope="col" style="font-size: medium;">Customer Name</td>
                                <td scope="col" style="font-size: medium;">{{ $data['order']['customer']['name']['forenames'].' '.$data['order']['customer']['name']['surname'] }}</td>
                               
                              </tr>
                              <tr>
                                <td scope="col" style="font-size: medium;">Customer Email</td>
                                <td scope="col" style="font-size: medium;">{{ $data['order']['customer']['email'] }}</td>
                               
                              </tr>
                            </tbody>
                          </table>
                        <h1 style="color: #000;margin: 20px 0 27px;font-size: 25px;"> <br><span style="font-size: 16px;">{{ __('Payment has been successfully processed') }}</span></h1>
                        <a href="{{route('Home')}}" class="btn btn-success text-white">{{ __('home.Continue shopping') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
  
@endsection
@section('javascript')
@endsection
