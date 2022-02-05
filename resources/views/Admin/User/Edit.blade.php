@extends('Admin.default')

@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Member')}}">Member List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Member</li>
          </ol>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <div class="card">
            <div class="card-body">
              <div class="card-title">Edit Member</div>
              <hr>
              <span id="Return_msg"></span>
              <form action="javascript:void(0)" method="post" id="EditForm" name="EditForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="MemberID" id="MemberID" value="{{ $Result->id }}">
                <input type="hidden" name="OldMobile" id="OldMobile" value="{{ $Result->mobile }}">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Username</label>
                      <input type="text" class="form-control" name="username" id="username" value="{{ $Result->ucode }}" readonly="">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">First Name</label>
                      <input type="text" class="form-control" name="f_name" id="f_name" value="{{ $Result->first_name }}" placeholder="First Name">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Last Name</label>
                      <input type="text" class="form-control" name="l_name" id="l_name" value="{{ $Result->last_name }}" placeholder="Last Name">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Email Address</label>
                      <input type="text" class="form-control" name="email" id="email" value="{{ $Result->email }}" readonly="">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Mobile</label>
                      <input type="text" class="form-control" name="mobile" onchange="CheckUserMobie();" id="mobile" value="{{ $Result->mobile }}" placeholder="Mobile">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Referal Username</label>
                      <input type="text" class="form-control" name="sponser_id" onchange="CheckUserSponsor();" id="sponser_id" value="{{ $Result->sponsor_id }}" placeholder="Referal Username">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Parent Username</label>
                      <input type="text" class="form-control" name="pcode" onchange="CheckUserPCode();" id="pcode" value="{{ $Result->pcode }}" placeholder="Parent Username">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Location</label>
                      <select class="form-control" id="location" name="location">
                        <option value="">Select Location</option>
                        @foreach($LocationList as $Location)
                          <option value="{{$Location->location}}" @if($Location->location == $Result->address) selected="" @endif>{{$Location->location}}</option>
                        @endforeach
                      </select>
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Password</label>
                      <input type="password" class="form-control" name="password" id="password" value="{{ $Result->password }}" placeholder="Password" aria-required="true" aria-invalid="false">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Confirm Password</label>
                      <input type="password" class="form-control" name="c_password" id="c_password" value="{{ $Result->password }}" placeholder="Confirm Password">
                    </div> 
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-1">Gender</label>
                      <select class="form-control" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male" @if($Result->gender=='Male') selected="" @endif>Male</option>
                        <option value="Female" @if($Result->gender=='Female') selected="" @endif>Female</option>
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
  <script src="{{ asset('public/Admin')}}/assets/validation/EditMember.js"></script>
@stop  