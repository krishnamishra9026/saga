<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <title>{{$Title}}</title>
  <link rel="icon" href="{{ asset('favicon.png')}}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('Admin/assets/plugins/notifications/css/lobibox.min.css')}}"/>
  <link href="{{ asset('Admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
  <link href="{{ asset('Admin/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet"/>
  <link href="{{ asset('Admin/assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
  <link href="{{ asset('Admin/assets/css/animate.css')}}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('Admin/assets/css/icons.css')}}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('Admin/assets/css/sidebar-menu.css')}}" rel="stylesheet"/>
  <link href="{{ asset('Admin/assets/css/app-style.css')}}" rel="stylesheet"/>
  <link href="{{ asset('Admin/assets/css/local.css')}}" rel="stylesheet"/>
  <link href="{{ asset('Admin/assets/css/jquery.dataTables.css')}}" rel="stylesheet"/>
  <link href="{{ asset('Admin/dist/css/AdminLTE.min.css') }}" rel="stylesheet" >
  @yield('css')
</head>
<body>
<input type="hidden" name="url" id="url" value='{{url("Admin/")}}'>
<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
<div id="wrapper">
	<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
		<div class="brand-logo text-center">
	      <a href="{{route('Category')}}">
	        <img src="{{Session::get('admin_image')}}" alt="Logo" style="height: 50px;">
	      </a>
	    </div>
	 
	    <ul class="sidebar-menu do-nicescrol">
	    	<li @if($Menu=='Dashboard') class="active" @endif>
		        <a href="{{route('Dashboard')}}" class="waves-effect">
		          <i class="icon-home"></i><span>Dashboard</span>
		        </a>
	      	</li>
			<li @if($Menu=='User') class="active" @endif>
		        <a href="{{route('User')}}" class="waves-effect">
		          <i class="icon-user"></i><span>Users</span>
		        </a>
		    </li>	
			<li @if($Menu=='Order') class="active" @endif>
		        <a href="{{route('Order')}}" class="waves-effect">
		          <i class="fa fa-shopping-bag"></i><span>Orders</span>
		        </a>
		    </li>
			<!-- <li @if($Menu=='Notification') class="active" @endif>
		        <a href="{{route('Notification')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Notification</span>
		        </a>
		    </li> -->
			
			
			<!-- <li @if($Menu=='Concern') class="active" @endif>
		        <a href="{{route('Concern')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Concern</span>
		        </a>
		    </li> -->

		    <li @if($Menu=='Product') class="active" @endif>
		        <a href="{{route('Product')}}" class="waves-effect">
		          <i class="fa fa-bars"></i><span>Products</span>
		        </a>
		    </li>
	   		     
			<!-- <li @if($Menu=='Discount') class="active" @endif>
		        <a href="{{route('Discount')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Coupen code Discount </span>
		        </a>
		    </li> -->

		    <!-- <li @if($Menu=='Menu') class="active" @endif>
		        <a href="{{route('Menu')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Menus</span>
		        </a>
		    </li> -->

		    <li @if($Menu=='Category') class="active" @endif>
		        <a href="{{route('Category')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Categories</span>
		        </a>
		    </li>
			<li @if($Menu=='SubCategory') class="active" @endif>
		        <a href="{{route('SubCategory')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Sub Categories</span>
		        </a>
		    </li>

		    <!-- <li @if($Menu=='Size') class="active" @endif>
		        <a href="{{route('Size')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Sizes</span>
		        </a>
		    </li> -->
			<!-- <li @if($Menu=='Color') class="active" @endif>
		        <a href="{{route('Color')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Colors</span>
		        </a>
		    </li> -->

		    
		    
		    
		    <!-- <li @if($Menu=='Pincode') class="active" @endif>
		        <a href="{{route('Pincode')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Pincode</span>
		        </a>
		    </li> -->

		    <li @if($Menu=='language') class="active" @endif>
		        <a href="{{route('Language')}}" class="waves-effect">
		          <i class="fa fa-tasks"></i><span>Language</span>
		        </a>
		    </li>

		    <li @if($Menu=='Banner') class="active" @endif>
		        <a href="{{route('Banner')}}" class="waves-effect">
		          <i class="fa fa-picture-o"></i><span>Banner</span>
		        </a>
		    </li>
	    </ul>
		

	</div>

	<header class="topbar-nav">
	  <nav class="navbar navbar-expand fixed-top gradient-ibiza">
	    <ul class="navbar-nav mr-auto align-items-center">
	      <li class="nav-item">
	        <a class="nav-link toggle-menu" href="javascript:void();">
	          <i class="icon-menu menu-icon"></i>
	        </a>
	      </li>
	    </ul>
	    <ul class="navbar-nav align-items-center right-nav-link">
	      <li class="nav-item">
	        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
	          <span class="user-profile">
	            <img src="{{Session::get('admin_icon')}}" class="img-circle" alt="user avatar">
	          </span>
	        </a>
			<style>
				.user-profile{
					width: 40px;
					height: 40px;
					border-radius: 50%;
					box-shadow: 0 16px 38px -12px rgba(0,0,0,.56), 0 4px 25px 0 rgba(0,0,0,.12), 0 8px 10px -5px rgba(0,0,0,.2);
					display: block;
					padding: 4px;

				}
				.user-profile img{
					width: auto;;
					max-height: 17px;
					height: initial;
					box-shadow: none;
					border-radius: 0;
					margin-right: 15px;
				}
				.avatar{
					width: 50px;
					height: 50px;
					border-radius: 50%;
					border: 1px solid #ccc;
					display: inline-flex;
					align-items: center;
					text-align: center;

				}
				.avatar img{
					width: 40px !important;
					height: auto !important;
					box-shadow: none;
					border-radius: 0 !important;
					align-self: initial !important;
					vertical-align: initial;
					margin: auto !important;
				}
			</style>

	        <ul class="dropdown-menu dropdown-menu-right animated fadeIn">
	          <li class="dropdown-item user-details">
	            <a href="javaScript:void();">
	              <div class="media">
	                <div class="avatar">
	                  <img class="align-self-start mr-3" src="{{Session::get('admin_icon')}}" alt="user avatar">
	                </div>
	                <div class="media-body">
	                  <h6 class="mt-2 user-title">{{Session::get('admin_name')}}</h6>
	                  <p class="user-subtitle">{{Session::get('admin_email')}}</p>
	                </div>
	              </div>
	            </a>
	          </li>
	          <li class="dropdown-divider"></li>
	          <li class="dropdown-item"><a href="{{route('Setting')}}"><i class="icon-wallet mr-2"></i> Setting</a></li>
	          <li class="dropdown-divider"></li>
	          <li class="dropdown-item"><a href="{{route('Logout')}}"><i class="icon-power mr-2"></i> Logout</a></li>
	        </ul>
	      </li>
	    </ul>
	  </nav>
	</header>
	<div class="clearfix"></div>	
	@yield("content")
	<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
</div>

<script src="{{ asset('Admin/assets/js/jquery.min.js')}}"></script>
<script src="{{ asset('Admin/assets/js/popper.min.js')}}"></script>
<script src="{{ asset('Admin/assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('Admin/assets/plugins/simplebar/js/simplebar.js')}}"></script>
<script src="{{ asset('Admin/assets/js/sidebar-menu.js')}}"></script>
<script src="{{ asset('Admin/assets/js/app-script.js')}}"></script>
<script src="{{ asset('Admin/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('Admin/assets/js/additional-methods.min.js')}}"></script> 
<script src="{{ asset('Admin/assets/js/jquery.dataTables.js')}}"></script>
@yield('javascript')
</body>
</html>