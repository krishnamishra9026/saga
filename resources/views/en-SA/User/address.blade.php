@extends('en-SA.layouts.default')
@section('content')

@php
use App\Helpers\Common;
@endphp

<section class="inner_banner" style="background: url('./images/about-page.jpg') no-repeat;background-position: center;background-size: cover;background-position: 50% 92%;">

    <div class="container">

        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">

                <div class="vl-filter-text-box">

                    <h1>Manage Address</h1>

                </div>

            </div>

        </div>

    </div>

</section>



<section class="manage_address">

  <div class="container">

    <div class="row">      

      <div class="col-lg-8 col-md-8 col-sm-12">

        <div class="user_details mb-5">

          <h2>{{ $UserDetails->first_name.' '.$UserDetails->last_name }}</h2>

          <ul class="list-unstyled user-pro">

            <span>{{ $UserDetails->email }}</span>

          </ul>

        </div>

      </div>

      <div class="col-lg-4 col-md-4 col-sm-12 text-right">

        <a href="javascript:void(0);" class="btn btn-primary mb-4" data-toggle="modal" data-target="#EditProfile">Edit Address</a>

      </div>



      <div class="col-lg-3 col-md-3 col-sm-12">

        <div class="nav flex-column nav-pills pro_nav mb-4">
         <a class="nav-link active" href="{{ route('address') }}">Address</a>
            <a class="nav-link " href="{{ route('orders') }}">Orders</a>
         

        </div>

      </div>



      <div class="col-lg-9 col-md-9 col-sm-12">

        <div class="row">

		<div class="col-lg-6 col-md-6 col-sm-12">

           <div class="card p-3 mb-4">

               <div class="user_details mb-5">

          <h3>Your Details </h3>

          <ul class="list-unstyled user-pro">

            <li><b>Your Name:-</b> {{ $UserDetails->first_name.' '.$UserDetails->last_name }}</li>
            <li><b>Phone number:-</b> {{ $UserDetails->mobile }}</li>
            <li><b>Mail ID:-    </b>  {{ $UserDetails->email }}</li>


</br>
 
                 <h2>Address</h2>

                 <p class="m-0"><i class="fas fa-home"></i>
                  @php
                  $address = json_decode($UserDetails->shipping_address);
                  @endphp
                  {{ @$address->address }}
                  <br>
                  City : {{ @$address->city }}
                  <br>
                  Country : {{ @$address->country }}
                  <br>
                  State : {{ @$address->state }}
                  <br>
                  Postcode : {{ @$address->postcode }}
                  <br></p>
          </ul>

        </div>

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

          <div class="alert" id="msg_div" style="display:none">
                <span id="res_message"></span>
              </div>

          <form id="contact_us" method="post" action="javascript:void(0)" name="FormLogin">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="group-input mb-4">

              <label for="name">Address</label>

              <input type="text" class="form-control" required id="address" name="address" value="{{ $address->address }}">

            </div>

            <div class="group-input mb-4">

              <label for="name">City</label>

              <input type="text" class="form-control" required id="city" name="city" value="{{ $address->city }}">

            </div>

            <div class="group-input mb-4">

              <label for="name">Country </label>
              <select class="form-control" required name="country" id="country">
                @foreach(Common::getCountryArray() as $country)
                <option value="{{$country}}" @if($country == @$address->country) selected @endif>{{$country}}</option> 
                @endforeach
              </select>
            </div>
            <div class="group-input mb-4">
              <label for="name">State</label>
              <input type="text" class="form-control" required id="state" name="state" value="{{ $address->state }}">
            </div>
            <div class="group-input mb-4">

              <label for="name">Postcode</label>

              <input type="text" class="form-control" required id="postcode" name="postcode" value="{{ $address->postcode }}">

            </div>

            <div class="">

              <input type="submit" id="send_form" class="btn btn-primary w-100" value="Update">

            </div>

          </form>

        </div>

      </div>

    </div>

  </div>

</div>



@endsection
@section('javascript')
  <script type="text/javascript">

  $(document).ready(function(){
$('#send_form').click(function(e){
   e.preventDefault();
   $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
      }
  });
   $('#send_form').html('Sending..');
   $.ajax({
      url: "{{ url('save-address')}}",
      method: 'post',
      data: $('#contact_us').serialize(),
      success: function(result){
          $('#send_form').html('Submit');
          if(result == 'updated'){
              $('#res_message').html('Address updated successfully!');
              $('#msg_div').removeClass('alert-danger');
              $('#msg_div').addClass('alert-success');
              $('#msg_div').show();
              $('#res_message').show();
          }else{
              $('#res_message').html(result.msg);
              $('#msg_div').removeClass('alert-success');
              $('#msg_div').addClass('alert-danger');
              $('#msg_div').show();
              $('#res_message').show();
          }

          document.getElementById("contact_us").reset(); 
          setTimeout(function(){
          $('#res_message').hide();
          $('#msg_div').hide();

          $('#EditProfile').modal('hide');
          location.reload();
          },3500);
        
      }});
   });
});
</script>
@endsection
