@extends('Admin.default')


@section('content')
  
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Language')}}">Language List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Language</li>
          </ol>
        </div>
      </div>
      
      <form action="{{ route('InsertLanguage')}}" enctype="multipart/form-data"  method="post" id="languageForm" name="AddLanguageForm" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Add Language</div>
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
                      <label for="input-1">Language Name</label>
                      <input type="text" value="" class="form-control" id="language_name" name="language_name" onkeyup="HideErr('language_name_msg')">
                        <span id="language_name_msg"></span>
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Language Slug</label>
                      <input type="text" value="" class="form-control" id="language_slug" name="language_slug" onkeyup="HideErr('language_slug_msg')">
                        <span id="language_slug_msg"></span>
                    </div> 
                  </div>
                   </div>
                  
                  <div class="row">
                     <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="language_status" name="status" onchange="HideErr('language_status_msg')">
                        <option value="">Select</option>
                        <option value="1">Active</option>
                        <option value="0">De-Active</option>
                      </select>
                     <span id="language_status_msg"></span>

                    </div> 
                  </div>
                  </div>
                <div class="row">
                <div class="form-group">
                  <button type="button" class="btn btn-primary  pull-right" id="LanguageSaveBtn" >Save</button>
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
  
$("#LanguageSaveBtn").click(function(){
    var flag=1;

    
    var language_name = $('#language_name').val();
    var language_slug = $('#language_slug').val();
    var language_status = $('#language_status').val();

    if(language_name == '')
    {
         $("#language_name_msg").css('color','red');
         $("#language_name_msg").show();
         $("#language_name_msg").html('Enter Language');
         flag=0;
    }
    if(language_slug == '')
    {
         $("#language_slug_msg").css('color','red');
         $("#language_slug_msg").show();
         $("#language_slug_msg").html('Enter Slug');
         flag=0;
    }
     if(language_status == '')
    {
         $("#language_status_msg").css('color','red');
         $("#language_status_msg").show();
         $("#language_status_msg").html('Select Status');
            flag=0;
    }
    if(flag==1)
     {
      $( "#languageForm" ).submit();
     }
});
function HideErr(id)
 { 
      $("#"+id).hide();
 }  
</script>
@stop


