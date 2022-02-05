@extends('Admin.default')

@section('content')
<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Offers')}}">Offer List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Offer</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveOffers')}}" enctype="multipart/form-data" method="post" id="EditForm" name="EditForm" novalidate="novalidate">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="edit_id" value="{{ $Result->id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit Offer</div>
                <hr>
                <span id="Return_msg">
                  <?php
                  if(Session::has('message')){
                    echo Session::get('message');
                  }
                  ?>
                </span>

                <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Offer Title</label>
                      <input type="text" class="form-control" id="offer_title" name="offer_title" value="{{$Result->offer_title}}">
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Offer Description</label>
                      <textarea  class="form-control" name="offer_description" id="offer_description">{{$Result->offer_description}}</textarea>
                    </div> 
                  </div>
                </div>

                <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Spent Amount(£):</label>
                      <input type="text" class="form-control" id="spent_amount" name="spent_amount" value="{{$Result->spent_amount}}">
                    </div> 
                  </div>
                </div>

                <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Offer For</label><br>
                      <input type="radio" class="form-control1" id="delivery" @if($Result->offer_for == "Delivery") {{ "checked" }} @endif name="offer_for" value="Delivery">
                      <label for="delivery">Delivery</label>
                      <input type="radio" class="form-control1" id="collection" @if($Result->offer_for == "Collection") {{ "checked" }} @endif name="offer_for" value="Collection">
                      <label for="collection">Collection</label>
                      <input type="radio" class="form-control1" id="both" @if($Result->offer_for == "Both") {{ "checked" }} @endif name="offer_for" value="Both">
                      <label for="both">Both</label>
                    </div> 
                  </div>
                  @php
                    $dayArr = array();
                    if(isset($Result->offer_day)){
                      $dayArr = json_decode($Result->offer_day);
                    }
                    
                  @endphp
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Offer Day/s</label><br>
                      <input type="checkbox" class="form-control" @if(in_array("Mon", $dayArr)) {{ "checked" }} @endif id="day_1" name="offer_day[]" value="Mon">
                      <label for="day_1">Mon</label>
                      <input type="checkbox" class="form-control" @if(in_array("Tus", $dayArr)) {{ "checked" }} @endif id="day_2" name="offer_day[]" value="Tus">
                      <label for="day_2">Tus</label>
                      <input type="checkbox" class="form-control" @if(in_array("Wed", $dayArr)) {{ "checked" }} @endif id="day_3" name="offer_day[]" value="Wed">
                      <label for="day_3">Wed</label>
                      <input type="checkbox" class="form-control" @if(in_array("Thu", $dayArr)) {{ "checked" }} @endif id="day_4" name="offer_day[]" value="Thu">
                      <label for="day_4">Thu</label>
                      <input type="checkbox" class="form-control" @if(in_array("Fri", $dayArr)) {{ "checked" }} @endif id="day_5" name="offer_day[]" value="Fri">
                      <label for="day_5">Fri</label>
                      <input type="checkbox" class="form-control" @if(in_array("Sat", $dayArr)) {{ "checked" }} @endif id="day_6" name="offer_day[]" value="Sat">
                      <label for="day_6">Sat</label>
                      <input type="checkbox" class="form-control" @if(in_array("Sun", $dayArr)) {{ "checked" }} @endif id="day_7" name="offer_day[]" value="Sun">
                      <label for="day_7">Sun</label>
                    </div> 
                  </div>
                </div>

                <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">First order offer ?</label><br>
                      <input type="radio" class="form-control" id="offeryes" name="first_order_offer" value="Yes" @if($Result->first_order_offer == "Yes") {{ "checked" }} @endif>
                      <label for="offeryes">Yes</label>
                      <input type="radio" class="form-control" id="offerno" name="first_order_offer" value="No" @if($Result->first_order_offer == "No") {{ "checked" }} @endif>
                      <label for="offerno">No</label>
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Default Offer</label><br>
                      <input type="checkbox" class="form-control1" id="default_yes" name="default_offer" value="Yes" @if($Result->default_offer == "Yes") {{ "checked" }} @endif>
                      <label for="default_yes">Yes</label>
                    </div> 
                  </div>
                </div>
                  
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Image</label>
                      <input type="file" class="form-control" name="image" id="image" value="{{ $Result->image }}"><br>
                      @if($Result->image)
                      <img style='height:80px; width:120px;' src="{{ url('/upload/offers/'. $Result->image)}}">
                      @endif
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="status" name="status">
                        <option value="1" @if($Result->status == "1") {{ "selected" }} @endif>Active</option>
                        <option value="0" @if($Result->status == "0") {{ "selected" }} @endif>De-Active</option>
                      </select>
                    </div> 
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary  pull-right" id="SaveBtn">Save</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>  
@stop

@section('javascript')
  <link rel="stylesheet" href="{{ asset('public/Admin/DatePicker/default.css')}}" type="text/css">
  <script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>
@stop