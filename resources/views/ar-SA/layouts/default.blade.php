<!DOCTYPE html>
<!--<html translate="no">-->
<html>
<head>
    <meta charset="utf-8">
    <title>SAGA</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="{{asset('images/fav.png')}}" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Saira+Condensed:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}?v=<?php echo(rand(10,100));?>" rel="stylesheet">
    <link href="{{asset('css/ar-custom.css')}}?v=<?php echo(rand(10,100));?>" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    
  @yield('css')
  @yield('head')
</head>
<body >

<header class="">
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5 top_strip">
            <div class="col-lg-6 text-center text-lg-right">
                
                <div class="d-inline-flex align-items-center h-100">
                    <!--<a class="text-body" href="Javascript:void(0);">@if(session('locale')=='en')  Blog @else  مدونة  @endif</a>-->
                    <!-- <a href="Javascript:void(0);" class="text-body" id="track_return">@if(session('locale')=='en')  Track / Return @else  مدونة  @endif </a> -->
                </div>

                <!--<div class="d-inline-flex align-items-center d-block d-lg-none">-->
                <!--    <a href="Javascript:void(0);" class="btn px-0 ml-2">-->
                <!--        <i class="fas fa-heart text-dark"></i>-->
                <!--        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>-->
                <!--    </a>-->
                <!--    <a href="Javascript:void(0);" class="btn px-0 ml-2">-->
                <!--        <i class="fas fa-shopping-cart text-dark"></i>-->
                <!--        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>-->
                <!--    </a>-->
                <!--</div>-->
            </div>
            
            
            <div class="col-lg-6 text-center text-lg-right">
                

                <div class="d-inline-flex align-items-center">
                    
                    <div class="btn-group">
                        <?php
                         $languageArray=array('ar'=>'عربي  ','en'=>'English');
                        ?>
                        <select id="s1" NAME="section" onChange="SelectRedirect(this);">
                            @foreach($languageArray as $key=>$value)
                            <option value="{{$key}}" <?php if( $key==session('locale')) echo "selected"; ?>>{{$value}}</option>
                            @endforeach
                        </select>

                    </div>
                    
                    @if(Session::has('user_id'))
                    <a href="{{route('UserLogout')}}" style="padding: 0px;"><li class="dropdown-item">Logout</li></a>
                    <a href="{{ route('userProfile') }}" style="padding: 0px;"><li class="dropdown-item">{{session('full_name')}}</li></a>
                    
                    @else
                    <a href="{{ route('Login') }}" class="text-body">  @if(session('locale')=='en')  Sign In @else تسجيل الدخول  @endif</a>
                    <a href="{{ route('Register') }}" class="text-body">@if(session('locale')=='en')  Register @else  التسجيل   @endif </a>
                    <a href="javascript:void(0);" class="text-body">@if(session('locale')=='en') Tracking  @else  تتبع   @endif </a>
                    <a href="{{ route('RetainAndRefundPolicy') }}" class="text-body">@if(session('locale')=='en') Exchange  @else   طلب تبديل      @endif </a>
                    @endif
                    
                    
                    
                </div>

            </div>

            
        </div>

        <!--<div class="row align-items-center justify-content-center bg-light py-3 px-xl-5 d-none d-lg-flex">-->
        <div class="row align-items-center justify-content-between bg-light py-1 px-xl-5 ">
            <div class="col-lg-2">
                <!--<a href="" class="text-decoration-none text-right d-block">-->
                <a href="" class="text-decoration-none text-right d-none d-lg-flex" style="float: left;">
                    <img src="{{asset('images/main-logo.png')}}" class="img-fluid" width="150">
                </a>
            </div>
            {{-- <div class="col-lg-6 col-12 text-left ">
                <div class="d-flex">
                    
                    <form action="" class="search_bar d-inline-block w-75">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent text-primary">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="@if(session('locale')=='en')  Search of products @else البحث عن منتج   @endif ">
                        </div>
                    </form>
                    <a href="{{route('ShowCartItems')}}" class="btn px-0 w-25">
                        
                        <span class="badge text-dark " >{{ \Cart::getContent()->count() }}</span>
                        <i class="fas fa-shopping-cart text-dark"></i>
                    </a>
                </div>
            </div> --}}
            
               <div class="col-lg-6 col-12 text-right ">
               
                    
                         <a href="{{route('ShowCartItems')}}" class="btn px-0 w-25">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark " >{{ \Cart::getContent()->count() }}</span>
                    </a>
                
            </div> 

            
        </div>
    </div>

    <div class="bg-dark" id="fix_top">
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0" @if(last(request()->segments()) == 'checkout') {{-- style="direction: rtl;"  --}}   @else  @endif >
                    <a href="" class="text-decoration-none d-block d-lg-none w-50">
                        <img src="{{asset('images/main-logo.png')}}" style="filter: invert(1);" class="img-fluid" width="80">
                    </a>

                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!--<div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">-->
                    <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
                        <div class="navbar-nav justify-content-center w-100">
                            <!-- <a href="Javascript:void(0);" class="nav-item nav-link"><i class="fas fa-home"></i> Home</a> -->
                            <?php
                            foreach($CategoryA as $row){
                            $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
                            $subcategory = DB::table('sub-category')->where('category_id','=',$row->id)->where('status','=','1')->where('language_id','=',$languageId->id)->get();
                            ?>
                            <div class="nav-item dropdown">
                                <?php if(!$subcategory->isEmpty()){?>
                                    <a href="Javascript:void(0);" class="nav-link dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-angle-down mt-1"></i> {{ $row->category_name }}</a>
                                <?php }else{?>
                                    <a href="" class="nav-item nav-link"> {{ $row->category_name }} <?php if($row->category_name=='Home' or $row->category_name=='الرئيسية'){ echo '<i class="fas fa-home"></i>'; }?></a>
                                <?php } ?>
                                <?php 
                                if(!$subcategory->isEmpty()){?>
                                    <div class="dropdown-menu rounded-0 border-0 m-0 w-50">
                                        <div class="row">
                                               <?php
                                            foreach($subcategory as $submenu){
                                            ?>
                                            <div class="col-md-3 col-6">
                                                <!-- <h2>Perfect Trendy item for you</h2> -->
                                                <div class="product-item bg-light mb-4">
                                                    <div class="product-img position-relative overflow-hidden">
                                                        <img class="img-fluid w-100" src="{{asset('upload/sub-category/'.$submenu->image)}}" alt="">
                                                        <div class="product-action">
                                                            {{-- <a class="btn btn-outline-dark btn-square" href="javascript:void(0);"><i class="fa fa-shopping-cart"></i></a> --}}
                                                            <a class="btn btn-outline-dark btn-square" href="{{route('ProductListingOfSubcategory',['id'=>$submenu->id])}}"><i class="far fa-eye"></i></a> 
                                                        </div>
                                                    </div>

                                                    <div class="text-center py-4">
                                                        <a class="h6 text-decoration-none text-truncate" href="{{route('ProductListingOfSubcategory',['id'=>$submenu->id])}}">{{ $submenu->name }} @if(session('locale')=='en') @else   @endif </a>
                                                        <!--<div class="d-flex align-items-center justify-content-center mb-1">-->
                                                        <!--    <small class="fa fa-star text-primary mr-1"></small>-->
                                                        <!--    <small class="fa fa-star text-primary mr-1"></small>-->
                                                        <!--    <small class="fa fa-star text-primary mr-1"></small>-->
                                                        <!--    <small class="fa fa-star text-primary mr-1"></small>-->
                                                        <!--    <small class="fa fa-star text-primary mr-1"></small>-->
                                                        <!--</div>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }?>
                                            <div class="col-md-3 col-6">
                                                <h2>{{ $row->category_name }}</h2>
                                                <?php
                                                foreach($subcategory as $subrow){
                                                ?>
                                                <a class="" href="{{route('ProductListingOfSubcategory',['id'=>$subrow->id])}}">{{ $subrow->name }}</a>
                                                <?php }?>
                                            </div>
                                         
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>

</header>

<div class="menuFullBG2"></div>
<div class="right_side_cart">
    <div class="cartClose" id="TrackReturnClose">
        <a href="Javascript:void(0);">Close X</a>
        <div class="clearfix"></div>
    </div>

    <div class="">
        <form>
            <div class="form-group">
                <label>Track by Order Number</label>
                <input type="number" class="form-control">
            </div>
            <div class="form-group">
                <label>Email Id</label>
                <input type="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="email" class="form-control">
            </div>
          <button type="submit" class="btn w-100 btn-primary mt-3">Track</button>
        </form>
    </div>
</div>

<input type="hidden" id="url" value='{{url("/")}}'>
<input type="hidden" id="_token" value="{{ csrf_token() }}">

@yield("content")

<div class="container-fluid bg-dark text-secondary mt-5 pt-5 footer_main" >
    <div class="row px-xl-5 pt-5">
        

        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <!-- <h5 class="text-secondary text-uppercase mb-4">@if(session('locale')=='en')  Newsletter @else النشرة  @endif </h5>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="@if(session('locale')=='en')  Your Email Address @else  عنوان بريدك الإلكتروني  ا@endif">
                            <div class="input-group-append">
                                <button class="btn btn-primary">@if(session('locale')=='en')  SUBSCRIBE @else الإشتراك @endif </button>
                            </div>
                        </div>
                    </form> -->
                    <h5 class="text-secondary text-uppercase mb-3">@if(session('locale')=='en')  Follow us to Stay Connected @else   تابعنا للبقاء على اتصال     @endif    </h5>

                    <div class="d-flex social_media">
                        <a target="_blank" href="http://www.facebook.com/SAGA.KSA"><i class="fab fa-facebook-f"></i></a>
                        <a target="_blank" href="http://www.instagram.com/SAGA_Saudi"><i class="fab fa-instagram"></i></a>
                        <a target="_blank" href="http://https://www.youtube.com/channel/UC0F4sZ1d_HiEKL1gSgP-otg/videos"><i class="fab fa-youtube"></i></a>
                        <a target="_blank" href="http://www.twitter.com/SAGA_Saudi"><i class="fab fa-twitter"></i></a>
                        <!--<a onclick="window.open('https://mail.google.com/mail/u/0/?fs=1&to=info@saga-bags.com&tf=cm','name','width=600,height=400')" href="javascript:void(0);"><i class="fas fa-envelope"></i></a>-->
                        <a target="_blank" href="https://mail.google.com/mail/u/0/?fs=1&to=info@saga-bags.com&tf=cm"><i class="fas fa-envelope"></i></a>
                        <a target="_blank" href="https://api.whatsapp.com/send?phone=966506187302"><i class="fab fa-whatsapp"></i></a>
                        <a target="_blank" href="http://www.snapchat.com/SAGA_Saudi"><i class="fab fa-snapchat-ghost"></i></a>
                    </div>

                    <!-- <h5 class="text-secondary text-uppercase mt-4 mb-3">@if(session('locale')=='en')  Contact Us @else تواصل معنا  @endif </h5> --> 
                    <p class="m-0">@if(session('locale')=='en')  Customer Service @else  خدمة العملاء   @endif </p>
                    <h5 class="m-0"><a href="tel:+966 11-2347191">+966 11-2347191</a></h5>
                    <p class="m-0">@if(session('locale')=='en')  Customer Care By Whatsaspp @else  خدمة العملاء عبر واتس اب   @endif </p>
                    <h5 class="m-0"><a href="https://wa.me/966506187302?text=Hi, any online support from our Whatsaspp Help line?" target="_target">+966 506187302</a></h5>
                    <small>@if(session('locale')=='en')  Live Chat/Support 24/7 @else دعم 24/7 / محادثة مباشرة    @endif .</small>
                </div>
                

                <div class="col-md-4 mb-5">
                    <!--<h5 class="text-secondary text-uppercase mb-4">@if(session('locale')=='en')  Company @else شر @endif </h5>-->
                    <div class="d-flex flex-column justify-content-start">
                        <!--<a class="text-secondary mb-2" href="{{ route('ShippingAndReturns') }}"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Shipping And Returns @else الشحن و الاسترجاع  @endif </a>-->
                        <a class="text-secondary mb-2" href="{{ route('TermsAndConditions') }}"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Terms And Conditions @else  الشروط و الاحكام  @endif </a>
                        <a class="text-secondary mb-2" href="javascript:void(0);"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  My Orders  @else   طلباتي     @endif </a>
                        <!--<a class="text-secondary mb-2" href="{{ route('AccessibilityStatement') }}"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Accessibility Statement @else بيان إمكانية الوصول @endif </a>-->
                        <a class="text-secondary mb-2" href="{{ route('PrivacyPolicy') }}"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Privacy Policy @else سياسة الخصوصية  @endif </a>
                        <a class="text-secondary mb-2" href="{{ route('RetainAndRefundPolicy') }}"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Retain & Refund Policy @else  سياسة الاسترداد والاسترداد    @endif </a>
                        <a class="text-secondary mb-2" href="{{ route('ShippingPolicy') }}"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Shipping  Policy  @else   سياسة الشحن     @endif </a>
                        <!-- <a class="text-secondary mb-2" href="Javascript:void(0);"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Terms of Use @else شروطنا  @endif </a> -->
                        
                    </div>
                </div>
                
                <div class="col-md-4 mb-5">
                    <!--<h5 class="text-secondary text-uppercase mb-4">@if(session('locale')=='en')  Quick Links @else  مدونة  @endif </h5>-->
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href=""><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Home @else  الرئيسية     @endif </a>
                        <a class="text-secondary mb-2" href="{{ route('About') }}"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  About Us @else عن الشركة   @endif </a>
                        <a class="text-secondary mb-2" href="{{ route('OurStores') }}"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Our Stores @else   متاجرنا     @endif </a>
                        <!-- <a class="text-secondary mb-2" href=""><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Shopping Cart @else السلة  @endif </a> -->
                        <a class="text-secondary mb-2" href="{{ route('Contact') }}"><i class="fa fa-angle-right mr-2"></i>@if(session('locale')=='en')  Contact Us @else تواصل معنا   @endif </a>
                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <img src="{{asset('images/main-logo.png')}}" class="w-50 mb-4" style="filter: invert(1);">
            <!--<p class="mb-4">
            @if(session('locale')=='en')
            SAGA BAGS is an establishment in 2005 and fastest-growing company.. providing own made brands products like luggage, men bags with category wise,  woman bags, etc.
            @else
            أكياس ساغا هي مؤسسة في عام 2005 وهي شركة الأسرع نموًا .. تقدم منتجات ذات علامات تجارية خاصة مثل الأمتعة وحقائب الرجال ذات الفئة الحكيمة والحقائب النسائية وما إلى ذلك.
            @endif
            </p>-->
            <!-- <img src="{{asset('images/footer.png')}}" class="img-fluid">
            <img src="{{asset('images/visa.png')}}" class="img-fluid"> -->
        </div>
    </div>

    <div class="row border-top mx-xl-5 py-3" style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="col-md-12 ">
            <!--<p class="mb-md-0 text-center  text-secondary">@if(session('locale')=='en')  Copyright @else حقوق النشر  @endif  &copy; 2021  @if(session('locale')=='en')  by SAGA @else بواسطة ح قصة طويلة  @endif   | @if(session('locale')=='en')  All right reserved @else جميع الحقوق محفوظة  @endif</p>-->
            <p class="mb-md-0 text-center  text-secondary">   جميع الحقوق محفوظة لساغا © 2021     </p>
        </div>
    </div>
</div>

<a href="Javascript:void(0);" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('lib/easing/easing.min.js')}}"></script>
<script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/main.js?v=1234')}}"></script>

<script type="text/javascript">
    // //navbar dropdown
    // $(document).ready(function() {
    //   $('#fix_top .dropdown').hover(function() {
    //     $(this).find('.dropdown-menu').stop(true, true).delay(150).slideDown(150);
    //   }, function() {
    //     $(this).find('.dropdown-menu').stop(true, true).delay(150).slideUp(150);
    //   });
    // });
</script>


<script language="javascript">
function SelectRedirect(node){

var siteurl       = $('#url').val();
var langName      = $('#s1').val();

var value= $(node).val();
    $.ajax({

url: '{{route('ChangeWebLanguage')}}',
          method: "post",
          headers:{
      'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
          data: {
            action:'language',
            language:value
              
          },
          success: function (data) {  
              dataArray = JSON.parse(data);  
              if(dataArray.status == 'success')
              {
                if(langName =='ar'){
                    if (window.location.href.indexOf("product-listing-subcategory") > -1) {
                        window.location.href = siteurl+'/ar-SA';
                    }else{
                        window.location.href = "{{url()->current()}}".replaceAll("en-SA", "ar-SA");
                    }
                } else{
                if (window.location.href.indexOf("product-listing-subcategory") > -1) {
                    window.location.href = siteurl+'/en-SA';
                }else{

                    window.location.href = "{{url()->current()}}".replaceAll("ar-SA", "en-SA");
                }
            }
        }
    

},



});

}
</script>



@yield('javascript')



</body>
</html>