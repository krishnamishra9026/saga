@extends('layouts.default')
@section('content')
<section class="banner p-0">
  <div class="owl-carousel owl-theme" id="home-slider">
    <div class="item">
      <div class="card p-0" style="background-image: url('images/slide/banner1.jpg');">
        <div class="content text-center">
          <div class="inner">
            <h2>Welcome to SAKA MAKA</h2>
            <h3>Indian Takeaway</h3>          
            <a href="javascript:void(0);" class="btn btn-primary mt-4">View Menus</a>
          </div>
        </div>
      </div>
    </div>
    <div class="item">
      <div class="card p-0" style="background-image: url('images/slide/banner2.jpg');">
        <div class="content text-center">
          <div class="inner">
            <h2>An awesome experience by SAKA MAKA</h2>
            <h3>Indian Takeaway</h3>          
            <a href="javascript:void(0);" class="btn btn-primary mt-4">View Menus</a>
          </div>
        </div>
      </div>
    </div>
    <div class="item">
      <div class="card p-0" style="background-image: url('images/slide/banner3.jpg');">
        <div class="content text-center">
          <div class="inner">
            <h2>Best Indian Delicious Food For your Health</h2>
            <h3>Indian Takeaway</h3>          
            <a href="javascript:void(0);" class="btn btn-primary mt-4">View Menus</a>
          </div>
        </div>    
      </div>
    </div>
  </div>
</section>

<section class="cnt-dtls">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="icon"><i class="fas fa-clock"></i></div>
              <h3 class="text-primary">Opening Time</h3>
              <h3 class="m-0">Wed-Sun 5:00PM-9:45PM <br>Monday & Tuesday : CLOSED</h3>
              <!-- <p>Monday & Tuesday : CLOSED</p> -->
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
              <h3 class="text-primary">Address</h3>
              <h3 class="m-0">171 Brockley Rd, London SE4 2RS, United Kingdom</h3>
              <!-- <p>United Kingdom</p> -->
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="icon"><i class="fas fa-phone-alt"></i></div>
              <h3 class="text-primary">Contact</h3>
              <h3 class="m-0">0208 692 7236 <br>info@sakamaka.co.in</h3>
              <!-- <p></p> -->
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
          <ul class="social-media list-unstyled p-0 m-0">
            <li><a href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
            <li><a href="javascript:void(0);"><i class="fab fa-instagram"></i></a></li>
            <li><a href="javascript:void(0);"><i class="fab fa-tripadvisor"></i></a></li>
          </ul>
      </div>
    </div>
  </div>
</section>

<section class="about">
  <div class="container">
    <img src="images/1.png" class="img1">
    <img src="images/3.png" class="img2">
    <div class="row">
      <div class="col-lg-6 col-sm-6">
        <h1>Welcome to <span class="text-primary">SAKA MAKA</span></h1>
        <h3 class="mb-4">A Locals Indian Eatery</h3>
        <span class="long_dash"></span>
        <p class="mb-0"><b>Best Indian Takeaway in Brockley, London</b></p>
        <p class="mb-3"><b>Local Indian Takeaway in Brockley, London SE4 serving near Nunhead, New Cross SE14, Forest Hill SE23, Lewisham & Ladywell in SE13</b></p>

        <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <ul class="food_list">
          <li>
            <img src="images/salad.png">
            <span>Fresh Ingredients</span>
          </li>
          <li>
            <img src="images/cooker.png">
            <span>Expert cooker</span>
          </li>
          <li>
            <img src="images/food.png">
            <span>Healthy Foods</span>
          </li>
          <li>
            <img src="images/scooter.png">
            <span>Fastest Delivery</span>
          </li>
        </ul>

      </div>
      <div class="col-lg-6 col-sm-6">
        <div class="about_img">
          <div class="img_1">
            <img src="images/big.jpg" alt="">
          </div>
          <div class="small_img">
            <img src="images/small.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="menu">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center mb-5">Hot Menu</h1>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs justify-content-center mb-4">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Desserts">Desserts</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Dinner">Dinner</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Drinks">Drinks</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Meat">Meat</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Starters">Starters</a></li>
        </ul>
      </div>
      <div class="col-md-12">
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="Desserts">
            <div class="row">
              <div class="col-lg-6 col-sm-6">
                <div class="single_delicious d-flex">
                  <div class="thumb">
                    <img src="images/menu/small.jpg" alt="">
                  </div>
                  <div class="info">
                    <h3>#1. Product Name</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.</p>
                    <span>$20</span>
                    <a href="javascript:void(0);" class="btn btn-primary2">Order Now</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6">
                <div class="single_delicious d-flex align-items-center">
                  <div class="thumb">
                    <img src="images/menu/small.jpg" alt="">
                  </div>
                  <div class="info">
                    <h3>#2. Product Name</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.</p>
                    <span>$20</span>
                    <a href="javascript:void(0);" class="btn btn-primary2">Order Now</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6">
                <div class="single_delicious d-flex align-items-center">
                  <div class="thumb">
                    <img src="images/menu/small.jpg" alt="">
                  </div>
                  <div class="info">
                    <h3>#3. Product Name</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.</p>
                    <span>$20</span>
                    <a href="javascript:void(0);" class="btn btn-primary2">Order Now</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6">
                <div class="single_delicious d-flex align-items-center">
                  <div class="thumb">
                    <img src="images/menu/small.jpg" alt="">
                  </div>
                  <div class="info">
                    <h3>#4. Product Name</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.</p>
                    <span>$20</span>
                    <a href="javascript:void(0);" class="btn btn-primary2">Order Now</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6">
                <div class="single_delicious d-flex align-items-center">
                  <div class="thumb">
                    <img src="images/menu/small.jpg" alt="">
                  </div>
                  <div class="info">
                    <h3>#5. Product Name</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.</p>
                    <span>$20</span>
                    <a href="javascript:void(0);" class="btn btn-primary2">Order Now</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6">
                <div class="single_delicious d-flex align-items-center">
                  <div class="thumb">
                    <img src="images/menu/small.jpg" alt="">
                  </div>
                  <div class="info">
                    <h3>#6. Product Name</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.</p>
                    <span>$20</span>
                    <a href="javascript:void(0);" class="btn btn-primary2">Order Now</a>
                  </div>
                </div>
              </div>



            </div>
          </div>
          <div class="tab-pane fade" id="Dinner">coming soon...</div>
          <div class="tab-pane fade" id="Drinks">coming soon...</div>
          <div class="tab-pane fade" id="Meat">coming soon...</div>
          <div class="tab-pane fade" id="Starters">coming soon...</div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="full_menu"><a href="javascript:void(0);" class="btn btn-primary mt-4">View Full Menu</a></div>
      </div>
    </div>
  </div>
</section>


<section class="discount">
  <div class="container-fluid">
    <div class="row d-md-flex">
      <div class="col-lg-3 f-menu-img mb-5 mb-md-0" style="background-image: url(images/discount_bg.jpg);"></div>
      <div class="col-lg-9">
        <div class="row pt-5 pb-5 pl-3 pr-3">
          <div class="col-lg-4 col-sm-4">
            <div class="single-offer">
                <div class="wrap">
                  <img src="images/dis/img1.jpg" class="img-fluid" alt="">
                </div>
                <p>20% Discount On All Collection &amp; Delivery Orders Over £20 ( Wednesday Only )</p>                
                <a href="javascript:void(0);" class="btn btn-primary btn-sm">Get Discount</a>
            </div>
          </div>
          <div class="col-lg-4 col-sm-4">
            <div class="single-offer">
                <div class="wrap">
                  <img src="images/dis/img2.jpg" class="img-fluid" alt="">
                </div>
                <p>10% Discount <br>On Orders Over £20 (Delivery Only)</p>                
                <a href="javascript:void(0);" class="btn btn-primary btn-sm">Get Discount</a>
            </div>
          </div>
          <div class="col-lg-4 col-sm-4">
            <div class="single-offer">
                <div class="wrap">
                  <img src="images/dis/img3.jpg" class="img-fluid" alt="">
                </div>
                <p>10% Discount <br>On All Collection Orders</p>                
                <a href="javascript:void(0);" class="btn btn-primary btn-sm">Get Discount</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<section class="online_order">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="row text-wrap">
          <div class="col-lg-6 col-sm-6 p-0 pr-3">
            <div class="wrap">
              <img src="images/online-order.jpg" class="img-fluid">
            </div>
          </div>
          <div class="col-lg-6 col-sm-6">
            <h1 class="mb-4 mt-4">Online Order</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <a href="javascript:void(0);" class="btn btn-primary mt-2">See Menu</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="testimonials">
  <div class="container">

      <div class="row">
        <div class="col-md-8 col-sm-8 offset-2 text-center">
        <h2 class="text-white pb-3">What Our Customers Say</h2>
      </div>
        <div class="col-sm-12">
          <div id="customers-testimonials" class="owl-carousel">

            <div class="item">
              <div class="shadow-effect">
                <h3 class="quotes">“Great”</h3>
                <p>A real pleasant surprise. Tried a few things, everything was really tasty. Excellent value too.</p>
              </div>
              <div class="testimonial-name">Robbie</div>
            </div>
            <div class="item">
              <div class="shadow-effect">
                <h3 class="quotes">“Excellent”</h3>
                <p>Very happy to find good modern Indian takeaway in Lewisham. Short menu but everything on it is there for a reason.</p>
              </div>
              <div class="testimonial-name">Neil</div>
            </div>
            <div class="item">
              <div class="shadow-effect">
                <h3 class="quotes">“Very Nice Food”</h3>
                <p>Excellent food. highly recommended.</p>
              </div>
              <div class="testimonial-name">Asif</div>
            </div>
            <div class="item">
              <div class="shadow-effect">
                <h3 class="quotes">“Delicious”</h3>
                <p>Might need a wider number of meat dishes but well done.</p>
              </div>
              <div class="testimonial-name">Marcus</div>
            </div>

          </div>
        </div>
      </div>
      </div>
    </section>
@stop
@section('javascript')
@stop

