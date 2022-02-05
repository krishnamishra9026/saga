@extends('Admin.default')


@section('content')
  
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Offers')}}">Offers List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Offers</li>
          </ol>
        </div>
      </div>
      
      <form action="{{ route('InsertOffers')}}" enctype="multipart/form-data" method="post" id="AddForm" name="AddForm" novalidate="novalidate">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Add Offers</div>
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
                      <input type="text" class="form-control" id="offer_title" name="offer_title" placeholder="Offer Title" required>
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Offer Description</label>
                      <textarea  class="form-control" name="offer_description" id="offer_description" placeholder="Offer Description" required></textarea>
                    </div> 
                  </div>
                </div>

                <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Spent Amount(£):</label>
                      <input type="text" class="form-control" id="spent_amount" name="spent_amount" placeholder="Spent Amount(£)" required>
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Offer For</label><br>
                      <input type="radio" class="form-control" id="delivery" name="offer_for" value="Delivery">
                      <label for="delivery">Delivery</label>
                      <input type="radio" class="form-control" id="collection" name="offer_for" value="Collection">
                      <label for="collection">Collection</label>
                      <input type="radio" class="form-control" id="both" name="offer_for" value="Both">
                      <label for="both">Both</label>
                    </div> 
                  </div>
                </div>

                <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Offer Day/s</label><br>
                      <input type="checkbox" class="form-control" id="day_1" name="offer_day[]" value="Mon">
                      <label for="day_1">Mon</label>
                      <input type="checkbox" class="form-control" id="day_2" name="offer_day[]" value="Tus">
                      <label for="day_2">Tus</label>
                      <input type="checkbox" class="form-control" id="day_3" name="offer_day[]" value="Wed">
                      <label for="day_3">Wed</label>
                      <input type="checkbox" class="form-control" id="day_4" name="offer_day[]" value="Thu">
                      <label for="day_4">Thu</label>
                      <input type="checkbox" class="form-control" id="day_5" name="offer_day[]" value="Fri">
                      <label for="day_5">Fri</label>
                      <input type="checkbox" class="form-control" id="day_6" name="offer_day[]" value="Sat">
                      <label for="day_6">Sat</label>
                      <input type="checkbox" class="form-control" id="day_7" name="offer_day[]" value="Sun">
                      <label for="day_7">Sun</label>
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">First order offer ?</label><br>
                      <input type="radio" class="form-control1" id="offeryes" name="first_order_offer" value="Yes">
                      <label for="offeryes">Yes</label>
                      <input type="radio" class="form-control1" id="offerno" name="first_order_offer" value="No" checked>
                      <label for="offerno">No</label>
                    </div> 
                  </div>
                </div>

                <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Default Offer</label><br>
                      <input type="checkbox" class="form-control" id="default_yes" name="default_offer" value="Yes">
                      <label for="default_yes">Yes</label>
                    </div> 
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Image</label>
                      <input type="file" class="form-control" name="image" placeholder="Images">
                    </div> 
                  </div>
                  <div class="col-sm-6">
                      <div class="form-group">
                        <label for="input-1">Status</label>
                        <select class="form-control" id="status" name="status">
                          <option value="1">Active</option>
                          <option value="0">De-Active</option>
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
  <link rel="stylesheet" href="{{ asset('Admin/DatePicker/default.css')}}" type="text/css">
  <script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>
@stop