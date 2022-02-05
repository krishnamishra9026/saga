@extends('ar-SA.layouts.default')
@section('content')

<?php
/*echo "<pre>";
print_r($SubcategoryProductList);
die;
*/

if(isset($productDetails) && !empty($productDetails))
{ 
?>
<section class="prd_single_page" >   
    <div class="container-fluid pb-5">
        <div class="row px-xl-5 flex-row-reverse">
            <div class="col-lg-5 mb-30">
                <div class="xzoom-container bg-light">
                  <img class="xzoom4" id="xzoom-fancy" src="{{ asset('images/products/'.$productDetails->image)}}" xoriginal="{{ asset('images/products/'.$productDetails->image)}}" />
                  <div class="xzoom-thumbs">
                  	<?php
                    $imageArray = explode('|',$productDetails->images);
                    foreach($imageArray as $image)
                    {
                    ?> 
                    <a href="{{ asset('images/products/'.$image)}}">
                        <img class="xzoom-gallery4" width="80" src="{{ asset('images/products/'.$image)}}"  xpreview="{{ asset('images/products/'.$image)}}" title="">
                    </a>
                    <?php }?>
                  </div>
                </div> 
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30 prd_right">
                    <h4>{{ isset($productDetails->name) ? $productDetails->name : '' }}</h4>
                    <table class="table-bordered table">
                        <tr>
                            <td>{{ isset($productDetails->sku_id) ? $productDetails->sku_id : '' }}</td>
                            <td>@if(session('locale')=='en')  Product SKU @else الرقم المميز للمنتج  @endif</td>
                        </tr>
                        <tr>
                            
                            <td>{{ (isset($productDetails->in_stock) &&  $productDetails->in_stock=='Yes') ? 'متوفر   ' : 'غير متوفر' }}</td>
                            <td>@if(session('locale')=='en')  Availability @else    التوفر       @endif</td>
                        </tr>
                    </table>

                    {{-- <div class="d-flex mb-3 flex-row-reverse">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(99 <!--Reviews-->  مراجعة    )</small>
                    </div> --}}

                    <form action="{{ route('cart.store') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $productDetails->id }}" id="id" name="id">
                        <input type="hidden" value="main_page" id="id" name="page">
                         <input type="hidden" value="{{ $productDetails->name }}" id="name" name="name">
                        <input type="hidden" value="{{ $productDetails->name_slug }}" id="slug" name="slug">
                        <input type="hidden" value="{{ $productDetails->quantity }}" id="product_quantity" name="product_quantity">
                        <input type="hidden" value="{{ asset('images/products/'.$imageArray[0])}}"  id="img" name="img">
                        <?php
                            $productPrice = 0;
                            if(isset($productDetails->discount_price) && !empty($productDetails->discount_price))
                            {
                                $productPrice = $productDetails->discount_price;
                                $gstAmount = (0/100)*$productPrice;
                                $ProductPriceWithGst = $productPrice+$gstAmount;
                                
                            }
                        ?>
                        <div class="font-weight-semi-bold d-inline-block">
                            
                            <div class="text-muted d-inline-block mr-3">
                                <!--<del>{{ isset($productDetails->price) ? $productDetails->price : '' }}    SAR </del>-->
                                <del class="d-inline-flex">
                                    
                                    <span> <!-- SAR --> ريال سعودي   </span>
                                    <span class="pl-2"> {{ isset($productDetails->price) ? $productDetails->price : '' }}</span>
                                </del>
                            </div>    
                                
                            <h6 class="text-muted d-inline-block">
                                <span class="h4" id ="ShowGetGstValue"></span>
                                <span><strong class="text-dark mr-0">  @if(session('locale')=='en')  Price @else  سعر    @endif</strong></span>
                                
                                <span  class="h4" id ="ShowOldGetGstValue">: {{ isset($ProductPriceWithGst) ? $ProductPriceWithGst : '' }} </span>  
                                <span class="h4"><!--SAR-->   ريال سعودي    </span> 
                            </h6>
                            
                            <div class="clearfix"></div>
                        </div>
                        <input type="hidden" value="{{ isset($ProductPriceWithGst) ? $ProductPriceWithGst : '' }}" id="price" name="price">
                        
                        <div class="d-flex mb-2 justify-content-end">
                            
                            <ul class="colorOptions" style="font-weight: 400; padding-left: 0px;margin-right: 5px;">
                                <li>{{ isset($productDetails->color) ? $productDetails->color : '' }}  </li>
                            </ul>
                            <strong class="text-dark mr-0"> : @if(session('locale')=='en')  Colors @else    الالوان        @endif </strong>
                            
                        </div>

                        @if(isset($productDetails->size))
                        <div class="d-flex mb-3 justify-content-end">
                            
                            <ul class="sizeOptions" style="font-weight: 400; padding-left: 0px;margin-right: 5px;">
                                <li>{{ isset($productDetails->size) ? $productDetails->size : '' }}  </li>
                            </ul>
                             <strong class="text-dark mr-0"> : @if(session('locale')=='en')  Sizes @else   الحجم      @endif</strong>

                        </div>
                        @endif
                        @if(count($attributes) > 0)
                        <div class="d-flex mb-3 justify-content-end">
                            
                            <div class="sizes">
                                @foreach($attributes as $key)
                              
                                <label class="radio"> 
                                    <input type="radio" name="size" value="{{ isset($key->value) ? $key->value : '' }}" checked>
                                <span>{{ isset($key->value) ? $key->value : '' }}</span> 
                                </label>
                                 @endforeach
                               </div>
                             <strong class="text-dark mr-0"> : @if(session('locale')=='en')  Sizes @else   الحجم  @endif</strong>

                        </div>
                        @endif

                        <div class="d-flex mb-2 justify-content-end">
                            
                            <ul class="colorOptions" style="font-weight: 400; padding-left: 0px;margin-right: 5px;">
                                <li>{{ isset($productDetails->serial_no) ? $productDetails->serial_no : '' }}</li>
                            </ul>
                            <strong class="text-dark mr-3">@if(session('locale')=='en')  BarCode @else  الباركود@endif :</strong>
                        </div>



                        <ol style="font-weight: 400; padding-left: 0px;margin-right: 5px;">
                            {{ isset($productDetails->short_discription) ? $productDetails->short_discription : '' }}
                        </ol>

                        <div class="d-flex mb-3 justify-content-end">
                            
                            <div class="input-group quantity mr-3" style="width: 150px;">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-minus btn-number"  onClick="getQuantity();"  data-id="{{ $productDetails->id }}" data-type="minus" data-field="quantity[1]">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>

                                <input type="text" class="form-control bg-secondary border-0 text-center" name="quantity[1]" id="get-quantity-count" data-min="1" data-max="1000" value="1">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-plus btn-number" onClick="getQuantity();" data-id="{{ $productDetails->id }}" data-type="plus" data-field="quantity[1]">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <strong class="text-dark mr-0"> : @if(session('locale')=='en')  Quantity @else      الكمية     @endif </strong>
                        </div>

                        <div class="d-flex align-items-center mb-4 pt-2">
                            <button class="btn btn-primary px-3 mr-1 w-100" data-toggle="modal" data-target="#addToCartModal">@if(session('locale')=='en')  Add to cart @else    اضف الى السلة     @endif <i class="fa fa-shopping-cart mr-1"></i></button>
                            <!-- <button class="btn btn-outline-dark px-3 ml-1 w-100">Buy Now</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4 justify-content-end">
                        
                        <!-- <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-21">@if(session('locale')=='en')  Information @else ربما يعجبك أيضا  ك@endif</a> -->
                        {{-- <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">@if(session('locale')=='en')  Reviews (0) @else   المراجعات      @endif</a> --}}
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">@if(session('locale')=='en')  Description @else   الوصف     @endif</a>
                    </div>

                    <div class="tab-content" >
                        <div class="tab-pane fade show active" id="tab-pane-1" style="font-weight: 400;direction: rtl;">
                            <h4 class="mb-3">@if(session('locale')=='en')  Product Description @else  وصف المنتج     @endif</h4>
                            <p style="padding-left: 0px;"><?=isset($productDetails->discription) ? $productDetails->discription : '' ?></p>
                        </div>

                        <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Additional Information</h4>
                            <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>

                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>

                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul> 
                                </div>

                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>

                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>

                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul> 
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">1 review for "Product Name"</h4>
                                    <div class="media mb-4">
                                        <div class="media-body">
                                            <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                            <div class="text-primary mb-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                        </div>
                                        <img src="{{ asset('images/user.jpg')}}" alt="Image" class="img-fluid ml-3 mt-1" style="width: 45px;">
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h4 class="mb-4"><!--Leave a review-->   وضع تعليقك   </h4>
                                    <small><!-- Your email address will not be published. Required fields are marked * -->   بريدك الالكتروني لن يتم نشره ،الخانات الالزامية معلمة ب *   </small>
                                    <div class="d-flex my-3 justify-content-end">
                                        <p class="mb-0 mr-2"><!--Your Rating-->   تقيمك       * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>

                                    <form>
                                        <div class="form-group">
                                            <label for="message"><!--Your Review-->   مراجعتك      *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="name"><!-- Your Name -->   الاسم   *</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>

                                        <div class="form-group">
                                            <label for="email"><!-- Your Email -->    يريدك الالكتروني      *</label>
                                            <input type="email" class="form-control" id="email">
                                        </div>

                                        <div class="form-group mb-0">
                                            <!--<input type="submit" value="Leave Your Review" class="btn btn-primary px-3">-->
                                            <input type="submit" value="  وضع تعليقك    " class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-5 prd_listing">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">@if(session('locale')=='en')  You May Also Like @else   ربما يعجبك ايضا         @endif</span></h2>
        <div class="row px-xl-5" style="direction: rtl;">
            <div class="col p-0">
                <div class="owl-carousel related-carousel-LtoR">
                <?php 
				if(isset($RelatedProductList) &&!empty($RelatedProductList)){
				foreach($RelatedProductList as $row ){
				$imageArray = explode('|',$row->images);
				$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
                $subcategory = DB::table('sub-category')->where('id','=',$row->sub_category_id)->where('status','=','1')->where('language_id','=',$languageId->id)->first();

				?>

                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <div id="prdSlider_8" class="carousel slide" data-ride="carousel" data-interval="15000">
                              <div class="carousel-inner">
                                <div class="carousel-item active">
                                  <img class="d-block w-100" src="{{ asset('images/products/'.$row->image)}}" alt="">
                                </div>
                              </div>
                            </div>

                                                     <div class="product-action">
                                <form action="{{ route('cart.store') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $row->id }}" id="id" name="id">
                                    <input type="hidden" value="main_page" id="id" name="page">
                                    <input type="hidden" value="{{ $row->name }}" id="name" name="name">
                                    <input type="hidden" value="{{ $row->name_slug }}" id="slug" name="slug">
                                    <input type="hidden" name="quantity[1]" id="get-quantity-count"  value="1">
                                    <input type="hidden" value="{{ $row->quantity }}" id="product_quantity" name="product_quantity">
                                    <input type="hidden" value="{{asset('images/products/'.$row->image)}}"  id="img" name="img">
                                    <?php
                                    $productPrice = 0;
                                    if(isset($row->discount_price) && !empty($row->discount_price))
                                        {
                                            $productPrice = $row->discount_price;
                                            $gstAmount = (0/100)*$productPrice;
                                            $ProductPriceWithGst = $productPrice+$gstAmount;
                                        }
                                    ?>
                                    <input type="hidden" value="{{ isset($ProductPriceWithGst) ? $ProductPriceWithGst : '' }}" id="price" name="price">

                                    <button class="btn btn-outline-dark btn-square" ><i class="fa fa-shopping-cart"></i></button>
                                </form>
                                    {{-- <a href="Javascript:void(0);" class="btn btn-outline-dark btn-square"><i class="fa fa-shopping-cart"></i></a> --}}


                                 <a class="btn btn-outline-dark btn-square" href="{{route('DemoSingleProduct',['id'=>$row->id])}}"><i class="far fa-eye"></i></a> 
                            </div>
                        </div>

                        <div class="text-center py-4 pl-2 pr-2">
                            <h2 class="h4"><a class="text-dark text-decoration-none text-truncate" href="{{ route('DemoSingleProduct',['id'=>$row->id]) }}">{{ isset($subcategory->name) ? $subcategory->name : ''}} @if(session('locale')=='en') @else من  ساغا   @endif</a></h2>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                @if(session('locale')=='en') 
                                <h5>{{ isset($row->discount_price) ? $row->discount_price : ''}} SAR</h5>
                                @else
                                <h5>{{ isset($row->discount_price) ? $row->discount_price : ''}} ريال سعودي</h5>
                                @endif
                                @if(session('locale')=='en') 
                                <h6 class="text-muted ml-2"><del>{{ isset($row->price) ? $row->price : ''}} SAR</del></h6>
                                @else
                                <h6 class="text-muted ml-2"><del>{{ isset($row->price) ? $row->price : ''}} ريال سعودي</del></h6>
                                @endif
                                
                            </div>

                            {{-- <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <!-- <small>(99)</small> -->
                            </div> --}}
                        </div>
                    </div>
                <?php }} ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}
else{
?>
<div class="row mt-5 ">
    <div class="col-12">
        <div class="section-title">
            <h5>No Product Details Available</h5>
        </div>
    </div>
</div>
<?php
}
?>

@endsection
@section('javascript')

<script type="text/javascript" src="{{asset('lib/xZoom-magnify/xzoom.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('lib/xZoom-magnify/xzoom.css')}}" media="all" /> 
<script type="text/javascript" src="{{asset('lib/xZoom-magnify/hammer.js/1.0.5/jquery.hammer.min.js')}}"></script>  
<link type="text/css" rel="stylesheet" media="all" href="{{asset('lib/xZoom-magnify/fancybox/source/jquery.fancybox.css')}}" />
<script type="text/javascript" src="{{asset('lib/xZoom-magnify/fancybox/source/jquery.fancybox.js')}}"></script>
<script src="{{asset('lib/xZoom-magnify/setup.js')}}"></script>


<style>
    .tab-content ul,
    .tab-content ol{
        direction: rtl;
    }
</style>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
 
 
 function removeFromCart(id)
{
			swal({
  title: "Are you sure?",
  text: "Once deleted, you have to add the product again",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Poof! Your product has been deleted!", {
      icon: "success",
    });

    $.ajax({
                    url: '{{route("RemoveFromCart")}}',
                    method: 'post',
                    data: {
					_token:'{{ csrf_token() }}', 
					id: id
					},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            
        

	} else {
    swal("Your product is safe!");
  }
});

}
 
 
function getQuantity()
{
	var Gstvalue = $('#getGstValue').val();
// 	var GstAmount = $('#getGstAmount').val();
	var productPrice = $('#price').val();
	var Quantity = $('#get-quantity-count').val();
	var finalQuantity = parseInt(Quantity)+1;
	var amount =finalQuantity*productPrice;
	var gstvaluecalculate = (0/100)*amount;
	var finalValue = gstvaluecalculate+amount;
    var finalAmount = finalValue.toFixed(1);
	$('#ShowGetGstValue').html(finalAmount);
	$("#ShowOldGetGstValue").addClass('d-none');


if(value == 2){
}

 }

 function starRating()
 {
	var value = $('#get-quantity-count').val();

 $discount = '{{$productDetails->price}}';
 $discountitem = '{{$productDetails->price}}';
alert(discountitem);
if(value == 2){
}

 }

$(function() {
  var $tabButtonItem = $('#tab-button li'),
      $tabSelect = $('#tab-select'),
      $tabContents = $('.tab-contents'),
      activeClass = 'is-active';

  $tabButtonItem.first().addClass(activeClass);
  $tabContents.not(':first').hide();

  $tabButtonItem.find('a').on('click', function(e) {
    var target = $(this).attr('href');

    $tabButtonItem.removeClass(activeClass);
    $(this).parent().addClass(activeClass);
    $tabSelect.val(target);
    $tabContents.hide();
    $(target).show();
    e.preventDefault();
  });

  $tabSelect.on('change', function() {
    var target = $(this).val(),
        targetSelectNum = $(this).prop('selectedIndex');

    $tabButtonItem.removeClass(activeClass);
    $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
    $tabContents.hide();
    $(target).show();
  });
});


$(".update-cart").click(function (e) {

var ele = $(this);
var quantity = $('#get-quantity-count').val();

// alert(ele.attr("data-id"));
 $.ajax({
	url: '{{ url('update-cart') }}',
	method: "post",
	data: {_token: '{{ csrf_token() }}', 
	id: ele.attr("data-id"), 
	quantity: quantity},
	success: function (response) {
		window.location.reload();
	}
 });
});

$(".remove-from-cart").click(function (e) {
 e.preventDefault();

 var ele = $(this);
 swal({
title: "Are you sure?",
text: "Once deleted, you have to add the product again",
icon: "warning",
buttons: true,
dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {
swal("Poof! Your product has been deleted!", {
icon: "success",
});

$.ajax({
		 url: '{{ url('remove-from-cart') }}',
		 method: "post",
		 data: {_token: '{{ csrf_token() }}', 
		 id: ele.attr("data-id")},
		 success: function (response) {
			 window.location.reload();
		 }
	 });
 


} else {
swal("Your product is safe!");
}
});

}); 
</script>

@endsection
@section('css')
<style>
    label.radio {
        cursor: pointer
    }
    
    label.radio input {
        position: absolute;
        top: 0;
        left: 0;
        visibility: hidden;
        pointer-events: none
    }
    
    label.radio span {
        padding: 2px 6px;
        border: 2px solid #212529;
        display: inline-block;
        color: #212529;
        border-radius: 3px;
        text-transform: uppercase
    }
    
    label.radio input:checked+span {
        border-color: #212529;
        background-color: #212529;
        color: #fff
    }
    </style>
@endsection