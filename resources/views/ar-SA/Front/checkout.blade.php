@extends('ar-SA.layouts.menu')
@section('content')

@php
use App\Helpers\Common;
$address_data = json_decode($usersInfo->shipping_address);


@endphp

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
                    <a href="{{route('UserLogout')}}" style="padding: 0px;"><li class="dropdown-item">تسجيل خروج</li></a>
                    <a href="#" style="padding: 0px;"><li class="dropdown-item">{{session('full_name')}}</li></a>
                    
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
                <!--<a href="{{ route('Home') }}" class="text-decoration-none text-right d-block">-->
                <a href="{{ route('Home') }}" class="text-decoration-none text-right d-none d-lg-flex" style="float: left;">
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
                <nav style="direction: rtl;" class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0" @if(last(request()->segments()) == 'checkout')    @else  @endif >
                    <a href="{{ route('Home') }}" class="text-decoration-none d-block d-lg-none w-50">
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
                                    <a href="{{route('Home')}}" class="nav-item nav-link"> {{ $row->category_name }} <?php if($row->category_name=='Home' or $row->category_name=='الرئيسية'){ echo '<i class="fas fa-home"></i>'; }?></a>
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

<section class="checkout_page">
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-12">
            	<p class="text-center pb-4">
            		<a class="text-dark pl-2 pr-2" href="javascript:void(0);">@if(session('locale')=='en')  Cart @else السلة    @endif</a> <i class="fas fa-angle-right"></i> 
            		<a class="text-dark pl-2 pr-2" href="javascript:void(0);">@if(session('locale')=='en')  Information @else معلومات   @endif</a> <i class="fas fa-angle-right"></i> 
            		<a class="text-dark pl-2 pr-2" href="javascript:void(0);">@if(session('locale')=='en')  Shipping @else معلومات الشحن  @endif</a> <i class="fas fa-angle-right"></i> 
            		<a class="text-dark pl-2 pr-2" href="javascript:void(0);">@if(session('locale')=='en')  Payment @else الدفع   @endif</a>
            	</p>
            </div>

            <form action="{{route('pay')}}" method="POST" > 
                        {{ csrf_field() }}
<div class="row col-lg-12">
            <div class="col-lg-7">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">@if(session('locale')=='en')  Billing Address @else  عنوان وصول الفواتير  @endif</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                    	<div class="col-md-12">
	                        <div class="form-group">
	                            <label class="sr-only">First Name</label>
	                            <input class="form-control" required name="email" id="email" type="Email" placeholder="البريد الالكتروني ">
	                        </div>

	                        <div class="custom-control custom-checkbox mb-3">
                               
                                <label class="custom-control-label" for="newaccount">ابقني على اطلاع على الاخبار والعروض</label>
                             <input type="checkbox" required name="keep_me" class="custom-control-input" id="newaccount">
                            </div>
                        </div>

                        <div class="col-md-12">
                        	<h5>@if(session('locale')=='en') Shipping Address @else عنوان الشحن   @endif</h5>
                        </div>

                        <div class="col-md-6">
	                        <div class="form-group">
	                            <label class="sr-only">First Name</label>
	                            <input class="form-control" required name="fname" id="fname" type="text" placeholder="البرالاسم الاول  ">
	                        </div>
                        </div>

                        <div class="col-md-6">
	                        <div class="form-group">
	                            <label class="sr-only">Last Name</label>
	                            <input class="form-control" name="lname" id="lname" type="text" placeholder="الاسم الاخير ">
	                        </div>
                        </div>

                        <div class="col-md-12">
	                        <div class="form-group">
	                            <label class="sr-only">Company (optional)</label>
	                            <input class="form-control" name="company" id="company" type="text" placeholder=" الشركة  (اختياري)">
	                        </div>
                        </div>

                        <div class="col-md-12">
	                        <div class="form-group">
	                            <label class="sr-only">Address</label>
	                            <input class="form-control" required name="address" id="address" value="{{ @$address_data->address }}" type="text" placeholder="العنوان">
	                        </div>
                        </div>

                        {{-- <div class="col-md-12">
	                        <div class="form-group">
	                            <label class="sr-only">Apartment, suite, etc. (optional)</label>
	                            <input class="form-control" type="text" placeholder="Apartment, suite, etc. (optional)">
	                        </div>
                        </div> --}}

                        <div class="col-md-12">
	                        <div class="form-group">
	                            <label class="sr-only">City</label>
	                            <input class="form-control" value="{{ @$address_data->city }}" required name="city" id="city" type="text" placeholder="المدينة">
	                        </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group ">
                                <label class="fixTopFild"> البلد </label>
                                <select class="custom-select" required name="country" id="country">
                                @foreach(Common::getCountryArray() as $country)
                                <option value="{{$country}}" @if($country == @$address_data->country) selected @endif>{{$country}}</option> 
                                 @endforeach
                                </select>	 
                              
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group ">
                                <label class="sr-only">State</label>
                                <input class="form-control" type="text" placeholder="الحي "  value="{{ @$address_data->state }}" name="state" id="state">
                            </div>
                        </div>

                        <div class="col-md-4">
	                        <div class="form-group ">
	                            <label class="sr-only">Postcode</label>
	                            <input class="form-control" value="{{ @$address_data->postcode }}" name="postcode" required id="postcode" type="text" placeholder="الرمز البريدي ">
	                        </div>
                        </div>

                        <div class="col-md-12">
	                        <div class="form-group">
	                            <label class="sr-only">Phone (optional)</label>
	                            <input class="form-control" name="phone" id="phone" type="text" value="{{ @$address_data->phone }}" placeholder=" الهاتف (اختياري)">
	                        </div>
                        </div>

                        <div class="col-md-12">
                        	<div class="d-flex justify-content-between">
                        		<div class="col-md-4">
                        			<a href="{{ route('ShowCartItems')}}" class="py-3 text-dark d-inline-block"><i class="fas fa-angle-left"></i> @if(session('locale')=='en')  Return to cart @else العودة إلى عربة التسوق    @endif</a>
                        		</div>

                        		{{-- <div class="col p-0">
                        			<a href="#" class="btn btn-block btn-primary font-weight-bold py-2">@if(session('locale')=='en') Pay Now @else ادفع الآن   @endif</a>
                        		</div> --}}
                        	</div>
                        </div>
                    </div>
                </div>

                <div class="collapse mb-5" id="shipping-address">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
                    <div class="bg-light p-30">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="sr-only">First Name</label>
                                <input class="form-control" type="text" placeholder="John">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="sr-only">Last Name</label>
                                <input class="form-control" type="text" placeholder="Doe">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="sr-only">E-mail</label>
                                <input class="form-control" type="text" placeholder="example@email.com">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="sr-only">Mobile No</label>
                                <input class="form-control" type="text" placeholder="+123 456 789">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="sr-only">Address Line 1</label>
                                <input class="form-control" type="text" placeholder="123 Street">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="sr-only">Address Line 2</label>
                                <input class="form-control" type="text" placeholder="123 Street">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="sr-only">Country</label>
                                <select class="custom-select">
                                    <option selected>United States</option>
                                    <option>Afghanistan</option>
                                    <option>Albania</option>
                                    <option>Algeria</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="sr-only">City</label>
                                <input class="form-control" type="text" placeholder="New York">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="sr-only">State</label>
                                <input class="form-control" type="text" placeholder="New York">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="sr-only">ZIP Code</label>
                                <input class="form-control" type="text" placeholder="123">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">@if(session('locale')=='en') Order Total @else  الطلب الكلي   @endif</span></h5>
                <div class="bg-light p-2 mb-5 right_car_div">
                
                    <div class="table-responsive checkoutPrd_listing">
                    	<table class="w-100">
                            <?php
                            $i = 1;
                            $old_total = 0;
                            $new_total = 0; 
                            foreach($cartCollection as $item){
                                $new_total += $item->price*$item->quantity;
                                    $old_total += $item->attributes->OldPrice*$item->quantity;
                                $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
                                $product = DB::table('products')->where('serial_no','=',$item->attributes->serialNo)->where('status','=','1')->where('language_id','=',$languageId->id)->first();
                                /*echo $item->attributes->SubCategory;
                                echo "<pre>";
                                print_r($product);*/
                                $subcategory = DB::table('sub-category')->where('id','=',$product->sub_category_id)->where('status','=','1')->where('language_id','=',$languageId->id)->first();
                            ?>
                    		<tr>
                    			<td width="20%">
                    				<div class="img_wrap">
                    					<img src="{{ $item->attributes->image }}">
                    					<span class="qnt">{{ $item->quantity}}</span>
                    				</div>
                    			</td>

                    			<th width="">
                    				<h2>{{ isset($subcategory->name) ? $subcategory->name : '' }} @if(session('locale')=='en')  @else  @endif</h2>
                    				<small>{{ $product->color }}</small>
                    			</th>

                    			<td width="20%">
                    				<h3 class="font-weight-semi-bold text-right">{{ $item->price*$item->quantity }} ريال سعودي </h3>
                    				<h6 class="text-muted text-right"><del>{{ $item->attributes->OldPrice*$item->quantity }} ريال سعودي</del></h6>
                    			</td>
                    		</tr>
                    		<?php $i++; } 
                            $discount = $old_total-$new_total;
                            Session::forget('discountAmount');
                                session()->put('discountAmount',$discount);
                        ?>

                    		<!-- <tr>
                    			<td colspan="3">
                    				<hr>
                    				<form class="mt-4 d-flex">
									  <div class="form-group mx-sm-3 mb-2 w-100">
									    <label class="sr-only">Gift card or discount code</label>
									    <input type="text" class="form-control w-100" placeholder="Gift card or discount code">
									  </div>
									  <button type="submit" class="btn btn-primary mb-2">Apply</button>
									</form>
                    			</td>
                    		</tr> -->

                    	</table>
                    	<hr>
                    	<table class="w-100 mt-3">
                    		<tr>
                    			<td ><p class="ml-3">@if(session('locale')=='en') Subtotal @else  المجموع الفرعي   @endif</p></td>
                    			<td class="text-left text-dark">{{ \Cart::getTotal() }} ريال سعودي</td>
                    		</tr>
                    		<!-- <tr>
                    			<td><p class="ml-3">Shipping <a href="#" class="bg-dark pl-2 pr-2 rounded">?</a></p></td>
                    			<td class="text-right">Calculated at next step</td>
                    		</tr> -->
                    	</table>
                    		<table class="w-100 mt-3">
                        		<tr>
                        			<td><p class="ml-3">@if(session('locale')=='en') Discount  @else  مبلغ الخصم عي   @endif</p></td>
                        			<td class="text-left text-dark">{{$discount}}</td>
                        		</tr>
                        		
                        	</table>
                            <?php

                            //The VAT rate / percentage.
                            $vat = 15;

                            //The price, excluding VAT.
                            $priceExcludingVat = \Cart::getTotal();

                            //Calculate how much VAT needs to be paid.
                            $vatToPay = ($priceExcludingVat / 100) * $vat;

                            //The total price, including VAT.
                            $totalPrice = $priceExcludingVat + $vatToPay;      
                            Session::forget('totalAmountForPaidAfterDiscountAndGST');
                            Session::forget('vatToPay');
                            
                            session()->put('totalAmountForPaidAfterDiscountAndGST',$totalPrice);  
                            session()->put('vatToPay',$vatToPay);               
                        ?>
                        	
                        	<table class="w-100 mt-3">
                        		<tr>
                        			<td><p class="ml-3">@if(session('locale')=='en') Tax (VAT 15%)  @else  ضريبة القيمة المضافة  15%  @endif</p></td>
                        			<td class="text-left text-dark"><?=$vatToPay;?></td>
                        		</tr>
                        		
                        	</table>
                        		<table class="w-100 mt-3">
                        		<tr>
                        			<td><p class="ml-3">@if(session('locale')=='en') Delivery   @else رسوم الشحن   @endif</p></td>
                        			<td class="text-left text-dark">00.00 ريال سعودي</td>
                        		</tr>
                        		
                        	</table>

                    	<hr>
                    	<table class="w-100 mt-3">
                        	<tr>
                    			<td ><p class="ml-3"><b>@if(session('locale')=='en') Total @else المجموع    @endif</b></p></td>
                    			<td class="text-left text-dark"><h3> ريال سعودي{{($totalPrice) }}</h3></td>
                    		</tr>
                    	</table>
                        <input type="hidden" name="productname" value="{{ isset($subcategory->name) ? $subcategory->name : '' }}">
                            <input type="hidden" name="productprice" value="1">
                            <input type="hidden" name="mb_language" value="ar-SA">
                            <div class="col p-0 btn-group">
                                <!--<a href="#" class="btn btn-block btn-primary font-weight-bold py-2">@if(session('locale')=='en') Pay Now @else ادفع الآن   @endif</a>-->
                                <button type="submit" name="submit" formaction="{{route('payForCashOnDelivery')}}" class="btn btn-info font-weight-bold py-2" value="Cash On Delivery"    style="   border-radius: 5px;">الدفع عند الاستلام</button>
                                <button name="submit" class="btn btn-primary font-weight-bold py-2" style="margin-right: 10px; border-radius: 5px;">@if(session('locale')=='en') Pay Now @else ادفع الآن   @endif</button>
                            </div>
                    </div>                    
                </div>
            </div>
        </div>
        </form>
        </div>
    </div>
</section>


@endsection
@section('javascript')
@endsection