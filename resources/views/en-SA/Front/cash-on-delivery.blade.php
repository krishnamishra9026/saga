@extends('en-SA.layouts.default')
@section('content')

<!DOCTYPE html>


<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h2>Your Order Status</h2>
                <br>
            </div>
        </div>
    </div>

    <div class="card" style="background-color: #fff;width: 400px;border-radius: 5px;box-sizing: border-box;padding: 80px 30px 25px 30px;text-align: center;position: relative;box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);max-width: 100%;margin: 28px auto 0;font-size: 35px;padding: 20px;">

<p>Your Order Is Successfull and You order Id is {{session('order_id')}} </p>

                                 <a href="" class="btn btn-primary  w-100">Continue Order...</a> 

    </div>

 
@endsection