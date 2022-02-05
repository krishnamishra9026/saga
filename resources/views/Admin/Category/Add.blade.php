@extends('Admin.default')


@section('content')
  
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Category')}}">Category List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Category</li>
          </ol>
        </div>
      </div>
      
      <form action="{{ route('InsertCategory')}}" autocomplete="off"  enctype="multipart/form-data" method="post" id="AddForm" name="AddForm" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Add Category</div>
                <hr>
                <span id="Return_msg">
                  <?php
                  if(Session::has('message')){
                    echo Session::get('message');
                  }
                  ?>
                </span>
                <div class="row">
                
                <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Language</label>
                      <select class="form-control" id="language_name" name="language_id" onchange="HideErr('language_msg')">

                        <option value="">Select</option>
                        @foreach( $Language as $lang)
                        <option value="{{$lang->id}}">{{$lang->language_name}}</option>
                        @endforeach
                      </select>
                      <span id="language_msg"></span>
                    </div> 
                  </div>

                   <div class="col-sm-5">
                    <div class="form-group">
                      <label for="input-1">Name</label>
                      <input type="text" class="form-control" id="name" name="category_name" onkeyup="HideErr('category_name_msg')">
                      <span id="category_name_msg"></span>
                    </div> 
                  </div>
                  
                    <div class="col-sm-5">
                    <div class="form-group">
                      <label for="input-1">Slug</label>
                      <input type="text" class="form-control" id="category_name_slug" name="category_slug" onkeyup="HideErr('category_slug_msg')">
                      <span id="category_slug_msg"></span>
                    </div> 
                  </div>
                  
                  
                   </div>
                  
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                          <label for="input-1">Sub Category Image</label>
                          <input type="file" class="form-control" id="category_images" name="category_images" placeholder="Image" onchange="HideErr('category_images_msg')">
                        <span id="category_images_msg"></span>
                      </div> 
                  </div>
                     <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="category_status" name="status" onchange="HideErr('category_status_msg')">
                        <option value="">Select</option>
                        <option value="1">Active</option>
                        <option value="0">De-Active</option>
                      </select>
                      <span id="category_status_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">GST</label>
                      <input type="text" class="form-control" id="gst" name="gst" onkeyup="HideErr('gst_msg')">

                     
                      <span id="gst_msg"></span>
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
  <link rel="stylesheet" href="{{ asset('Admin/DatePicker/default.css')}}" type="text/css">
  <!--<script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>-->
  <script type="text/javascript">
   $(document).ready(function (){
   
        $(document).on("change",'#name',function(){
           var title=$("#name").val();
    //   alert(title.toLowerCase().split(' ').join('-').replace(/[\*\^\'\!]/g, ''));
           $("#category_name_slug").val(title.toLowerCase().split(' ').join('-').replace(/[\*\^\'\!]/g, ''));
        })  
       
   });
  
 
  
  
$("#SaveBtn").click(function(){
    var flag=1;
    var language_name = $('#language_name').val();
    var name = $('#name').val();
    var category_slug = $('#category_slug').val();
    var category_status = $('#category_status').val();
    var gst = $('#gst').val();

    if(language_name == '')
    {
         $("#language_msg").css('color','red');
         $("#language_msg").show();
         $("#language_msg").html('Select Language');
         flag=0;
    }
    if(name == '')
    {
         $("#category_name_msg").css('color','red');
         $("#category_name_msg").show();
         $("#category_name_msg").html('Enter Category Name');
         flag=0;
    }
     if(category_slug == '')
    {
         $("#category_slug_msg").css('color','red');
         $("#category_slug_msg").show();
         $("#category_slug_msg").html('Enter Category Name Slug ');
         flag=0;
    }
     if(category_status == '')
    {
         $("#category_status_msg").css('color','red');
         $("#category_status_msg").show();
         $("#category_status_msg").html('Select Status');
            flag=0;
    }
      if(gst == '')
    {
         $("#gst_msg").css('color','red');
         $("#gst_msg").show();
         $("#gst_msg").html('Enter GST');
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