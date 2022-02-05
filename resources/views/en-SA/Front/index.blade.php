@extends('en-SA.layouts.default')
@section('content')

<div class="home_slider">
    <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#header-carousel" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner">
            <?php
            $i=0;
            foreach($Banners as $row) {
                if($i==0){
                ?>
                <div class="carousel-item position-relative active">
                    <img class="w-100 h-100" src="{{asset('images/banner/'.$row->image)}}">
                </div>
            <?php 
            }else{
                ?>
                <div class="carousel-item position-relative">
                    <img class="w-100 h-100" src="{{asset('images/banner/'.$row->image)}}">
                </div>
                <?php
            }   
            $i++; } ?>
        </div>
        <a class="carousel-control-prev" href="#header-carousel" role="button" data-slide="prev">
            <i class="fas fa-arrow-left"></i>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#header-carousel" role="button" data-slide="next">
            <i class="fas fa-arrow-right"></i>
            <span class="sr-only">Next</span>
          </a>
    </div>
</div>

<section class="categories_sec">
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">@if(session('locale')=='en')  Categories @else فئات   @endif</span></h2>
        <div class="row px-xl-5 pb-3">
            <?php
            foreach($SubCategories as $row){
            $procount = DB::table('products')
                ->select('sub_category_id', DB::raw('count(*) as total'))
                ->where('sub_category_id','=',$row->id)
                ->groupBy('sub_category_id')
                ->first();
            if(!empty($procount->total)){
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="{{route('ProductListingOfSubcategory',['id'=>$row->id])}}">
                    <!--<div class="cat-item d-flex align-items-center mb-4">-->
                    <div class="cat-item align-items-center mb-4">
                        <div class="overflow-hidden">
                            <img class="img-fluid" src="{{asset('upload/sub-category/'.$row->image)}}" alt="">
                        </div>
                        <div class="flex-fill pl-3">
                            <h2>{{ $row->name }}</h2>
                            <small class="text-body">{{ $procount->total }}   @if(session('locale')=='en')  Products @else  منتجات@endif  </small>
                        </div>
                    </div>
                </a>
            </div>
            <?php }}?>
        </div>
    </div>
</section>

<section class="prd_listing">
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">@if(session('locale')=='en')  New Product @else  منتجات جديدة  @endif </span>
            <!-- <a href="#" class="btn btn-primary float-right">View All</a> -->
        </h2>

        <div class="row px-xl-5">
            <div class="col-lg-12 pb-1">
                <div class="owl-carousel home_prd_carousel">
                    <?php
                    foreach ($NewProduct as $row) { ?>
                       <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <div id="prdSliderNew7" class="carousel slide" data-ride="carousel" data-interval="15000">
                              <div class="carousel-inner">
                                <div class="carousel-item active">
                                  <img class="d-block w-100" src="{{asset('images/products/'.$row->image)}}" alt="">
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
                            <?php 
                            $categoryname   = DB::table('category')->select('*')->where('id',$row->category_id)->first();
                            $subcategoryname   = DB::table('sub-category')->select('*')->where('id',$row->sub_category_id)->first();
                            ?>
                            <h2 class="h4"><a class="text-dark text-decoration-none text-truncate" href="{{route('DemoSingleProduct',['id'=>$row->id])}}"><?php echo isset($subcategoryname->name) ? $subcategoryname->name : $categoryname->category_name ?> @if(session('locale')=='en') @else من الملحمة  @endif  </a></h2>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5><?php echo $row->discount_price?>  SAR</h5><h6 class="text-muted ml-2"><del><?php echo $row->price?>  SAR</del></h6>
                            </div>
                            {{-- <div class="d-flex align-items-center justify-content-center mb-1">
                                 @for($i = 0; $i < $row->start_rating; $i++)
                                <small class="fa fa-star text-primary mr-1"></small>
                                @endfor
                            </div> --}}
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
foreach($SubCategories as $row){
$product_arr = DB::table('products')
    ->where('sub_category_id','=',$row->id)
    ->get();
if(!$product_arr->isEmpty()){
?>
<section class="prd_listing">
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">{{ $row->name }}</span>
            <a href="{{route('ProductListingOfSubcategory',['id'=>$row->id])}}" class="btn btn-primary float-right">@if(session('locale')=='en') View All @else  عرض الكل  م@endif</a>
        </h2>

        <div class="row px-xl-5">
            <div class="col-lg-12 pb-1">
                <div class="owl-carousel home_prd_carousel">
                   <?php
                   foreach ($product_arr as $list) {
                   ?>
                    <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <div id="prdSliderNew1" class="carousel slide" data-ride="carousel" data-interval="15000">
                                  <div class="carousel-inner">
                                    <div class="carousel-item active">
                                      <img class="d-block w-100" src="{{asset('images/products/'.$list->image)}}" alt="">
                                    </div>

                                    <div class="carousel-item">
                                      <img class="d-block w-100" src="{{asset('/images/products/'.$list->image)}}" alt="">
                                    </div>
                                  </div>
                                </div>
                                <div class="product-action">
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $list->id }}" id="id" name="id">
                                        <input type="hidden" value="main_page" id="id" name="page">
                                        <input type="hidden" value="{{ $list->name }}" id="name" name="name">
                                        <input type="hidden" value="{{ $list->name_slug }}" id="slug" name="slug">
                                        <input type="hidden" name="quantity[1]" id="get-quantity-count"  value="1">
                                        <input type="hidden" value="{{ $list->quantity }}" id="product_quantity" name="product_quantity">
                                        <input type="hidden" value="{{asset('upload/prd/'.$list->image)}}"  id="img" name="img">
                                        <?php
                                        $productPrice = 0;
                                        if(isset($list->discount_price) && !empty($list->discount_price))
                                            {
                                                $productPrice = $list->discount_price;
                                                $gstAmount = (0/100)*$productPrice;
                                                $ProductPriceWithGst = $productPrice+$gstAmount;
                                            }
                                        ?>
                                        <input type="hidden" value="{{ isset($ProductPriceWithGst) ? $ProductPriceWithGst : '' }}" id="price" name="price">
    
                                        <button class="btn btn-outline-dark btn-square" ><i class="fa fa-shopping-cart"></i></button>
                                    </form>
                                    {{-- <a href="Javascript:void(0);" class="btn btn-outline-dark btn-square"><i class="fa fa-shopping-cart"></i></a> --}}
                                     <a class="btn btn-outline-dark btn-square" href="{{route('DemoSingleProduct',['id'=>$list->id])}}"><i class="far fa-eye"></i></a> 
                                </div>
                            </div>

                            <div class="text-center py-4 pl-2 pr-2">
                                <h2 class="h4"><a class="text-dark text-decoration-none text-truncate" href="{{route('DemoSingleProduct',['id'=>$list->id])}}">{{ $row->name }} @if(session('locale')=='en') @else من الملحمة  @endif </a></h2>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $list->discount_price }} SAR</h5><h6 class="text-muted ml-2"><del>{{ $list->price }} SAR</del></h6>
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
    </div>
</section>
<?php } }?>


<section class="saga_imag pt-5">
    <div class="container-fluid py-5">
        <h2 class="section-title text-center position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pl-3 pr-3">@if(session('locale')=='en')  Saga Photo Album @else االبوم صور ساغا م@endif </span>
        </h2>

        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <!--<div class="bg-light"><img src="{{asset('images/saga-img/2.png')}}" alt=""></div>-->
                    <!--<div class="bg-light"><img src="{{asset('images/saga-img/3.png')}}" alt=""></div>-->
                    <!--<div class="bg-light"><img src="{{asset('images/saga-img/4.png')}}" alt=""></div>-->
                    <!--<div class="bg-light"><img src="{{asset('images/saga-img/5.png')}}" alt=""></div>-->
                    <!--<div class="bg-light"><img src="{{asset('images/saga-img/6.png')}}" alt=""></div>-->
                    
                    <div class="bg-light"><img src="{{asset('images/photo-album/3.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/4.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/5.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/6.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/11.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/14.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/21.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/23.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/24.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/26.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/30.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/31.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/34.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/36.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/37.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/39.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/40.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/41.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/50.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/52.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/54.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/59.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/62.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/66.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/69.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/72.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/75.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/77.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/80.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/81.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/83.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/85.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/92.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/93.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/103.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/104.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/109.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/112.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/117.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/119.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/127.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/129.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/135.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/137.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/142.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/146.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/147.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/153.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/154.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/160.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/162.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/167.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/169.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/170.jpg')}}" alt=""></div>
                    <div class="bg-light"><img src="{{asset('images/photo-album/172.jpg')}}" alt=""></div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sagqq2">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <!--<h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>-->
                    <img src="{{asset('images/icon1.png')}}" alt="" class="mr-3">
                    <h5 class="font-weight-semi-bold m-0">@if(session('locale')=='en')  24/7 Support @else    دعم 24/7       @endif </h5>
                </div>
            </div>
    
            <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <!--<h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>-->
                    <img src="{{asset('images/icon2.png')}}" alt="" class="mr-3">
                    <h5 class="font-weight-semi-bold m-0">@if(session('locale')=='en')  Secure Payment @else    دفع امن       @endif </h5>
                </div>
            </div>
    
            <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <!--<h1 class="fa fa-check text-primary m-0 mr-3"></h1>-->
                    <img src="{{asset('images/icon3.png')}}" alt="" class="mr-3">
                    <h5 class="font-weight-semi-bold m-0">@if(session('locale')=='en')  Quality Product @else     منتجات عالية الجودة      @endif </h5>
                </div>
            </div>
    
            <!--<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">@if(session('locale')=='en')  Free Shipping @else    شحن مجاني      @endif 
                        <!-- <small class="d-block " style="font-size: 12px;color: #8a8a8a;">When the value of your purchases for purchase orders</small> -->
                    <!--</h5>
                </div>
            </div>-->
        </div>
    </div>
</section>

@endsection
@section('javascript')
@endsection