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
            <li class="breadcrumb-item active" aria-current="page">Edit Discount</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveDiscount')}}" enctype="multipart/form-data" method="post" id="EditForm" name="EditForm" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="edit_id" value="{{ $Result->id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit Discount</div>
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
                      <input type="text" class="form-control" id="discount_title" name="discount_title" value="{{$Result->discount_title}}" onchange="HideErr('discount_title_msg')"    >
                                        <span id="discount_title_msg"></span>

                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Discount Description</label>
                      <textarea  class="form-control" name="discount_description" id="discount_description" onchange="HideErr('discount_description_msg')"   >{{$Result->discount_description}}</textarea>
                                                              <span id="discount_description_msg"></span>

                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Coupen Code</label>
                      <input  class="form-control" name="coupen_code" id="coupen_code"  onchange="HideErr('coupen_code_msg')" value="{{$Result->coupen_code}}"  >
                    <span id="coupen_code_msg"></span>

                    </div> 
                  </div>
                </div>

                <div class="row">
                
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Discount Amount(₹):</label>
                      <input type="text" class="form-control" id="discount_amount" name="discount_amount" placeholder="% (Percent)" value="{{$Result->discount_amount}}"  onchange="HideErr('discount_amount_msg')" >
                    <span id="discount_amount_msg"></span>

                    </div> 
                  </div>
                </div>

          

                  
                <div class="row">
                
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="status" name="status" onchange="HideErr('status_msg')"  >
                        <option value="1" @if($Result->status == "1") {{ "selected" }} @endif>Active</option>
                        <option value="0" @if($Result->status == "0") {{ "selected" }} @endif>De-Active</option>
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
  <link rel="stylesheet" href="{{ asset('public/Admin/DatePicker/default.css')}}" type="text/css">
  <script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>
  <script type="text/javascript">
  
$("#SaveBtn").click(function(){
    var flag=1;
    var discount_title = $('#discount_title').val();
    var discount_description = $('#discount_description').val();
    var coupen_code = $('#coupen_code').val();
        var discount_amount = $('#discount_amount').val();

    
    var status = $('#status').val();


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
      $( "#EditForm" ).submit();
     }
});
function HideErr(id)
 { 
      $("#"+id).hide();
 }  
</script>
@stop