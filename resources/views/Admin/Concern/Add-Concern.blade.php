@extends('Admin.default')


@section('content')
  
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('Category')}}">Category List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Concern</li>
          </ol>
        </div>
      </div>
      
      <form action="{{ route('InsertConcernInCategory')}}" enctype="multipart/form-data" method="post" id="AddForm" name="AddForm" novalidate="novalidate">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Add Concern</div>
                <hr>
                <span id="Return_msg">
                  <?php
                  if(Session::has('message')){
                    echo Session::get('message');
                  }
                  ?>
                </span>
                <div class="row">
                   
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Language</label>
                      <select class="form-control" id="status" name="language_id">

                        <option value="select">Select</option>
                        @foreach( $Language as $lang)
                        <option value="{{$lang->id}}">{{$lang->language_name}}</option>
                        @endforeach
                      </select>
                    </div> 
                  </div>

                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Category</label>
                      <input type="text" class="form-control" id="name" name="category_name" value="{{$Result->category_name}}" readonly>
                    </div> 
                  </div>

                 </div>

                 <div class="row">

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Add Concern</label>
                      <select class="form-control" id="sub-category" name="sub_category_id">
                        <option value="">Select</option>
                        @foreach ($Concern as $concern) {
                        <option value="<?php echo $concern->id; ?>"><?php echo $concern->name; ?></option>
                        @endforeach
                    </select>
                    </div> 
                  </div>

                 
                     <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Status</label>
                      <select class="form-control" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">De-Active</option>
                      </select>
                    </div> 
                  </div>
                  </div>

                <div class="row">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary  pull-right" id="SaveBtn">Save</button>
                </div>
              </div>
              </div>
            </div>
          </div>
          
        </div>
      </form>
    </div>
  </div>  

@stop

@section('javascript')
  <link rel="stylesheet" href="{{ asset('Admin/DatePicker/default.css')}}" type="text/css">
  <script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>
@stop