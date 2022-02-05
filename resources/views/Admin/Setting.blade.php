@extends('Admin.default')
@section('content')

  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Setting</li>
          </ol>
        </div>
      </div>
     
      <div class="row">
        <div class="col-lg-4">
          <div class="profile-card-4">
            <div class="card">
              <div class="card-body text-center  rounded-top" style="background-color:#16088e;">
                <div class="user-box">
                  <?php
                  $Image = asset('Admin/assets/images/logo-icon.png');
                  if($Setting->image!=''){
                    $Image = asset('Admin/assets/images/'.$Setting->image);
                  }
                  ?>
                  <img src="{{$Image}}" id="ImagePreview" alt="">
                </div>
                <h5 class="mb-1 text-white">{{$Setting->first_name}}</h5>
                <h6 class="text-light">Administrator</h6>
              </div>
              <div class="card-body">
                <ul class="list-group shadow-none">
                  <li class="list-group-item">
                    <div class="list-icon">
                      <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="list-details">
                      <span>{{$Setting->address}}</span>
                      <small>Address</small>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="list-icon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <div class="list-details">
                      <span>{{$Setting->mobile}}</span>
                      <small>Mobile</small>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="list-icon">
                      <i class="fa fa-envelope"></i>
                    </div>
                    <div class="list-details">
                      <span>{{$Setting->email}}</span>
                      <small>Email Address</small>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <span id="Profile_msg">
                @if(Session::has('message'))           
                  <?=Session::get('message')?>
                @endif
              </span>
              <ul class="nav nav-pills nav-pills-primary nav-justified">
                <li class="nav-item">
                  <a href="javascript:void();"  id = "change-profile-color" data-target="#profile" data-toggle="pill" class="nav-link active show"> Profile</a>
                </li>
                <li class="nav-item">
                  <a href="javascript:void();" id = "change-password-color" data-target="#ChangePassword" data-toggle="pill" class="nav-link">Change Password</a>
                </li>
              </ul>
              <div class="tab-content p-3">
                <div class="tab-pane active show" id="profile">
                  <div class="row">
                    <div class="col-lg-12">
                      <form method="post" action="{{route('UpdateSetting')}}" id="ProfileForm" name="ProfileForm" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group row">
                          <label class="col-lg-4 col-form-label form-control-label">First Name</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="first_name" id="first_name" value="{{$Setting->first_name}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-4 col-form-label form-control-label">Last Name</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="last_name" id="last_name" value="{{$Setting->last_name}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-4 col-form-label form-control-label">Email</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="email" name="email" id="email" value="{{$Setting->email}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-4 col-form-label form-control-label">Mobile</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="mobile" id="mobile" value="{{$Setting->mobile}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-4 col-form-label form-control-label">Address</label>
                          <div class="col-lg-8">
                            <textarea class="form-control" name="address" id="address">{{$Setting->address}}</textarea>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label"></label>
                          <div class="col-lg-9">
                            <input type="submit" class="btn btn-primary" value="Save">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="ChangePassword">
                  <div class="row">
                    <div class="col-lg-12">
                      <form method="post" action="" id="ChangePasswrodForm" name="ChangePasswrodForm" >
                        <div class="form-group row">
                          <label class="col-lg-4 col-form-label form-control-label">Old Password</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="text" name="old_password" id="old_password" value="">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-4 col-form-label form-control-label">New Password</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="password" name="new_password" id="new_password" value="">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-4 col-form-label form-control-label">Confirm Password</label>
                          <div class="col-lg-8">
                            <input class="form-control" type="password" id="confirm_password" name="confirm_password">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label"></label>
                          <div class="col-lg-9">
                            <input type="submit" class="btn btn-primary" id="ChangePasswordBtn" value="Save">
                          </div>
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
    </div>
  </div>
@stop

@section('javascript')
  <script src="{{ asset('Admin/assets/validation/Setting.js')}}"></script>
  <script>
  /*$("#change-profile-color").click(function(){

    $('#change-profile-color').css('background-color','#016937');

         $('#change-password-color').css('background-color','#FFFFFF');
   

});

$("#change-password-color").click(function(){
    $('#change-profile-color').css('background-color','#FFFFFF');

         $('#change-password-color').css('background-color','#016937');
   

});*/

  </script>
@stop