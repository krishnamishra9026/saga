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
            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
          </ol>
        </div>
      </div>
      
      <form action="{{route('SaveProduct')}}" enctype="multipart/form-data"  method="post" id="EditForm" name="EditForm" >
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="id" value="{{ $Result->id }}">

        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Edit Product</div>
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
                        <option value="{{$lang->id}}" <?php if( $lang->id==$Result->language_id) echo "selected"; ?>>{{$lang->language_name}}</option>
                        @endforeach
                        </select>
                        <span id="language_msg"></span>
                      </div> 
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="input-1">Product Serial Number</label>
                        <input type="text" class="form-control" id="serial_no" value="{{$Result->serial_no}}" name="serial_no" placeholder="PRODUCT NAME" onchange="HideErr('product_serial_no_msg')">
                         <span id="product_serial_no_msg"></span>
                      </div> 
                    </div>


                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="input-1">Product Name</label>
                        <input type="text" class="form-control" id="name" value="{{$Result->name}}" name="name" placeholder="PRODUCT NAME" onchange="HideErr('product_name_msg')">
                         <span id="product_name_msg"></span>
                      </div> 
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="input-1">Slug</label>
                        <input type="text" class="form-control" value="{{$Result->name_slug}}" id="product_name_slug" name="product_slug" onkeyup="HideErr('product_slug_msg')" readonly>
                        <span id="product_slug_msg"></span>
                      </div> 
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                      <label for="input-1">Price</label>
                          <input type="text" class="form-control" value="{{$Result->price}}" id="price" name="price" placeholder="PRICE" onchange="HideErr('price_msg')" >
                          <span id="price_msg"></span> 
                    </div>
                  </div>

                  <div class="col-sm-2">
                      <div class="form-group">
                      <label for="input-1">Discount Price</label>
                          <input type="text" class="form-control" value="{{$Result->discount_price}}" id="discount_price" name="discount_price" placeholder="DISCOUNT PRICE" onchange="HideErr('discount_price_msg')" >
                          <span id="discount_price_msg"></span> 
                    </div>
                  </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="input-1">Quantity</label>
                        <input type="text" class="form-control" value="{{$Result->quantity}}" id="quantity" name="quantity" placeholder="QUANTITY" onchange="HideErr('quantity_msg')">
                        <span id="quantity_msg"></span> 
                      </div>
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">SKU Id</label>
                      <input type="text" class="form-control" value="{{$Result->sku_id}}" id="sku_id" name="sku_id" placeholder="SKU ID" onchange="HideErr('sku_id_msg')"  >
                    <span id="sku_id_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-4">
                      <div class="form-group">
                          <label for="input-1">Category</label>
                          <select class="form-control" id="category_id" name="category_id" onchange="getCategoryList(this)">
                            <option value="">Select</option>
                            @foreach ($categories as $category) {
                          <option value="<?php echo $category->id; ?>" <?php if( $category->id==$Result->category_id) echo "selected"; ?>><?php echo $category->category_name; ?></option>
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
                            <?php
                        
                        if(!empty($subCategories))
                        {
                        ?>
                        <option value="<?php echo $subCategories->id; ?>"><?php echo $subCategories->name; ?></option>

                          <?php
                        }
                        else
                        {
                         ?>   
                    <option value="">Select</option>
   
                            
                        <?php    
                        }
                        ?>
                        </select>     
                      </span>
                        <span id="sub-category_msg"></span>
                      </div> 
                  </div>

                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Size </label>
                      <input type="text" class="form-control" value="{{$Result->size}}" id="size_id" name="size_id" onchange="HideErr('size_id_msg')"  placeholder="SIZE" >
                     <span id="size_id_msg"></span>
                    </div> 
                  </div>

                  <!-- <div class="col-sm-2">
                      <div class="form-group">
                          <label for="input-1">Color</label>
                          <select class="form-control" id="color_id" name="color_id">
                            <option value="">Select</option>
                            @foreach($color as $row)
                            <option value="<?php echo $row->name; ?>" <?php if($row->name==$Result->color) echo "selected"; ?>><?php echo $row->name; ?></option>
                            @endforeach
                        </select>
                        <span id="color_id_msg"></span>
                      </div> 
                  </div> -->

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Color </label>
                      <input type="text" class="form-control" value="{{$Result->color}}" id="color_id" name="color_id" onchange="HideErr('color_id_msg')"  placeholder="COLOR" >
                     <span id="color_id_msg"></span>
                    </div> 
                  </div>

                  
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Start Rating </label>
                      <input type="text" class="form-control" value="{{$Result->start_rating}}" id="start_rating" name="start_rating" onchange="HideErr('start_rating_msg')"  placeholder="START RATING" >
                     <span id="start_rating_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Weight (GRM)</label>
                      <input type="text" class="form-control" value="{{$Result->weight}}" id="weight_products" name="weight_products" onchange="HideErr('weight_products_msg')"  placeholder="WEIGHT" >
                     <span id="weight_products_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">Material </label>
                      <input type="text" class="form-control" value="{{$Result->material}}" id="material_products" name="material_products" onchange="HideErr('material_products_msg')"  placeholder="MATERIAL" >
                     <span id="material_products_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-4">
                        <div class="form-group">
                          <label for="input-1">Discount Title</label>
                          <input type="text" class="form-control"  value="{{$Result->discount_title}}"  id="discount_title" name="discount_title" onchange="HideErr('discount_title_msg')" placeholder="DISCOUNT TITLE"  >
                          <span id="discount_title_msg"></span> 
                      </div> 
                    </div>
                      
                    <div class="col-sm-2">
                      <div class="form-group">
                            <label for="input-1">Discount Percent(%):</label>
                            <input type="text" class="form-control"  value="{{$Result->discount_percent}}"  id="discount_percent" name="discount_percent" onchange="HideErr('discount_percent_msg')" placeholder="% (PERCENT)"    >
                        <span id="discount_percent_msg"></span>
                        </div> 
                    </div>   

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="input-1">In Stock </label>
                      <select class="form-control" id="in_stock" name="in_stock">
                        <option value="">Select</option>
                        <option value="Yes" <?php if($Result->in_stock=='Yes') echo "selected"; ?>>Yes</option>
                        <option value="No" <?php if($Result->in_stock=='No') echo "selected"; ?>>No</option>
                    </select>
                     <span id="in_stock_msg"></span>
                    </div> 
                  </div>

              </div>



                  <div class="row">

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Description</label>
                      <textarea class="form-control" id="summernote_product_description"  onchange="HideErr('summernote_product_description_msg')"  name="product_discription">{{ $Result->discription }}</textarea>
                      <span id="summernote_product_description_msg"></span>
                    </div> 
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group " >
                      <label for="input-1">Short Description</label>
                      <textarea class="form-control " id="summernote_product_short_discription" onchange="HideErr('summernote_product_short_discription_msg')"  name="product_short_discription">{{ $Result->short_discription }}</textarea>
                      <span id="summernote_product_short_discription_msg"></span>

                    </div> 
                  </div>




               </div>

               <div class="row">
         
      
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Product Image</label>
                      <input type="file" style="height:45px;" class="form-control" id="product_images"  name="product_images" placeholder="Multiple Images"  multiple><br>
                      <a><button type="button" class="btn btn-success" data-toggle="modal" data-target="#Product_imagesModal">View image</button></a>
                      <div class="modal fade" id="Product_imagesModal" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Product Image</h4>
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
                                    <td class="FontSize"><img  width="100" height="100" src="{{ url('/upload/prd/'.$img) }}"></td>


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
                      <label for="input-1">Gallery Images</label>
                      <input type="file" style="height:45px;" class="form-control" id="product_gallery_images"  name="product_gallery_images[]" placeholder="Multiple Images"   multiple><br>
                      <a><button type="button" class="btn btn-success" data-toggle="modal" data-target="#Gallery_imagesModal">View Gallery</button></a>
                      <div class="modal fade" id="Gallery_imagesModal" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Gallery Gallery</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                             </div>
                               <div style="height: 500px;overflow-y: auto;">

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
                                   $imageArray = explode('|',$Result->images);

                                    $i=1;
                                   foreach($imageArray as $img)
                                   {
                                    if(!empty($img))
                                    {
                                    ?>
                                    <tr>
                                    <td class="FontSize"><img  width="100" height="100" src="{{ url('/upload/prd/'.$img) }}"></td>


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
                      <select class="form-control" id="product_status" name="status"  onchange="HideErr('product_status_msg')" >
                        <option value="1" @if($Result->status==1) {{"selected"}} @endif >Active</option>
                        <option value="0" @if($Result->status==0) {{"selected"}} @endif >De-Active</option>
                      </select>
                      <span id="product_status_msg"></span>
                    </div> 
                  </div>
                
                
                </div>

                <div class="form-group">
                  <button type="button" class="btn btn-primary  pull-right" id="SaveEditBtn">Save</button>
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
<!-- <script src="{{ asset('Admin/assets/validation/Product.js')}}"></script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
  
  $("#SaveEditBtn").click(function(){
    
    var flag=1;
    var language_name = $('#language_name').val();
    var serial_no = $('#serial_no').val();
    var name = $('#name').val();
    var price = $('#price').val();
    var quantity = $('#quantity').val();
    var category = $('#category').val();
    // var sub_category = $('#sub-category-aac-to-category').val();
    // var concern = $('#concern-aac-to-category').val();
    var product_type_status = $('#product_type_status').val();
    // var Menu_images = $('#Menu_images').val();
    var available_products = $('#available_products').val();
    var GST = $('#GST').val();
    // var discount_title = $('#discount_title').val();
    // var discount_amount = $('#discount_amount').val();
    // var discount_on_number_of_product_items = $('#discount_on_number_of_product_items').val();
    // var number_of_items_discount_applied = $('#number_of_items_discount_applied').val();
    var summernote_product_description = $('#summernote_product_description').val();
    

    var summernote_product_short_discription = $('#summernote_product_short_discription').val();
    var terms_and_conditions = $('#terms_and_conditions').val();
    var product_status = $('#product_status').val();
    var sku_id = $('#sku_id').val();
    
    if(language_name == '')
    {
         $("#language_msg").css('color','red');
         $("#language_msg").show();
         $("#language_msg").html('Select Language');
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
         $("#product_name_msg").html('Select name');
         flag=0;
    }
      
    if(price == '')
    {
         $("#price_msg").css('color','red');
         $("#price_msg").show();
         $("#price_msg").html('Select Language');
         flag=0;
        }

    if(quantity == '')
    {
         $("#quantity_msg").css('color','red');
         $("#quantity_msg").show();
         $("#quantity_msg").html('Select name');
         flag=0;
    }
    
     if(category == '')
    {
        
         $("#category_msg").css('color','red');
         $("#category_msg").show();
         $("#category_msg").html('Select name');
         flag=0;
         
    }
    //   if(sub_category == '')
    // {
        
    //      $("#sub-category-aac-to-category_msg").css('color','red');
    //      $("#sub-category-aac-to-category_msg").show();
    //      $("#sub-category-aac-to-category_msg").html('Select Sub Category');
    //      flag=0;
         
    // }
    //   if(concern == '')
    // {
        
    //      $("#concern-aac-to-category_msg").css('color','red');
    //      $("#concern-aac-to-category_msg").show();
    //      $("#concern-aac-to-category_msg").html('Select Concern');
    //      flag=0;
         
    // }
  if(product_type_status == '')
    {
          $("#product_type_status_msg").css('color','red');
         $("#product_type_status_msg").show();
         $("#product_type_status_msg").html('Select Status');
         flag=0;
     }
    
  

    if(available_products == '')
    {
        
        $("#available_products_msg").css('color','red');
         $("#available_products_msg").show();
         $("#available_products_msg").html('Enter Available Product.');
         flag=0;
    }


   if(GST == '')
    {
        
        $("#GST_msg").css('color','red');
        $("#GST_msg").show();
        $("#GST_msg").html('Enter Product GST.');
         flag=0;
    }
    
    //  if(discount_title == '')
    // {
        
    //     $("#discount_title_msg").css('color','red');
    //      $("#discount_title_msg").show();
    //      $("#discount_title_msg").html('Enter Discount Title.');
    //      flag=0;
    // } if(discount_amount == '')
    // {
        
    //     $("#discount_amount_msg").css('color','red');
    //      $("#discount_amount_msg").show();
    //      $("#discount_amount_msg").html('Enter Discount Amount.');
    //      flag=0;
    // } 
    
    // if(discount_on_number_of_product_items == '')
    // {
        
    //     $("#discount_on_number_of_product_items_msg").css('color','red');
    //      $("#discount_on_number_of_product_items_msg").show();
    //      $("#discount_on_number_of_product_items_msg").html('Enter Discount On Number Of Product Items.');
    //      flag=0;
    // } 
    
    // if(number_of_items_discount_applied == '')
    // {
        
    //     $("#number_of_items_discount_applied_msg").css('color','red');
    //      $("#number_of_items_discount_applied_msg").show();
    //      $("#number_of_items_discount_applied_msg").html('Enter Number Of Items Discount Applied.');
    //      flag=0;
    // }
    
     if(summernote_product_description == '')
    {
       $("#summernote_product_description_msg").css('color','red');
         $("#summernote_product_description_msg").show();
         $("#summernote_product_description_msg").html('Enter Product Description');
         flag=0;
    }
    
    
      if(summernote_product_short_discription == '')
    {
        
        $("#summernote_product_short_discription_msg").css('color','red');
         $("#summernote_product_short_discription_msg").show();
         $("#summernote_product_short_discription_msg").html('Enter Product Short Description');
         flag=0;
        
     }
    
       if(terms_and_conditions == '')
    {
        
        $("#terms_and_conditions_msg").css('color','red');
         $("#terms_and_conditions_msg").show();
         $("#terms_and_conditions_msg").html('Enter Product Terms And Conditions');
         flag=0;
        
     } 
     

      if(product_status == '')
    {
         $("#product_status_msg").css('color','red');
         $("#product_status_msg").show();
         $("#product_status_msg").html('Enter Product Status');
         flag=0;
        
    }
    
    if(sku_id == '')
    {
    $("#sku_id_msg").css('color','red');
         $("#sku_id_msg").show();
         $("#sku_id_msg").html('Enter Product Sku Id ');
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

 <script>

$('#summernote_product_short_discription').summernote({
        placeholder: 'Product Short Description',
        tabsize: 2,
        height: 160
      });
      

      $('#summernote_product_description').summernote({
        placeholder: 'Product Description',
        tabsize: 2,
        height: 160
      });

      $('#summernote_terms_and_conditions').summernote({
        placeholder: 'Product Terms And Conditions',
        tabsize: 2,
        height: 160
      });
      $(document).ready(function(){
    var maxField = 10;
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper');
    var fieldHTML = '<tr>'+
                        '<td><input type="text" class="form-control" name="quantity[]" placeholder="Enter Qty" required></td>'+
                        '<td><input type="text" class="form-control" name="price[]" placeholder="Enter Price" required></td>'+
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
        console.log('Hi');
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

@endsection