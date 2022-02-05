@extends('Admin.default')

@section('content')
<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('GST')}}">GST List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit GST</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveGst')}}" enctype="multipart/form-data" method="post" id="EditGstForm" name="EditForm" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="edit_id" value="{{ $Result->id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit GST</div>
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
                      <label for="input-1">Language</label>
                      <select class="form-control" id="language_name" name="language_id" onchange="HideErr('language_name_msg')">

                        <option value="">Select</option>
                        @foreach( $Language as $lang)
                        <option value="{{$lang->id}}" <?php if( $lang->id==$Result->language_id) echo "selected"; ?>>{{$lang->language_name}}</option>
                        @endforeach
                      </select>
                      <span id="language_name_msg"></span>
                    </div> 
                  </div>
                     
                     
                   <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">gst</label>
                      <input type="number" class="form-control"  value="{{$Result->GST}}" id="gst_" name="gst" onchange="HideErr('gst_msg')" > 
                    </div> 
                    <span id="gst_msg"></span>

                  </div>

                  <div class="col-sm-4">
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
                  <button type="button" class="btn btn-primary  pull-right" id="SaveGstBtn" >Save</button>
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

$("#SaveGstBtn").click(function(){
    
    
    var flag=1;
    var gst = $('#gst_').val();
    var status = $('#status').val();
  var language_name = $('#language_name').val();
    
      if(language_name == '')
    {
         $("#language_name_msg").css('color','red');
         $("#language_name_msg").show();
         $("#language_name_msg").html('Select Language');
         flag=0;
    }
    
    if(gst == '')
    {
         $("#gst_msg").css('color','red');
         $("#gst_msg").show();
         $("#gst_msg").html('Enter GST');
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
      $("#EditGstForm").submit();
     }
});

function HideErr(id)
 { 
      $("#"+id).hide();
 }  
</script>

@stop