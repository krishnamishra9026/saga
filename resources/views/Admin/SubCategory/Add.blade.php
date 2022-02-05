@extends('Admin.default')


@section('content')
  
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('SubCategory')}}"> Sub Category List</a></li>
            <li class="breadcrumb-item active" aria-current="page">  Add Sub Category</li>
          </ol>
        </div>
      </div>
      
      <form action="{{ route('InsertSubCategory')}}" enctype="multipart/form-data" method="post" id="AddForm" name="AddForm" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title"> Add Sub Category</div>
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
                      <select class="form-control" id="language_id" name="language_id"  onchange="HideErr('lang_msg')">

                        <option value="">Select</option>
                        @foreach( $Language as $lang)
                        <option value="{{$lang->id}}">{{$lang->language_name}}</option>
                        @endforeach
                      </select>
                      <span id="lang_msg"></span>
                    </div> 
                  </div>

                <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Category</label>
                      <select class="form-control" id="category" name="category_id" onchange="HideErr('category_msg')">
                        <option value="">Select</option>
                        @foreach ($Category as $category) {
                        <option value="<?php echo $category->id; ?>"><?php echo $category->category_name; ?></option>
                        @endforeach
                    </select>
                    <span id="category_msg"></span>
                    </div> 
                  </div>
                   
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Name</label>
                      <input type="text" class="form-control" id="name" name="name" onkeyup="HideErr('subcategory_msg')">
                      <span id="subcategory_msg"></span>
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Slug</label>
                      <input type="text" class="form-control" id="sub_category_slug" name="sub_category_slug" onkeyup="HideErr('sub_category_slug_msg')">
                      <span id="sub_category_slug_msg"></span>
                    </div> 
                  </div>

                   </div>
                  
                  <div class="row">
                  <div class="col-sm-6">
                      <div class="form-group">
                          <label for="input-1">Sub Category Image</label>
                          <input type="file" class="form-control" id="subcategory_images" name="subcategory_images" placeholder="Image" onchange="HideErr('subcategory_images_msg')">
                        <span id="subcategory_images_msg"></span>
                      </div> 
                  </div>

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
  <script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>
    <script type="text/javascript">
  
   $(document).ready(function (){
   
        $(document).on("change",'#name',function(){
           var title=$("#name").val();
    //   alert(title.toLowerCase().split(' ').join('-').replace(/[\*\^\'\!]/g, ''));
           $("#sub_category_slug").val(title.toLowerCase().split(' ').join('-').replace(/[\*\^\'\!]/g, ''));
        })  
       
   });
  
$("#SaveBtn").click(function(){
    var flag=1;
    var category = $('#category').val();
    var name = $('#name').val();
    var sub_category_slug = $('#sub_category_slug').val();
    var language_id = $('#language_id').val();
    var status = $('#status').val();
    if(category == '')
    {
         $("#category_msg").css('color','red');
         $("#category_msg").show();
         $("#category_msg").html('Select Category');
         flag=0;
    }
    if(name == '')
    {
         $("#subcategory_msg").css('color','red');
         $("#subcategory_msg").show();
         $("#subcategory_msg").html('Enter Sub Category Name');
         flag=0;
    }
     if(sub_category_slug == '')
    {
         $("#sub_category_slug_msg").css('color','red');
         $("#sub_category_slug_msg").show();
         $("#sub_category_slug_msg").html('Enter Sub Category Name Slug');
         flag=0;
    }
     if(language_id == '')
    {
         $("#lang_msg").css('color','red');
         $("#lang_msg").show();
         $("#lang_msg").html('Select Language');
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