@extends('en-SA.layouts.default')
@section('content')

<section class="inner_banner" style="background: url('../images/about-page.jpg') no-repeat;background-position: center;background-size: cover;background-position: 50% 92%;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="vl-filter-text-box">
                    <h1>Past orders</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="manage_address">
  <div class="container">
    <div class="row">      
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="user_details mb-5">
          <h2>{{ $UserDetails->first_name.' '.$UserDetails->last_name }}</h2>
          <ul class="list-unstyled user-pro">
           <li> <span>{{ $UserDetails->email }}</span></li>
                <li>{{ $UserDetails->mobile }}</li>
          </ul>
        </div>
      </div>
     

      <div class="col-lg-3 col-md-3 col-sm-12">
        <div class="nav flex-column nav-pills pro_nav mb-4">
         <a class="nav-link @if(@$Menu=='Addresses') {{'active'}} @endif" href="{{route('address')}}"><i class="fa fa-map-marker" aria-hidden="true"></i> Addresses</a>

          <a class="nav-link @if(@$Menu=='Orders') {{'active'}} @endif" href="{{route('orders')}}"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Orders</a>
        </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-12">
     
        <div class="card p-3 mb-4 past_order_list">          
       
            <div class="col-lg-12 col-md-12 col-12">
              <h3>Your Details</h3>
               <ul class="list-unstyled user-pro">

            <li><b>Your Name:-</b> {{ $UserDetails->first_name.' '.$UserDetails->last_name }}</li>
            <li><b>Phone number:-</b> {{ $UserDetails->mobile }}</li>
            <li><b>Mail ID:-    </b>  {{ $UserDetails->email }}</li>

          </ul>
                 <a href="{{ route('address')  }}" class="nav-link active" style="float: right;background: #000;border-radius: 15px;">View Details</a>
          
          </div>
        </div>
        
     </div>
     
        <div class="col-lg-3 col-md-3 col-sm-12 text-right">
       
      </div>
      
          <div class="col-lg-9 col-md-9 col-sm-12">
        <h4>Past orders</h4>
        <div class="card p-3 mb-4 past_order_list">          
          <div class="row">
            <div class="col-lg-2 col-md-3 col-3">
              <img src="{{ asset('images/menu/small.jpg')}}" class="img-fluid"> 
            </div>
            <div class="col-lg-8 col-md-7 col-9">
              <h3>Product Name</h3>
              <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
              <p class="mb-3"><b>Total amount:  <span class="text-primary">$20</span> </b></p>
              <a href="javascript:void(0);" class="btn btn-primary2 btn-sm">View Details</a>
            </div>
          </div>
        </div>
        
     </div>
   </div>
 </div>
</section>

<div class="modal fade" id="EditProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="login-form">
          <span id="Login_msg"></span>
          <form action="" method="post" id="UpdateProfile" name="FormLogin">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="group-input mb-4">
              <label for="name">Name</label>
              <input type="text" id="name" name="name" value="{{ $UserDetails->first_name.' '.$UserDetails->last_name }}">
            </div>
            <div class="">
              <input type="submit" id="UpdateSubmitBtn" class="btn btn-primary w-100" value="Update">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('javascript')
@endsection

