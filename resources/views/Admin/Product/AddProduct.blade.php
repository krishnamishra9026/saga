@extends('Admin.default')

@section('content')
  
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Product')}}">Product List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Product</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('InsertProduct')}}" enctype="multipart/form-data" method="post" id="AddForm" name="AddForm"  autocomplete="off">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Add Product</div>
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
	                      <select class="form-control" id="language_name" name="language_id" onchange="clcked(this);">
	                        <option value="">Select</option>
	                        @foreach( $Language as $lang)
	                        <option value="{{$lang->id}}">{{$lang->language_name}}</option>
	                        @endforeach
	                      </select>
	                      <span id="language_msg"></span>
	                    </div> 
                  	</div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="input-1">Product Serial Number</label>
                        <input type="text" class="form-control" id="serial_no" name="serial_no" placeholder="PRODUCT SERIAL NUMBER" onchange="HideErr('product_serial_no_msg')">
                         <span id="product_serial_no_msg"></span>
                      </div> 
                    </div>


                  	<div class="col-sm-6">
	                    <div class="form-group">
	                      <label for="input-1">Product Name</label>
	                      <input type="text" class="form-control" id="name" name="name" placeholder="PRODUCT NAME" onchange="HideErr('product_name_msg')">
	                       <span id="product_name_msg"></span>
	                    </div> 
                  	</div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="input-1">Slug</label>
                        <input type="text" class="form-control" id="product_name_slug" name="product_slug" onkeyup="HideErr('product_slug_msg')" readonly>
                        <span id="product_slug_msg"></span>
                      </div> 
                    </div>

                  	<div class="col-sm-2">
	                    <div class="form-group">
	                    <label for="input-1">Price</label>
	                      	<input type="text" class="form-control" id="price" name="price" placeholder="PRICE" onchange="HideErr('price_msg')" >
	                        <span id="price_msg"></span> 
	                	</div>
                	</div>

                  <div class="col-sm-2">
                      <div class="form-group">
                      <label for="input-1">Discount Price</label>
                          <input type="text" class="form-control" id="discount_price" name="discount_price" placeholder="DISCOUNT PRICE" onchange="HideErr('discount_price_msg')" >
                          <span id="discount_price_msg"></span> 
                    </div>
                  </div>

                  	<div class="col-sm-2">
	                    <div class="form-group">
		                    <label for="input-1">Quantity</label>
		                    <input type="text" class="form-control" id="quantity" name="quantity" placeholder="QUANTITY" onchange="HideErr('quantity_msg')">
		                    <span id="quantity_msg"></span> 
	                  	</div>
	                </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">SKU Id</label>
                      <input type="text" class="form-control" value="" id="sku_id" name="sku_id" placeholder="SKU ID" onchange="HideErr('sku_id_msg')"  >
                    <span id="sku_id_msg"></span>
                    </div> 
                  </div>

	                <div class="col-sm-4">
	                    <div class="form-group">
	                      	<label for="input-1">Category</label>
                          <select class="form-control" id="category_id" name="category_id" onchange="getCategoryList(this)">
		                        <option value="">Select</option>
		                        @foreach ($categories as $category) {
		                        <option value="<?php echo $category->id; ?>" ><?php echo $category->category_name; ?></option>
		                        @endforeach
	                    	</select>
	                    	<span id="category_msg"></span>
	                    </div> 
	                </div>
	                  
	                <div class="col-sm-4">
	                    <div class="form-group">
	                      	<label for="input-1">Sub Category</label>
                          <span id="subcategorylist">
	                      	<select class="form-control" id="sub_category_id" name="sub_category_id" >
	                        	<option value="">Select</option>
	                    	</select>     
                      </span>
	                    	<span id="sub-category_msg"></span>
	                    </div> 
	                </div>

                  <!-- <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Size</label>
                      <span id="sizelist">
                      <select class="form-control" id="size_id" name="size_id">
                        <option value="">Select</option>
                    </select>
                    </span>
                    <span id="size_id_msg"></span>
                    </div> 
                  </div> -->

                   <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Size </label>
                      <input type="text" class="form-control" value="" id="size_id" name="size_id" onchange="HideErr('size_id_msg')"  placeholder="SIZE" >
                     <span id="size_id_msg"></span>
                    </div> 
                  </div>


                  <!-- <div class="col-sm-2">
                      <div class="form-group">
                          <label for="input-1">Color</label>
                          <select class="form-control" id="color_id" name="color_id">
                            <option value="">Select</option>
                            @foreach ($color as $row) {
                            <option value="<?php echo $row->name; ?>" ><?php echo $row->name; ?></option>
                            @endforeach
                        </select>
                        <span id="color_id_msg"></span>
                      </div> 
                  </div> -->

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Color </label>
                      <input type="text" class="form-control" value="" id="color_id" name="color_id" onchange="HideErr('color_id_msg')"  placeholder="COLOR" >
                     <span id="color_id_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Start Rating </label>
                      <input type="text" class="form-control" value="" id="start_rating" name="start_rating" onchange="HideErr('start_rating_msg')"  placeholder="START RATING" >
                     <span id="start_rating_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Weight (GRM)</label>
                      <input type="text" class="form-control" value="" id="weight_products" name="weight_products" onchange="HideErr('weight_products_msg')"  placeholder="WEIGHT" >
                     <span id="weight_products_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Material </label>
                      <input type="text" class="form-control" value="" id="material_products" name="material_products" onchange="HideErr('material_products_msg')"  placeholder="MATERIAL" >
                     <span id="material_products_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-4">
                        <div class="form-group">
                          <label for="input-1">Discount Title</label>
                          <input type="text" class="form-control"  value=""  id="discount_title" name="discount_title" onchange="HideErr('discount_title_msg')" placeholder="DISCOUNT TITLE"  >
                          <span id="discount_title_msg"></span> 
                      </div> 
                    </div>
                      
                    <div class="col-sm-2">
                      <div class="form-group">
                            <label for="input-1">Discount Percent(%):</label>
                            <input type="text" class="form-control"  value=""  id="discount_percent" name="discount_percent" onchange="HideErr('discount_percent_msg')" placeholder="% (PERCENT)"    >
                        <span id="discount_percent_msg"></span>
                        </div> 
                    </div>   

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">In Stock </label>
                      <select class="form-control" id="in_stock" name="in_stock">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                     <span id="in_stock_msg"></span>
                    </div> 
                  </div>

	            </div>
                  
                
                
                <div class="row">
					<div class="col-sm-6">
						<div class="form-group " >
							<label for="input-1">Description</label>
							<textarea class="form-control" value="" id="summernote_product_description" name="product_discription" onchange="HideErr('summernote_product_description_msg')"  ></textarea>
							<span id="summernote_product_description_msg"></span>
						</div> 
					</div>

                 	<div class="col-sm-6">
	                    <div class="form-group " >
							<label for="input-1">Short Description</label>
							<textarea class="form-control " value="" id="summernote_product_short_discription"  onchange="HideErr('summernote_product_short_discription_msg')" name="product_short_discription"></textarea>
							<span id="summernote_product_short_discription_msg"></span>
	                    </div> 
                    </div>

				</div>
                  
                <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="input-1">Product Image</label>
                          <input type="file" class="form-control" id="product_images" name="product_images" placeholder="Image" onchange="HideErr('product_images_msg')">
                        <span id="product_images_msg"></span>
                      </div> 
                  </div>

                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="input-1">Gallery Images</label>
                          <input type="file" class="form-control" id="product_gallery_images" name="product_gallery_images[]" placeholder="Multiple Images" onchange="HideErr('product_gallery_images_msg')"  multiple>
                        <span id="product_gallery_images_msg"></span>
                      </div> 
                  </div>

                   	<div class="col-sm-4">
	                    <div class="form-group">
	                      <label for="input-1">Status</label>
	                      <select class="form-control" id="product_status" name="status"  onchange="HideErr('product_status_msg')" >
	                        <option value="">Select</option>
	                         <option value="1">Active</option>
	                        <option value="0">De-Active</option>
	                      </select>
	                    <span id="product_status_msg"></span>
	                    </div> 
                  	</div>

					
                </div>

                <div class="form-group">
                  <button type="button" class="btn btn-primary pull-right" id="SaveBtn">Save</button>
                </div>

              </div>
            </div>
          </div>
          
        </div>
      </form>
    </div>
  </div>  
@endsection

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->

@section('javascript')


  <script type="text/javascript">

function clcked(node)
{
  var valueId = $(node).val();
if(valueId != 1)
{

  $('#productSlug').css('display','block');

  
$.ajax({


url: "{{route('FetchproductListSlug')}}",
          method: "post",
          headers:{
      'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
          data: {
            action:'fetch'
            
              
          },
          success: function (data) {  
              dataArray = JSON.parse(data);  
if(dataArray.status == 'success')
{

$('#name_slug').html(dataArray.product_slug);

}

},



});


}

  
}

$("#SaveBtn").click(function(){
    
    
    var flag=1;
    var language_name = $('#language_name').val();
    var serial_no = $('#serial_no').val();
    var name = $('#name').val();
    var price = $('#price').val();
    var quantity = $('#quantity').val();
    var category = $('#category').val();
    var product_images = $('#product_images').val();
    var product_gallery_images = $('#product_gallery_images').val();
    var summernote_product_description = $('#summernote_product_description').val();
    var summernote_product_short_discription = $('#summernote_product_short_discription').val();
    var product_status = $('#product_status').val();
    var sku_id = $('#sku_id').val();
    var size_id = $('#size_id').val();
    var color_id = $('#color_id').val();
    var material_products = $('#material_products').val();
    var weight_products = $('#weight_products').val();
    var in_stock = $('#in_stock').val();
    
    if(language_name == '')
    {
         $("#language_msg").css('color','red');
         $("#language_msg").show();
         $("#language_msg").html('SELECT LANGUAGE');
         flag=0;
        }

    if(serial_no == '')
    {
         $("#product_serial_no_msg").css('color','red');
         $("#product_serial_no_msg").show();
         $("#product_serial_no_msg").html('ENTER SERIAL NUMBER');
         flag=0;
    }

    if(name == '')
    {
         $("#product_name_msg").css('color','red');
         $("#product_name_msg").show();
         $("#product_name_msg").html('ENTER PRODUCT NAME');
         flag=0;
    }
      
    if(price == '')
    {
         $("#price_msg").css('color','red');
         $("#price_msg").show();
         $("#price_msg").html('ENTER PRICE');
         flag=0;
        }

    if(quantity == '')
    {
         $("#quantity_msg").css('color','red');
         $("#quantity_msg").show();
         $("#quantity_msg").html('ENTER QUANTITY');
         flag=0;
    }
    
     if(category == '')
    {
        
         $("#category_msg").css('color','red');
         $("#category_msg").show();
         $("#category_msg").html('SELECT CATEGORIES');
         flag=0;
         
    }
    
       if(product_images == '')
    {
         $("#product_images_msg").css('color','red');
         $("#product_images_msg").show();
         $("#product_images_msg").html('SELECT PRODUCT IMAGE');
         flag=0;
    }
    

   if(product_gallery_images == '')
    {
         $("#product_gallery_images_msg").css('color','red');
         $("#product_gallery_images_msg").show();
         $("#product_gallery_images_msg").html('SELECT GALLERY IMAGE');
         flag=0;
    }
    
     if(summernote_product_description == '')
    {
       $("#summernote_product_description_msg").css('color','red');
         $("#summernote_product_description_msg").show();
         $("#summernote_product_description_msg").html('ENTER DESCRIPTION');
         flag=0;
    }
    
    
      if(summernote_product_short_discription == '')
    {
        
        $("#summernote_product_short_discription_msg").css('color','red');
         $("#summernote_product_short_discription_msg").show();
         $("#summernote_product_short_discription_msg").html('ENTER SHORT DESCRIPTION');
         flag=0;
        
     }
     

      if(product_status == '')
    {
         $("#product_status_msg").css('color','red');
         $("#product_status_msg").show();
         $("#product_status_msg").html('SELECT PRODUCT STATUS');
         flag=0;
        
    }
    
    if(sku_id == '')
    {
    $("#sku_id_msg").css('color','red');
         $("#sku_id_msg").show();
         $("#sku_id_msg").html('ENTER PRODUCT SKU ID ');
         flag=0;

    }

    if(size_id == '')
    {
    $("#size_id_msg").css('color','red');
         $("#size_id_msg").show();
         $("#size_id_msg").html('SELECT SIZE');
         flag=0;

    }

    if(color_id == '')
    {
    $("#color_id_msg").css('color','red');
         $("#color_id_msg").show();
         $("#color_id_msg").html('SELECT COLOR');
         flag=0;

    }

    if(material_products == '')
    {
    $("#material_products_msg").css('color','red');
         $("#material_products_msg").show();
         $("#material_products_msg").html('ENETR MATERIAL');
         flag=0;

    }

    if(weight_products == '')
    {
    $("#weight_products_msg").css('color','red');
         $("#weight_products_msg").show();
         $("#weight_products_msg").html('ENTER WEIGHT');
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


<!-- <script src="{{ asset('Admin/assets/validation/Product.js')}}"></script> -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->


<script>

$('#summernote_product_short_discription').summernote({
        placeholder: 'PRODUCT SHORT DESCRIPTION',
        tabsize: 2,
        height: 160,
        lang: "hindi"
      });
      

 $('#summernote_product_description').summernote({
        placeholder: 'PRODUCT DESCRIPTION',
        tabsize: 2,
        height: 160,
        lang: "hindi"
      });
      

      $(document).ready(function(){
    var maxField = 10;
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper');
    var fieldHTML = '<tr>'+
                        '<td><input type="text" class="form-control" name="quantity[]" placeholder="Enter Qty"   ></td>'+
                        '<td><input type="text" class="form-control" name="price[]" placeholder="Enter Price"   ></td>'+
                        '<td><a href="javascript:void(0);" class="remove_button"><i class="fa fa-minus" aria-hidden="true"></i></a></td>'+
                    '</tr>'; 
    var x = 1;
    $(addButton).click(function(){
        if(x < maxField){ 
            x++;
            $(wrapper).append(fieldHTML);
        }
    });
    
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parents('tr').remove();
        x--;
    });
});

      
      
    </script>
<script>



function getSubCategoryList(node)
{
var categoryId = $(node).val();

$("#category_msg").hide();

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

$('#sub_category_id').html(dataArray.data_sub);

}

  },



});


}
// $('#product_type_status').selectpicker();

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


function getSizeList(node)
{
  var category_id = $(node).val();

  $.ajax({

      url: "{{route('FetchSizeList')}}",
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
      $("#sizelist").html(dataArray.data_size);
    }
    },

  });
}

function getColorList(node)
{
var sizeId = $(node).val();


$.ajax({


  url: "{{route('FetchColorList')}}",
            method: "post",
            headers:{
        'X-CSRF-TOKEN' : '{{ csrf_token() }}'
    },
            data: {
              action:'fetch',
              sizeId:sizeId
                
            },
            success: function (data) {  
                dataArray = JSON.parse(data);  
if(dataArray.status == 'success')
{

  $("#colorlist").html(dataArray.data_color);

}

  },
});


}

$(document).ready(function (){
   
        $(document).on("change",'#name',function(){
           var title=$("#name").val();
    //   alert(title.toLowerCase().split(' ').join('-').replace(/[\*\^\'\!]/g, ''));
           $("#product_name_slug").val(title.toLowerCase().split(' ').join('-').replace(/[\*\^\'\!]/g, ''));
        })  
       
   });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>

@endsection