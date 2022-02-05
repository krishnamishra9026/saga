@extends('Admin.default')

@section('content')
  
<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Size')}}">Size List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Size</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveSize')}}" enctype="multipart/form-data" method="post" id="EditForm" name="EditForm" novalidate="novalidate">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="edit_id" value="{{ $Result->id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit Size</div>
                <hr>
                <span id="Return_msg">
                  @if(Session::has('message')){
                    echo Session::get('message');
                  }
                  @endif
                </span>
                <div class="row">
                  <div class="col-sm-2">
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
                  <div class="col-sm-5">
                    <div class="form-group">
                      <label for="input-1">Category</label>
                      <select class="form-control" id="category_id" name="category_id" onchange="getCategoryList(this)">
                        <?php
                          $category = DB::table('category')->select('*')->get();
                          foreach ($category as $row) {
                        ?>
                        <option value="<?php echo $row->id; ?>" <?php if( $row->id==$Result->category_id) echo "selected"; ?>><?php echo $row->category_name; ?></option>
                      <?php  } ?>
                    </select>
                    </div> 
                  </div>
                  <div class="col-sm-5">
                    <div class="form-group">
                      <label for="input-1">Sub Category</label>
                      <span id="subcategorylist">
                      <select class="form-control" id="sub_category_id" name="sub_category_id">
                        <?php
                          $category = DB::table('sizes')->select('*')->where('category_id',$Result->category_id)->first();
                          $categoryname = DB::table('sub-category')->select('*')->where('category_id',$Result->category_id)->first();
                        ?>
                        <option value="<?php echo $category->category_id; ?>" <?php if($category->category_id==$Result->category_id) echo "selected"; ?>><?php echo $categoryname->name; ?></option>
                    </select>
                    </div> 
                  </div>
                </div>
                
                <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Name</label>
                      <input type="text" class="form-control" id="name" name="name" value="{{$Result->name}}">
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
                  
                <div class="row">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary  pull-right" id="SaveBtn">Save</button>
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


function getSubCategoryList(node)
{
  var categoryId = $(node).val();

  $.ajax({
    url: "{{route('FetchSubCategoryList')}}",
            method: "post",
            headers:{
        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
    },
    data: {
      action:'fetch',
      categoryId:categoryId
    },
    success: function (data) {  
    dataArray = JSON.parse(data);  
    if(dataArray.status == 'success')
    {
      $("#e23e32e32e32").html(dataArray.data_sub_cate);
    }

    },
  });
}

function getCategoryList(node)
{
  var category_id = $(node).val();
  $("#category_msg").hide();
  $.ajax({

    url: "{{route('FetchCategoryList')}}",
              method: "post",
              headers:{
          'X-CSRF-TOKEN' : '{{ csrf_token() }}'
      },
      data: {
        action:'fetch',
        category_id:category_id
          
      },
      success: function (data) {  
      dataArray = JSON.parse(data);  
      if(dataArray.status == 'success')
      {
        $("#subcategorylist").html(dataArray.data_cate);
      }
    },

  });
}


function getBrandList(node)
{
  var subcategoryId = $(node).val();

  $.ajax({

      url: "{{route('FetchBrandList')}}",
              method: "post",
              headers:{
          'X-CSRF-TOKEN' : '{{ csrf_token() }}'
      },
      data: {
        action:'fetch',
        subcategoryId:subcategoryId
          
      },
      success: function (data) {  
      dataArray = JSON.parse(data);  
    if(dataArray.status == 'success')
    {
      $("#test2").html(dataArray.data_brand);
    }
    },

  });
}


$(document).ready(function () {

 $(document).on("blur",'#name',function(){
     var title=$("#name").val();

     $("#slug").val(title.toLowerCase().split(' ').join('-'));
  })

 $.validator.setDefaults({
   submitHandler: function () {
     form.submit();
   }
 });

 $('#brandform').validate({
   rules: { 
     name: {
       required: true,
       normalizer: function( value ) {
        return $.trim( value );
       }, 
     }
   },
   messages: {
     name: {
       required: "Please enter name",
     }
   },
   errorElement: 'span',
   errorPlacement: function (error, element) {
     error.addClass('invalid-feedback');
     element.closest('.form-group').append(error);
   }
 });
});
        
</script>

@stop