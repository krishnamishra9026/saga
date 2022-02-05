@extends('en-SA/layouts.default')
@section('content')

<?php
/*echo "<pre>";
print_r($categoryProductList);
die;*/

$languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
$categoryList = DB::table('category')->where('id','=',$categoryProductList->category_id)->where('status','=','1')->where('language_id','=',$languageId->id)->first();
$subcategoryList = DB::table('sub-category')->where('category_id','=',$categoryList->id)->where('status','=','1')->where('language_id','=',$languageId->id)->get();
/*echo "<pre>";
print_r($subcategoryList);
die;*/
?>

<section class="main_prd_listing"> 
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-2 col-md-2">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="d-inline-block bg-secondary pr-3">@if(session('locale')=='en') Categories @else فئات   @endif </span></h5>
                <div class="bg-light p-4 mb-30">
                    <div class="col-md">
                        <h3><span style="font-size: 18px;" class="text-uppercase mb-3">{{ isset($categoryList->category_name) ? $categoryList->category_name : '' }}</span></h3>
                        <?php
                        foreach($subcategoryList as $row) {
                        ?>
                        <a href="{{route('ProductListingOfSubcategory',['id'=>$row->id])}}" style="font-size: 15px; color: black;" class="section-title position-relative text-uppercase mb-3">{{ isset($row->name) ? $row->name : '' }}</a><br>
                        <?php }?>
                    </div>
                </div>

                <h5 class="section-title position-relative text-uppercase mb-3"><span class="d-inline-block bg-secondary pr-3">@if(session('locale')=='en') Price Filter @else  مرشح السعر ف@endif  </span></h5>
                <div class="bg-light d-flex p-4 mb-30" style="height: 80px">
                    <input type="text" name="fromVal" class="fromVal" id="fromVal" style="width: 100%; float: left;" placeholder="SAR">-
                    <input type="text" name="toVal" class="toVal" id="toVal" style="width: 100%; " placeholder="SAR">
                    <button type="submit" class="btn btn-primary btn-sm"  onclick="Search()">@if(session('locale')=='en') APPLY @else تطبيق   @endif </button>
                </div>
                <!-- <div class="bg-light p-4 mb-30">
                    <div class="custom-control">
                        <input type="checkbox" checked id="FilterByPrice[]" value="0" name="FilterByPrice[]" class="FilterByPrice">
                        <label for="price-all">All Price</label>
                    </div>

                    <div class="custom-control">
                        <input type="checkbox" id="FilterByPrice[]" value="1" name="FilterByPrice[]" class="FilterByPrice">
                        <label for="price-1">SAR 0 - SAR 100</label>
                    </div>

                    <div class="custom-control">
                        <input type="checkbox" id="FilterByPrice[]" value="2" name="FilterByPrice[]" class="FilterByPrice">
                        <label for="price-2">SAR 100 - SAR 300</label>
                    </div>

                    <div class="custom-control">
                        <input type="checkbox" id="FilterByPrice[]" value="3" name="FilterByPrice[]" class="FilterByPrice">
                        <label for="price-3">SAR 300 - SAR 500</label>
                    </div>
                </div> -->

                <h5 class="section-title position-relative text-uppercase mb-3"><span class="d-inline-block bg-secondary pr-3">@if(session('locale')=='en') New Arrivels @else  القادمون الجدد ت@endif </span></h5>
                <div class="bg-light p-4 mb-30">
                    <div class="owl-carousel owl-theme" id="newArrivels">
                        <?php 
                        foreach($SubcategoryProductList as $row) { 
                            $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
                            $subcategory = DB::table('sub-category')->where('id','=',$row->sub_category_id)->where('status','=','1')->where('language_id','=',$languageId->id)->first();
                        ?>
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <div id="prdSlider_8" class="carousel slide" data-ride="carousel" data-interval="15000">
                                  <div class="carousel-inner">
                                    <div class="carousel-item active">
                                      <img class="d-block w-100" src="{{asset('images/products/'.$row->image)}}" alt="">
                                    </div>
                                  </div>
                                </div>

                                <div class="product-action">
                         
                                    <a href="{{route('DemoSingleProduct',['id'=>$row->id])}}" class="btn btn-outline-dark btn-square" href="Javascript:void(0);"><i class="far fa-eye"></i></a>
                                   <!--  <a class="btn btn-outline-dark btn-square" href="Javascript:void(0);"><i class="far fa-heart"></i></a> -->
                                </div>
                            </div>
                            <input type="hidden" name="slug" id="slug" value="{{ $subcategory->id }}">
                            <div class="text-center py-4 pl-2 pr-2">
                                <h2 class="h4"><a class="text-dark text-decoration-none text-truncate" href="{{route('DemoSingleProduct',['id'=>$row->id])}}">{{ isset($subcategory->name) ? $subcategory->name : '' }} @if(session('locale')=='en')  @else من الملحمة  @endif</a></h2>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ isset($row->discount_price) ? $row->discount_price : ''}} SAR</h5><h6 class="text-muted ml-2"><del>{{ isset($row->price) ? $row->price : ''}} SAR</del></h6>
                                </div>
                                {{-- <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                </div> --}}
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="col-lg-10 col-md-10">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="row align-items-center justify-content-between mb-4">
                            <div class="col-md-6 text-md-left text-center">
                            <!-- <ul class="d-block nav nav-pills" role="tablist" id="tabViewScreen">
                                    <li class="nav-item d-inline-block ml-1 mr-1">
                                      <a class="btn btn-sm btn-light active" data-toggle="pill" href="#view1"><img src="{{asset('images/view1.jpg')}}"></a>
                                    </li>

                                    <li class="nav-item d-inline-block ml-1 mr-1">
                                      <a class="btn btn-sm btn-light" data-toggle="pill" href="#view2"><img src="{{asset('images/view2.jpg')}}"></a>
                                    </li>

                                    <li class="nav-item d-inline-block ml-1 mr-1">
                                      <a class="btn btn-sm btn-light" data-toggle="pill" href="#view3"><img src="{{asset('images/view3.jpg')}}"></a>
                                    </li>

                                    <li class="nav-item d-inline-block ml-1 mr-1">
                                      <a class="btn btn-sm btn-light" data-toggle="pill" href="#view4"><img src="{{asset('images/view4.jpg')}}"></a>
                                    </li>
                                </ul> -->
                            </div>

                            <div class="col-md-6 text-md-right text-center">
                                <div class="btn-group">
                                    <select class="btn btn-sm btn-light ml-1" id="short_by">
                                        <option>@if(session('locale')=='en') Sort by @elseصنف حسب ت@endif </option>
                                        <!-- <option value="latest">Latest</option> -->
                                        <!-- <option value="popularity">Popularity</option> -->
                                        <option value="price_low_high">@if(session('locale')=='en') Price (Low > High) @else  االسعر (منخفض> مرتفع) ت@endif </option>
                                        <option value="price_high_low">@if(session('locale')=='en') Price (High > Low) @else  السعر (مرتفع> منخفض) ت@endif </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="tab-pane active" id="view4" >
                            <div class="row" id="Result">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('javascript')

<script type="text/javascript">
$(function() { 
  $("#short_by").change(function(event) {
    loadData(1);
  });
  $("#fromVal").keypress(function(event) {
    if(event.which == 13){
      event.preventDefault();
      loadData(1);
    }
  });
  $("#toVal").keypress(function(event) {
    if(event.which == 13){
      event.preventDefault();
      loadData(1);
    }
  });
});

function Search(){
  var page = $('#CurrentPage').val();
  loadData(page);
}
function Pagination(page){
  loadData(page);
}
function loadData(page){
  $("#Result").html('<tr><td colspan="10"><center>Loading..</center></td></tr>');

  var fromVal       = $("#fromVal").val();
  var toVal         = $("#toVal").val();
  var short_by      = $("#short_by").val();
  var slug          = $("#slug").val();
  var no_of_page    = 16;
  var siteurl       = $('#url').val();
  var _token        = $('#_token').val();
  
  $.ajax(
  {
    url : siteurl+'/en-SA/ProductListingBySlug',
    type: "POST",
    data : {fromVal:fromVal,toVal:toVal,short_by:short_by,slug:slug,_token:_token,no_of_page:no_of_page,page:page},
    success:function(a)
    {
      //console.log("Aftab");
      $("#Result").html(a);
    }
  });
}

loadData(1);

</script>

@endsection