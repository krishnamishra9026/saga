@extends('Admin.default')

@section('content')
  
<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Category')}}">Notification List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Notification</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveNotification')}}" enctype="multipart/form-data" method="post" id="EditNotificationForm" name="EditNotificationForm" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $Result->notification_id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit Notification</div>
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
                      <label for="input-1">Notification</label>
                      <input type="text" class="form-control" id="notification_title" name="notification_title" value="{{$Result->notification_title}}" onkeyup="HideErr('notification_title_msg')">
                       <span id="notification_title_msg"></span>

                    </div> 
                  </div>
                   </div>
                  
                  <div class="row">
                     <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="Notification_status" name="status" onchange="HideErr('Notification_status_msg')">
                        <option value="1" @if($Result->status == "1") {{ "selected" }} @endif>Active</option>
                        <option value="0" @if($Result->status == "0") {{ "selected" }} @endif>De-Active</option>
                      </select>
                       <span id="Notification_status_msg"></span>

                    </div> 
                  </div>
                  </div>
                <div class="row">
                <div class="form-group">
                  <button type="button" class="btn btn-primary  pull-right" id="NotificationEditBtn">Save</button>
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
  <!--<script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>-->
  <script type="text/javascript">
  
  
  $("#NotificationEditBtn").click(function(){
    var flag=1;
    
    var language_name = $('#language_name').val();
    var notification_title = $('#notification_title').val();
    var Notification_status = $('#Notification_status').val();

    if(language_name == '')
    {
         $("#language_msg").css('color','red');
         $("#language_msg").show();
         $("#language_msg").html('Select Language');
         flag=0;
    }

    if(notification_title == '')
    {
         $("#notification_title_msg").css('color','red');
         $("#notification_title_msg").show();
         $("#notification_title_msg").html('Enter Notification');
         flag=0;
    }

     if(Notification_status == '')
    {
         $("#Notification_status_msg").css('color','red');
         $("#Notification_status_msg").show();
         $("#Notification_status_msg").html('Select Status');
            flag=0;
    }
    if(flag==1)
     {
      $( "#EditNotificationForm" ).submit();
     }
});
function HideErr(id)
 { 
      $("#"+id).hide();
 }  
</script>
@stop