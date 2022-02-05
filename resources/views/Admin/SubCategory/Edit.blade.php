@extends('Admin.default')

@section('content')
  
<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('SubCategory')}}">Sub Category List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Sub Category</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveSubCategory')}}" enctype="multipart/form-data" method="post" id="EditForm" name="EditForm">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="edit_id" value="{{ $Result->id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit Sub Category</div>
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
                      <select class="form-control" id="language_id" name="language_id" onchange="HideErr('lang_msg')">

                        <option value="">Select</option>
                        @foreach( $Language as $lang)
                        <option value="{{$lang->id}}" <?php if( $lang->id==$Result->language_id) echo "selected"; ?>>{{$lang->language_name}}</option>
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
                          <option value="<?php echo $category->id; ?>" <?php if( $category->id==$Result->category_id) echo "selected"; ?>><?php echo $category->category_name; ?></option>

                        @endforeach
                    </select>
                    <span id="category_msg"></span>
                    </div> 
                  </div>

                   <div class="col-sm-4">
                   
                    <div class="form-group">
                      <label for="input-1">Name</label>
                      <input type="text" class="form-control" id="name" name="name" value="{{$Result->name}}" onkeyup="HideErr('subcategory_msg')">
                      <span id="subcategory_msg"></span>
                    </div> 
                  </div>
                  
                    <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Slug</label>
                      <input type="text" class="form-control" id="sub_category_slug" name="sub_category_slug" value="{{$Result->sub_category_slug}}" onkeyup="HideErr('sub_category_slug_msg')">
                      <span id="sub_category_slug_msg"></span>
                    </div> 
                  </div>
                  
                   </div>
                  
                  <div class="row">

                  

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">SUB CATEGORY IMAGE</label>
                      <input type="file" style="height:45px;" class="form-control" id="subcategory_images"  name="subcategory_images" placeholder="Multiple Images"><br>
                      <a><button type="button" class="btn btn-success" data-toggle="modal" data-target="#subcategory_imagesModal">View image</button></a>
                      <div class="modal fade" id="subcategory_imagesModal" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Sub Category Image</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                             </div>
                               <div style="height: 200px;overflow-y: auto;">

                            <div class="modal-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                      <th>Images</th>
                                      <th>Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                   $imageArray = explode('|',$Result->image);

                                    $i=1;
                                   foreach($imageArray as $img)
                                   {
                                    if(!empty($img))
                                    {
                                    ?>
                                    <tr>
                                    <td class="FontSize"><img  width="100" height="100" src="{{ url('/upload/sub-category/'.$img) }}"></td>


                                    <td class="FontSize">
                                    <form class="ssgroup" action="{{ route('RemoveProductImg') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $img }}" id="id" name="img">
                                            <input type="hidden" value="{{ $Result->id }}" id="productId"  name="productId">
                                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>

                                     </form>
                                   </td>
                                  </tr>
                                    <?php
                                    $i++; 
                                    }
                                   }
                                    ?>
                                    </tbody>
                                  </table>
                            </div>
                             </div>
                          </div>
                        </div>
                    </div>

                    </div> 
                  </div>
                  
                     <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="status" name="status" onchange="HideErr('status_msg')">
                          <option value="">Select</option>
                        <option value="1" @if($Result->status == "1") {{ "selected" }} @endif>Active</option>
                        <option value="0" @if($Result->status == "0") {{ "selected" }} @endif>De-Active</option>
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
  <link rel="stylesheet" href="{{ asset('public/Admin/DatePicker/default.css')}}" type="text/css">
  <script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>
     <script type="text/javascript">
    $(document).ready(function (){

        $(document).on("blur",'#name',function(){
           var title=$("#name").val();
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
      $( "#EditForm" ).submit();
     }
});
function HideErr(id)
 { 
      $("#"+id).hide();
 }  
</script> 
@stop