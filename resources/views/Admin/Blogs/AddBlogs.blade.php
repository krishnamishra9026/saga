@extends('Admin.default')

@section('content')
  
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Blog')}}">Blog List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Blog</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('InsertBlog')}}" enctype="multipart/form-data"  method="post" id="AddForm" name="AddForm"  autocomplete ="off">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Add Blog</div>
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
                      <label for="input-1">Language</label>
                      <select class="form-control" id="language_name" name="language_id" onchange="HideErr('language_name_msg')">
                        <option value="">Select</option>
                        @foreach( $Language as $lang)
                        <option value="{{$lang->id}}">{{$lang->language_name}}</option>
                        @endforeach
                      </select>
                      <span id="language_name_msg"></span>
                      
                    </div> 
                  </div>

                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Category</label>
                      <select class="form-control" id="category" name="category_id" onchange="HideErr('category_msg')">
                        <option value="">Select</option>
                        @foreach ($categories as $category) {
                        <option value="<?php echo $category->id; ?>" ><?php echo $category->category_name; ?></option>
                        @endforeach
                    </select>
                    <span id="category_msg"></span>
                    </div> 
                  </div>
                  </div>
                
                <div class="row">
                    <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Blog Slug</label>
                      <input type="text" class="form-control" id="blog_slug" name="blog_title" placeholder="Name" onkeyup="HideErr('blog_slug_msg')">
                      <span id="blog_slug_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">BLOG TITLE DISPLAY NAME</label>
                      <input type="text" class="form-control" id="blog_title_display_name" name="blog_title_display_name" placeholder="Name" onkeyup="HideErr('blog_title_display_name_msg')">
                       <span id="blog_title_display_name_msg"></span>
                    </div> 
                  </div>
                 
               </div>
               <div class="row">

                  <div class="col-sm-10">
                    <div class="form-group">
                      <label for="input-1">Description</label>
                      <textarea class="form-control " id="summernote" name="blog_description" onkeyup="HideErr('summernote_msg')"></textarea>
                         <span id="summernote_msg"></span>
                    </div> 
                  </div>
                  </div>
                  <div class="row">

                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="input-1">Blog Images</label>
                      <input type="file" class="form-control" id="Menu_images"  name="images[]" placeholder="Multiple Images" onchange="HideErr('Menu_images_msg')" multiple>
                      <span id="Menu_images_msg"></span>
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="blog_status" name="status" onchange="HideErr('blog_status_msg')">
                          <option value="">Select</option>
                        <option value="1">Active</option>
                        <option value="0">De-Active</option>
                      </select>
                      <span id="blog_status_msg"></span>
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
@endsection

@section('javascript')
<script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

 <script>
      $('#summernote').summernote({
        placeholder: 'Description',
        tabsize: 2,
        height: 160
      });
    </script>
  <script type="text/javascript">
  
      $(document).ready(function (){
   
        $(document).on("change",'#blog_title_display_name',function(){
           var title=$("#blog_title_display_name").val();
    //   alert(title.toLowerCase().split(' ').join('-').replace(/[\*\^\'\!]/g, ''));
           $("#blog_slug").val(title.toLowerCase().split(' ').join('-').replace(/[\*\^\'\!]/g, ''));
        })  
       
   });
   
  
  
  
$("#SaveBtn").click(function(){
    var flag=1;
    var language_name = $('#language_name').val();
    var category = $('#category').val();
    var blog_slug = $('#blog_slug').val();
    var blog_title_display_name = $('#blog_title_display_name').val();
    var summernote = $('#summernote').val();
    var Menu_images = $('#Menu_images').val();
    var blog_status = $('#blog_status').val();
    if(language_name == '')
    {
         $("#language_name_msg").css('color','red');
         $("#language_name_msg").show();
         $("#language_name_msg").html('Select Language');
         flag=0;
    }
    if(category == '')
    {
         $("#category_msg").css('color','red');
         $("#category_msg").show();
         $("#category_msg").html('Select Blog Category');
         flag=0;
    }
    if(blog_slug == '')
    {
         $("#blog_slug_msg").css('color','red');
         $("#blog_slug_msg").show();
         $("#blog_slug_msg").html('Enter Blog Slug');
            flag=0;
    }
     if(blog_title_display_name == '')
    {
         $("#blog_title_display_name_msg").css('color','red');
         $("#blog_title_display_name_msg").show();
         $("#blog_title_display_name_msg").html('Enter Blog Title');
         flag=0;
    }
    if(summernote == '')
    {
         $("#summernote_msg").css('color','red');
         $("#summernote_msg").show();
         $("#summernote_msg").html('Enter Blog Description');
         flag=0;
    }
    if(Menu_images == '')
    {
         $("#Menu_images_msg").css('color','red');
         $("#Menu_images_msg").show();
         $("#Menu_images_msg").html('Upload Blog Image');
            flag=0;
    }
    if(blog_status == '')
    {
         $("#blog_status_msg").css('color','red');
         $("#blog_status_msg").show();
         $("#blog_status_msg").html('Select Status');
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
@endsection