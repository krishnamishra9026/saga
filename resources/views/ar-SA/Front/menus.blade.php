@extends('layouts.default')
@section('content')

<section class="inner_banner" style="background: url('images/slide/banner3.jpg') no-repeat;background-position: center;background-size: cover;background-position: 50% 30%;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="vl-filter-text-box">
                    <h1>Hot Menu</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="menu menupage">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <!-- <h1 class="text-center mb-5">Hot Menu</h1> -->
        <!-- Nav tabs -->
        <!-- <ul class="nav nav-tabs justify-content-center mb-4">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Desserts">Desserts</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Dinner">Dinner</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Drinks">Drinks</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Meat">Meat</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Starters">Starters</a></li>
        </ul> -->
        <ul class="nav nav-tabs justify-content-center mb-4">
          @foreach($Categories as $i => $row)
            <li class="nav-item">
              <a class="nav-link @if($i==0) active @endif" data-toggle="tab" href="#tab-{{$row->id}}">{{$row->name}}</a>
            </li>
          @endforeach
        </ul> 
      </div>
      <div class="col-md-12">
        <!-- Tab panes -->

        <div class="tab-content">
          @foreach($Categories as $j => $category)
            <div class="tab-pane @if($j==0) active @endif" id="tab-{{$category->id}}">
              <div class="row">
                @php
                $Product = DB::table('menus')->where('category', $category->id)->get();
                @endphp
                @foreach($Product as $j => $row)
                @php
                $multipleimg = $row->images;
                $single = explode("|", $multipleimg);
                @endphp
                <div class="col-lg-3 col-md-4 col-sm-6">
                  <div class="single_delicious d-flex">
                    <div class="thumb">
                      <img src="{{asset('upload/product/multipleimg/'.$single[0])}}" alt="">
                    </div>
                    <div class="info">
                      <h3>{{$row->name}}</h3>
                      <div class="dish_cost">
                        <span>£{{$row->price}}</span>                      
                      </div>
                      <p>{{$row->description}}</p>
                      <!-- <a href="javascript:void(0);" class="btn btn-primary btn-sm">Order Now</a> -->
                      <form action="{{ route('cart.store') }}" method="POST">
                      {{ csrf_field() }}
                      <input type="hidden" value="{{ $row->id }}" id="id" name="id">
                      <input type="hidden" value="{{ $row->name }}" id="name" name="name">
                      <input type="hidden" value="{{ $row->price }}" id="price" name="price">
                      <input type="hidden" value="{{asset('upload/product/multipleimg/'.$single[0])}}" id="img" name="img">
                      <input type="hidden" value="1" id="slug" name="slug">
                      <input type="hidden" value="1" id="quantity" name="quantity">

                      <!-- <a href="javascript:void(0);" class="btn btn-primary2">Order Now</a> -->
                      <button class="btn btn-primary btn-sm" class="tooltip-test" title="add to cart">
                      Order Now
                      </button>
                      </form>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>

        <!-- <div class="tab-content">
          <div class="tab-pane active" id="Desserts">
            <div class="row">
              <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="single_delicious d-flex">
                  <div class="thumb">
                    <img src="images/menu/small.jpg" alt="">
                  </div>
                  <div class="info">
                    <h3>#1. Product Name</h3>
                    <div class="dish_cost">
	                    <span>$20</span>                    	
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,</p>
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm">Order Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="Dinner">coming soon...</div>
          <div class="tab-pane fade" id="Drinks">coming soon...</div>
          <div class="tab-pane fade" id="Meat">coming soon...</div>
          <div class="tab-pane fade" id="Starters">coming soon...</div>
        </div> -->
      </div>
      <!-- <div class="col-md-12">
        <div class="full_menu"><a href="javascript:void(0);" class="btn btn-primary mt-4">View Full Menu</a></div>
      </div> -->
    </div>
  </div>
</section>
@endsection
@section('javascript')
@endsection