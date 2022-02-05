@extends('Admin.default')

@section('content')

<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Banner')}}">Banner List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Banner</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveBanner')}}" enctype="multipart/form-data"  method="post" id="EditForm" name="EditForm" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="edit_id" value="{{ $Result->id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit Banner</div>
                <hr>
                <span id="Return_msg">
                  @if(Session::has('message')){
                    echo Session::get('message');
                  }
                  @endif
                </span>
                <div class="row">

                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Language</label>
                      <select class="form-control" id="language_name" name="language_id" onchange="HideErr('language_msg')">

                        <option value="">Select</option>
                        @foreach( $Language as $lang)
                        <option value="{{$lang->id}}" <?php if( $lang->id==$Result->language_id) echo "selected"; ?>>{{$lang->language_name}}</option>
                        @endforeach
                      </select>
                                            <span id="language_msg"></span>

                    </div> 
                  </div>
                  
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Name</label>
                      <input type="text" class="form-control" id="Banner_name" name="name" value="{{$Result->name}}" onkeyup="HideErr('Banner_name_msg')">
                      <span id="Banner_name_msg"></span>
                    </div> 
                  </div>
                </div>

                <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Image</label>
                      <input type="file" class="form-control" name="image" id="Banner_image" value="{{ $Result->image }}"><br>
                      <img style='height:80px; width:120px;' src="{{ url('/images/banner/'. $Result->image)}}">
                    </div> 
                  </div>
                </div>
                  
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="Banner_status" name="status" onchange="HideErr('Banner_status_msg')">
                          <option value="">Select</option>
                        <option value="1" @if($Result->status == "1") {{ "selected" }} @endif>Active</option>
                        <option value="0" @if($Result->status == "0") {{ "selected" }} @endif>De-Active</option>
                      </select>
                      <span id="Banner_status_msg"></span>
                    </div> 
                  </div>
                </div>
                <div class="row">
                <div class="form-group">
                  <button type="button" class="btn btn-primary  pull-right" id="SaveBtn">Save</button>
                </div>
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
    var Banner_name = $('#Banner_name').val();
    var Banner_status = $('#Banner_status').val();
    if(Banner_name == '')
    {
         $("#Banner_name_msg").css('color','red');
         $("#Banner_name_msg").show();
         $("#Banner_name_msg").html('Enter Banner Name');
         flag=0;
    }
    if(Banner_status == '')
    {
         $("#Banner_status_msg").css('color','red');
         $("#Banner_status_msg").show();
         $("#Banner_status_msg").html('Select Status');
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