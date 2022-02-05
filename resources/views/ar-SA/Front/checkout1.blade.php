@extends('layouts.default')
@section('content')

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->

<section class="inner_banner" style="background: url('images/bg_3.jpg') no-repeat;background-position: center;background-size: cover;background-position: 50% 90%;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="vl-filter-text-box">
                    <h1>Checkout</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="checkout-section spad">
        <div class="container">
            <form name="frm" action="{{route('paymentHandler')}}"  onSubmit="return checkUserPaymentModeForDelivery();"  class="checkout-form" method="post">
            <input type="hidden" value="{{ session('payment_mode') }}" id="payment_mode" name="payment_mode">
            <input type="hidden" value="{{ count($user) }}" id="userAddressCountForPaymentMode" name="address_count">

                <div class="row">                    
                    <!-- <div class="col-lg-12">
                        <div class="checkout-content">
                            <a href="#" class="primary-btn2">Click Here To Login</a>
                        </div>
                    </div> -->
                    <div class="col-lg-8">
                               <span id="Return_msg">
                <?php
                if(Session::has('message')){
                  echo Session::get('message');
                }
                ?>
              </span>


                        <!--<h4 class="mb-4">Biiling Details</h4>-->
                        <!--<p class="bg-dark p-4 text-white">Free delivery in 2 mile radius.</p>-->
                        
                        <div class="row">
                                            <?php
                foreach ($user as $address)
                {

        ?>                              <div class="col-lg-6 col-md-6 col-sm-12 active">  
            <div class="card p-3 mb-4">  
              <ul class="list-unstyled">  
                <li> 
                <?php
                
                // print_r($address->add_address_times);
                // exit();
                if($address->user_address_status == 'selected' && $address->add_address_times == 1 )
                {
                ?>
                    <div class="activedivaddress text-success"><i class="fas fa-check"></i></div>
                 <?php
                }
                ?>
                  <div class="icon"><i class="fas fa-home"></i></div>  
                  <h3>{{ucfirst($address->address_type)}}</h3>  
                  <p class="m-0">{{$address->address->street_number}} ,{{$address->address->state}} ,{{$address->address->city}},{{$address->address->country}},{{$address->address->post_code}}</p>  
                </li>  
                <li class="mt-3">  

                  <a onclick ="addAddressForCheckout({{$address->users_address_id}})"   class="btn btn-primary btn-sm">Deliver to this Address</a>
                  <!--<a data-toggle="modal" data-target="#EditUserAddress-{{$address->users_address_id}}" class="btn btn-primary btn-sm">Edit</a>-->

                  <a onclick ="deleteAddres({{$address->users_address_id}})" class="btn btn-primary btn-sm">Delete</a>  
                </li>  
              </ul>  
            </div>  
       </div>
       
       
       
             <div class="modal fade" id="EditUserAddress-{{$address->users_address_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="login-form">
          <span id="edit_address_msg"></span>
          <form action="javascript:void(0)" method="post" id="EditAddresses" name="EditAddresses">
              <input type="hidden" id="url" value='{{url("/")}}'>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="users_address_id" value="{{$address->users_address_id}}">

           <div class="group-input mb-4">
              <label for="country">Address Type</label>
              <select name="address_type" id="address_type" required >
                      <option value="{{$address->address_type}}">{{ucfirst($address->address_type)}}</option>

    <option value="home">Home</option>
    <option value="office">Office</option>
    <option value="others">Other</option>
   
  </select>
             
            </div>
            
             <div class="group-input mb-4">
              <label for="country">Country/Region</label>
              <input type="text" id="country" name="country" value="{{$address->address->country}}" required>
            </div>
              <div class="group-input mb-4">
              <label for="name">Street Address</label>
              <input type="text" id="street_number" name="street_number"  value="{{$address->address->street_number}}" required>
            </div>
              <div class="group-input mb-4">
              <label for="city">City</label>
              <input type="text" id="city" name="city"  value="{{$address->address->city}}" required>
            </div>
              <div class="group-input mb-4">
              <label for="state">State/Province/Region</label> 
              <input type="text" id="state" name="state"  value="{{$address->address->state}}" required>
            </div>

            <div class="group-input mb-4">
               <label for="pin_code">Post Code</label>
              
                <select name="post_code" id="post_code" required>
                      <option value="{{$address->address->post_code}}">{{$address->address->post_code}}</option>

    <option value="Se6">Se6</option>
    <option value="Se12">Se12</option>
    <option value="Se13">Se13</option>
   
  </select>
            </div>
             <div class="">
              <input type="submit" id="EditUserAddressButton" class="btn btn-primary w-100" value="Edit">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

                                                                                 <?php
                }
                
               
               if(count($user) < 3)
               {
                    ?>  
                         <div class="col-lg-4 col-md-4 col-sm-12 text-left">
        <a href="javascript:void(0);" class="btn btn-primary mb-4" data-toggle="modal" data-target="#AddAddress">Add Address</a>
      </div>   
                 <?php  
               }
           
        ?>  
                  
                                                                         
                            
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="place-order">
                            <h4>Your Order</h4>

                            <div class="order-total">
                                <ul class="order-table">
                                    <?php 
                                        $items = array();
                                        $quantity = array();
                                        $price = array();
                                        foreach($cartCollection as $item){

                                        $items[] = $item->id;
                                        $quantity[] = $item->quantity;
                                        $price[] = $item->price;
                                    ?>
                                    <li class="media">
                                        <img class="mr-3" src="{{ $item->attributes->image }}" width="64"  alt="Generic placeholder image">
                                        <div class="media-body">
                                          <h5 class="mt-0 mb-1">{{$item->name}}</h5>
                                          <p class="m-0">£{{ $item->price }} <span><small>Qnt. {{ $item->quantity }}</small></span></p>
                                        </div>
                                    </li>
                                    <?php }?>

                                    <li class="mt-3 bg-primary">Subtotal <span>£{{ \Cart::getTotal() }}</span></li>
                                    <li class="bg-primary">Discount({{ session()->get('Discount_coupen_code')['name']}}%) <span>£{{ session()->get('Discount_coupen_code')['discount']}}</span></li>
                                    <li class="bg-primary">Order Type <span>{{ucfirst(session('payment_mode'))}}</span></li>
                                    <li class="bg-primary">Total <span>£{{ session()->get('final_amount')}}</span></li>

                                </ul>
                                <!--<div class="payment-check">-->
                                <!--    <div class="pc-item">-->
                                <!--        <label for="pc-paypal">-->
                                <!--            Cash On Delivery-->
                                <!--            <input type="checkbox" id="pc-paypal">-->
                                <!--            <span class="checkmark"></span>-->
                                <!--        </label>-->
                                <!--         <label for="pc-paypal">-->
                                <!--            Online-->
                                <!--            <input type="checkbox" id="pc-paypal">-->
                                <!--            <span class="checkmark"></span>-->
                                <!--        </label>-->
                                <!--    </div>-->
                                <!--     <div class="pc-item">-->
                                       
                                <!--    </div> -->
                                <!--</div>-->
                                <div class="order-btn">
                                    
                                    <?php
                                    
                                     if(count($user) == 0)
               {
                    ?>  
                         <!--<button type="button"  class="btn btn-primary mt-2" disabled inactive >Place Order</button>-->
                         <input type="button" name="submit" class="btn btn-primary mt-2" value="Cash On Delivery" inactive disabled>
                
                <input type="button" name="submit" class="btn btn-primary mt-2" value="Online" inactive  disabled>
                 <?php  
               }else{
                   ?>
                   
                <input type="submit" name="submit" class="btn btn-primary mt-2" id="buttonForCashOnDeliveryPayment" value="Cash On Delivery">
                
                <input type="submit" name="submit" class="btn btn-primary mt-2" id="buttonForOnlinePayment" value="Online">

                 
               <?php    
               }
                                    ?>
                                   
                                   
                                    <!-- <a href="{{route('paymentHandler')}}" type="submit" class="btn btn-primary mt-2">Place Order</a> -->
                                </div>
                            </div>
                            
                            <a href="{{route('Menus')}}" class="btn btn-primary mt-2 w-100">Continue Order...</a> 
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

<!-- <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h2>Pay for Event</h2>
                <br>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-3">

        </div>
        <div class="col-lg-6">
            <form  action="{{url('payment')}}"  data-cc-on-file="false" data-stripe-publishable-key="pk_test_iS5sLGz5CONWxJ8KHhBzHHvD" name="frmStripe" id="frmstripe" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label>Name on Card</label>
                        <input class="form-control" size="4" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label>Card Number</label>
                        <input autocomplete="off" class="form-control" size="20" type="text" name="card_no">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 form-group">
                        <label>CVC</label>
                        <input autocomplete="off" class="form-control" placeholder="ex. 311" size="3" type="text" name="cvv">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label>Expiration</label>
                        <input class="form-control" placeholder="MM" size="2" type="text" name="expiry_month">
                    </div>
                    <div class="col-lg-4 form-group">
                        <label> </label>
                        <input class="form-control" placeholder="YYYY" size="4" type="text" name="expiry_year">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-control total btn btn-primary">
                            Total: <span class="amount">$20</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <button class="form-control btn btn-success submit-button" type="submit" style="margin-top: 10px;">Pay »</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
 -->
<div class="modal fade" id="AddAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="login-form">
          <span id="add_address_msg"></span>
          <form action="javascript:void(0)" method="post" id="addAddressFrom" name="addAddressFrom">
           <input type="hidden" id="page_name" value='checkout'>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="group-input mb-4">
              <label for="country">Address Type</label>
              <select name="address_type" id="address_type" required>
                      <option value="">Select Address Type</option>
<?php
$addressSatausArray = array('home','office','others');

foreach($addressSatausArray as $key=>$value)
{
//     print_r($userAddressTypes);
// exit();

   if(in_array($value,$userAddressTypes))
   {
   }
   else
   {
?>
    <option value="{{$value}}">{{ucfirst($value)}}</option>
    
   
   <?php
   }
}

?>
   
   
  </select>
             
            </div>
            
             <div class="group-input mb-4">
              <label for="country">Country/Region</label>
              <input type="text" id="country" name="country" value="" required>
            </div>
              <div class="group-input mb-4">
              <label for="name">Street number</label>
              <input type="text" id="street_number" name="street_number" value="" required>
            </div>
              <div class="group-input mb-4">
              <label for="city">City</label>
              <input type="text" id="city" name="city" value="" required>
            </div>
              <div class="group-input mb-4">
              <label for="state">State/Province/Region</label>
              <input type="text" id="state" name="state" value="" required>
            </div>

            <div class="group-input mb-4">
               <label for="post_code">Post Code</label>
              <select name="post_code" id="post_code" required>
                      <option value="">Select Code Type</option>

    <option value="Se6">Se6</option>
    <option value="Se12">Se12</option>
    <option value="Se13">Se13</option>
   
  </select>
            </div>
            <div class="">
              <input type="submit" id="addAddressSubmitBtn" class="btn btn-primary w-100" value="Add">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

function checkUserPaymentModeForDelivery()
{
    
//     var AddressCount = $('#buttonForCashOnDeliveryPayment').val();
//   alert(AddressCount); 
    
    
}

    function addAddressForCheckout(address_id)
    {
        
        // alert(address_id);
        $.ajax({


url: '{{route('AddAddressInCheckOut')}}',
		  method: 'post',
		  headers:{
	  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
		  data: {
			action:'add-address',
			address_id:address_id
		
			
			  
		  },
		  success: function (data) {  
			  dataArray = JSON.parse(data);  
if(dataArray.status == 'success')
{
    window.location.reload();

}
},
});
    }
    
    function deleteAddres(id)
    {

        $.ajax({


url: '{{route('DeleteAddresse')}}',
		  method: 'post',
		  headers:{
	  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
		  data: {
			action:'delete-address',
			address_id:id
		
			
			  
		  },
		  success: function (data) {  
			  dataArray = JSON.parse(data);  
if(dataArray.status == 'success')
{
    window.location.reload();

}
},
});
        
    }
</script>
@endsection
@section('javascript')
@endsection
