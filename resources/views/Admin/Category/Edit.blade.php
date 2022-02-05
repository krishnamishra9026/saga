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
            <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveCategory')}}" autocomplete="off"  enctype="multipart/form-data" method="post" id="EditForm" name="EditForm" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="edit_id" value="{{ $Result->id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit Category</div>
                <hr>
                <span id="Return_msg">
                  @if(Session::has('message')){
                    echo Session::get('message');
                  }
                  @endif
                </span>
                <div class="row">

                <div class="col-sm-4">
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

                   <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Name</label>
                      <input type="text" class="form-control" id="name" name="category_name" value="{{$Result->category_name}}" onkeyup="HideErr('category_name_msg')">
                        <span id="category_name_msg"></span>

                    </div> 
                  </div>
                  
                   <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Slug</label>
                      <input type="text" class="form-control" id="category_name_slug" name="category_slug" value="{{$Result->category_slug}}" onkeyup="HideErr('category_slug_msg')">
                        <span id="category_slug_msg"></span>

                    </div> 
                  </div>
                  
                   </div>
                  
                  <div class="row">
                    <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">SUB CATEGORY IMAGE</label>
                      <input type="file" style="height:45px;" class="form-control" id="category_images"  name="category_images" placeholder="Multiple Images"><br>
                      <a><button type="button" class="btn btn-success" data-toggle="modal" data-target="#category_imagesModal">View image</button></a>
                      <div class="modal fade" id="category_imagesModal" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Category Image</h4>
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
                                    <td class="FontSize"><img  width="100" height="100" src="{{ url('/upload/category/'.$img) }}"></td>


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

                     <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="category_status" name="status" onchange="HideErr('category_status_msg')">
                        <option value="">Select</option>

                        <option value="1" @if($Result->status == "1") {{ "selected" }} @endif>Active</option>
                        <option value="0" @if($Result->status == "0") {{ "selected" }} @endif>De-Active</option>
                      </select>
                    <span id="category_status_msg"></span>

                    </div> 
                  </div>
                  
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">GST</label>
                      <input type="text" class="form-control" value="{{$Result->gst}}" id="gst" name="gst" onkeyup="HideErr('gst_msg')">

                     
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
  <link rel="stylesheet" href="{{ asset('public/Admin/DatePicker/default.css')}}" type="text/css">
  <!--<script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>-->
    <script type="text/javascript">
  
    $(document).ready(function (){

        $(document).on("blur",'#name',function(){
           var title=$("#name").val();
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
      $( "#EditForm" ).submit();
     }
});
function HideErr(id)
 { 
      $("#"+id).hide();
 }  
</script>
@stop