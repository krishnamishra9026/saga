@extends('Admin.default')

@section('content')
  
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Menu')}}">Menu List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Menu</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveMenu')}}" enctype="multipart/form-data" method="post" id="EditMenuPageForm" name="EditForm" >
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="edit_id" value="{{ $Result->id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit Menu</div>
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
                      <label for="input-1">Name</label>
                      <input type="text" class="form-control" id="name" value="{{$Result->name}}" name="name" placeholder="Name" >
                                         <span id="name_msg"></span>

                    </div> 

                  </div>
                   <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Slug</label>
                      <input type="text" class="form-control" id="slug" value="{{$Result->slug}}" name="slug" placeholder="slug" >
                                      <span id="slug_msg"></span>

                    </div>

                  </div>
                  
                  <div class="col-sm-6">
                    <div class="form-group " >
                      <label for="input-1">Description</label>
                      <textarea class="form-control" value="" id="summernote_page_description" name="page_discription" onchange="HideErr('summernote_product_description_msg')"  >{{$Result->page_discription}}</textarea>
                      <span id="summernote_page_description_msg"></span>

                    </div> 
                  </div>
                  
                  <div class="col-sm-4">
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
                <div class="form-group">
                  <button type="button" class="btn btn-primary  pull-right" id="SaveMenuPageBtn">Save</button>
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
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
     <script>
    
$('#summernote_page_description').summernote({
        placeholder: 'Menu Page Description',
        tabsize: 2,
        height: 160,
        lang: "hindi"
      });
    
     </script>
     
       <script type="text/javascript">



$("#SaveMenuPageBtn").click(function(){
    
    
    var flag=1;
    var name = $('#name').val();
    var slug = $('#slug').val();
    var summernote_page_description = $('#summernote_page_description').val();
    var status = $('#status').val();
    var language_name = $('#language_name').val();

     if(language_name == '')
    {
         $("#language_name_msg").css('color','red');
         $("#language_name_msg").show();
         $("#language_name_msg").html('Enter Language');
         flag=0;
    }

    if(name == '')
    {
         $("#name_msg").css('color','red');
         $("#name_msg").show();
         $("#name_msg").html('Enter Name');
         flag=0;
        }

    if(slug == '')
    {
         $("#slug_msg").css('color','red');
         $("#slug_msg").show();
         $("#slug_msg").html('Enter Slug');
         flag=0;
    }
      
    if(summernote_page_description == '')
    {
         $("#summernote_page_description_msg").css('color','red');
         $("#summernote_page_description_msg").show();
         $("#summernote_page_description_msg").html('Enter Page Description');
         flag=0;
        }

  
      if(status == '')
    {
         $("#status_msg").css('color','red');
         $("#status_msg").show();
         $("#status_msg").html('Enter Status');
         flag=0;
        
    }
    
  

    if(flag==1)
     {
      $( "#EditMenuPageForm" ).submit();
     }
});

function HideErr(id)
 { 
      $("#"+id).hide();
 }  
</script>

@endsection