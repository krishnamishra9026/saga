@extends('Admin.default')
@section('content')
  
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Discount')}}">Discount List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Discount</li>
          </ol>
        </div>
      </div>
      
      <form action="{{ route('InsertDiscount')}}" enctype="multipart/form-data" method="post" id="AddForm" name="AddForm" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Add Discount</div>
                <hr>
                <span id="Return_msg">
                  <?php
                  if(Session::has('message')){
                    echo Session::get('message');
                  }
                  ?>
                </span>

                <div class="row">
                   <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Discount Title</label>
                      <input type="text" class="form-control" id="discount_title" name="discount_title" placeholder="Discount Title" onchange="HideErr('discount_title_msg')"  >
                    <span id="discount_title_msg"></span>

                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Discount Description</label>
                      <textarea  class="form-control" name="discount_description" id="discount_description" placeholder="Discount Description" onchange="HideErr('discount_description_msg')"  ></textarea>
                                          <span id="discount_description_msg"></span>

                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Coupen Code</label>
                      <input  class="form-control" name="coupen_code" id="coupen_code" placeholder="Coupen Code" onchange="HideErr('coupen_code_msg')">
                    <span id="coupen_code_msg"></span>

                    </div> 
                  </div>
                </div>

                <div class="row">
               
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Discount Amount(₹):</label>
                      <input type="text" class="form-control" id="discount_amount" name="discount_amount" placeholder="% (Percent)" onchange="HideErr('discount_amount_msg')" >
                                        <span id="discount_amount_msg"></span>

                    </div> 
                  </div>
                </div>

                <!--<div class="row">-->
                <!--   <div class="col-sm-6">-->
                <!--    <div class="form-group">-->
                <!--      <label for="input-1">Discount For</label><br>-->
                <!--      <input type="radio" class="form-control1" id="delivery" name="discount_for" value="Delivery">-->
                <!--      <label for="delivery">Delivery</label>-->
                <!--      <input type="radio" class="form-control1" id="collection" name="discount_for" value="Collection">-->
                <!--      <label for="collection">Collection</label>-->
                <!--      <input type="radio" class="form-control1" id="both" name="discount_for" value="Both">-->
                <!--      <label for="both">Both</label>-->
                <!--    </div> -->
                <!--  </div>-->
                <!--  <div class="col-sm-6">-->
                <!--    <div class="form-group">-->
                <!--      <label for="input-1">Discount Day/s</label><br>-->
                <!--      <input type="checkbox" class="form-control" id="day_1" name="discount_day[]" value="Mon">-->
                <!--      <label for="day_1">Mon</label>-->
                <!--      <input type="checkbox" class="form-control" id="day_2" name="discount_day[]" value="Tus">-->
                <!--      <label for="day_2">Tus</label>-->
                <!--      <input type="checkbox" class="form-control" id="day_3" name="discount_day[]" value="Wed">-->
                <!--      <label for="day_3">Wed</label>-->
                <!--      <input type="checkbox" class="form-control" id="day_4" name="discount_day[]" value="Thu">-->
                <!--      <label for="day_4">Thu</label>-->
                <!--      <input type="checkbox" class="form-control" id="day_5" name="discount_day[]" value="Fri">-->
                <!--      <label for="day_5">Fri</label>-->
                <!--      <input type="checkbox" class="form-control" id="day_6" name="discount_day[]" value="Sat">-->
                <!--      <label for="day_6">Sat</label>-->
                <!--      <input type="checkbox" class="form-control" id="day_7" name="discount_day[]" value="Sun">-->
                <!--      <label for="day_7">Sun</label>-->
                <!--    </div> -->
                <!--  </div>-->
                <!--</div>-->

                <!--<div class="row">-->
                <!--   <div class="col-sm-6">-->
                <!--    <div class="form-group">-->
                <!--      <label for="input-1">First order discount ?</label><br>-->
                <!--      <input type="radio" class="form-control1" id="discountyes" name="first_order_discount" value="Yes">-->
                <!--      <label for="discountyes">Yes</label>-->
                <!--      <input type="radio" class="form-control1" id="discountno" name="first_order_discount" value="No" checked>-->
                <!--      <label for="discountno">No</label>-->
                <!--    </div> -->
                <!--  </div>-->
                <!--  <div class="col-sm-6">-->
                <!--    <div class="form-group">-->
                <!--      <label for="input-1">Default Discount</label><br>-->
                <!--      <input type="checkbox" class="form-control1" id="default_yes" name="default_offer" value="Yes">-->
                <!--      <label for="default_yes">Yes</label>-->
                <!--    </div> -->
                <!--  </div>-->
                <!--</div>-->

                <!--<div class="row">-->
                <!--  <div class="col-sm-6">-->
                <!--    <div class="form-group">-->
                <!--      <label for="input-1">Image</label>-->
                <!--      <input type="file" class="form-control" name="image" placeholder="Images">-->
                <!--    </div> -->
                <!--  </div>-->
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="status" name="status" onchange="HideErr('status_msg')">
                        <option value="">Select</option>
                        <option value="1">Active</option>
                        <option value="0">De-Active</option>
                      </select>
                     <span id="status_msg"></span>

                    </div> 
                  </div>
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-primary  pull-right" id="SaveBtn">Save</button>
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
   
<script type="text/javascript">
  
$("#SaveBtn").click(function(){
    var flag=1;
    var discount_title = $('#discount_title').val();
    var discount_description = $('#discount_description').val();
    var coupen_code = $('#coupen_code').val();
    var status = $('#status').val();
     var discount_amount = $('#discount_amount').val();


    if(discount_title == '')
    {
         $("#discount_title_msg").css('color','red');
         $("#discount_title_msg").show();
         $("#discount_title_msg").html('Enter title ');
         flag=0;
    }
     if(discount_description == '')
    {
         $("#discount_description_msg").css('color','red');
         $("#discount_description_msg").show();
         $("#discount_description_msg").html('Enter Description');
            flag=0;
    }
        if(coupen_code == '')
    {
         $("#coupen_code_msg").css('color','red');
         $("#coupen_code_msg").show();
         $("#coupen_code_msg").html('Enter Coupen Code');
            flag=0;
    }
           
           if(discount_amount == '')
    {
         $("#discount_amount_msg").css('color','red');
         $("#discount_amount_msg").show();
         $("#discount_amount_msg").html('Enter Amount');
            flag=0;
    }
        if(status == '')
    {
         $("#status_msg").css('color','red');
         $("#status_msg").show();
         $("#status_msg").html('Select Status');
            flag=0;
    }
    if(flag==1)
     {
      $( "#AddForm" ).submit();
     }
});
function HideErr(id)
 { 
      $("#"+id).hide();
 }  
</script>
  
  
@stop