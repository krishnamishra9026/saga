@extends('Admin.default')
@section('content')
  
<div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Member')}}">Member List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Member</li>
          </ol>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <div class="card">
            <div class="card-body">
              <div class="card-title">Add Member</div>
              <hr>
              <span id="Return_msg"></span>
              <form action="javascript:void(0)" method="post" id="AddForm" name="AddForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Username</label>
                      <input type="text" class="form-control" name="username" onchange="CheckUserName()" id="username" value="" placeholder="Username">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">First Name</label>
                      <input type="text" class="form-control" name="f_name" id="f_name" value="" placeholder="First Name">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Last Name</label>
                      <input type="text" class="form-control" name="l_name" id="l_name" value="" placeholder="Last Name">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Email Address</label>
                      <input type="text" class="form-control" name="email" onchange="CheckUserEmail();" id="email" value="" placeholder="Email Address">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Mobile</label>
                      <input type="text" class="form-control" name="mobile" onchange="CheckUserMobie();" id="mobile" value="" placeholder="Mobile">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Referal Username</label>
                      <input type="text" class="form-control" name="sponser_id" onchange="CheckUserSponsor();" id="sponser_id" value="{{env('SponsorID')}}" placeholder="Referal Username">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Parent Username</label>
                      <input type="text" class="form-control" name="pcode" onchange="CheckUserPCode();" id="pcode" value="{{env('SponsorID')}}" placeholder="Parent Username">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Location</label>
                      <select class="form-control" id="location" name="location">
                        <option value="">Select Location</option>
                        @foreach($LocationList as $Location)
                          <option value="{{$Location->location}}">{{$Location->location}}</option>
                        @endforeach
                      </select>
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Password</label>
                      <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" aria-required="true" aria-invalid="false">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Confirm Password</label>
                      <input type="password" class="form-control" name="c_password" id="c_password" value="" placeholder="Confirm Password">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Gender</label>
                      <select class="form-control" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div> 
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary  pull-right" id="SaveBtn">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
@stop

@section('javascript')
  <script src="{{ asset('public/Admin')}}/assets/validation/Member.js"></script>
  <script type="text/javascript">
    $("#username").keyup(function() {
      var ReturnUsername = convertToSlug($('#username').val());
      $('#username').val(ReturnUsername);
      var username = $('#username').val();
      if(username.length>=6){
      }
    });
  </script>
@stop  