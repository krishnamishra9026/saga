@extends('ar-SA.layouts.default')
@section('content')

<section class="inner_banner" style="background: url('images/about-page.jpg') no-repeat;background-position: center;background-size: cover;background-position: 50% 92%;">
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
          <a class="nav-link" href="{{ route('address') }}">Address</a>
          <a class="nav-link active" href="{{ route('orders') }}">Orders</a>
         
        </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <h4>Past orders</h4>
        
        <div class="card p-3 mb-4 past_order_list">          
          <div class="row">
            <div class="col-lg-2 col-md-3 col-3">
              <img src="images/menu/small.jpg" class="img-fluid"> 
            </div>
            <div class="col-lg-8 col-md-7 col-9">
              <h3>Product Name</h3>
              <p class="m-0">(Product Description)Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
              <p class="m-0"><b>Total amount:  <span>$20</span> </b></p>
			   <p class="m-0	"><b>Date:  <span>5/12/2021</span> </b></p>
            </div>
          </div>
        </div> <!-- // item -->
        <div class="card p-3 mb-4 past_order_list">          
          <div class="row">
            <div class="col-lg-2 col-md-3 col-3">
              <img src="images/menu/small.jpg" class="img-fluid"> 
            </div>
            <div class="col-lg-8 col-md-7 col-9">
              <h3>Product Name</h3>
              <p class="m-0">(Product Description)Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
               <p class="m-0"><b>Total amount:  <span>$20</span> </b></p>
			   <p class="m-0	"><b>Date:  <span>5/12/2021</span> </b></p>
            </div>
          </div>
        </div> <!-- // item -->
        <div class="card p-3 mb-4 past_order_list">          
          <div class="row">
            <div class="col-lg-2 col-md-3 col-3">
              <img src="images/menu/small.jpg" class="img-fluid"> 
            </div>
            <div class="col-lg-8 col-md-7 col-9">
              <h3>Product Name</h3>
              <p class="m-0">(Product Description)Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <p class="m-0"><b>Total amount:  <span>$20</span> </b></p>
			   <p class="m-0	"><b>Date:  <span>5/12/2021</span> </b></p>
            </div>
          </div>
        </div> <!-- // item -->


     </div>

   </div>
 </div>
</section>

@endsection
@section('javascript')
@endsection