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
            <li class="breadcrumb-item active" aria-current="page">Add Sub Category</li>
          </ol>
        </div>
      </div>
      
      <form action="{{ route('InsertCategory')}}" enctype="multipart/form-data" method="post" id="AddForm" name="AddForm" novalidate="novalidate">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
          <div class="col-lg-12 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="card-title">Add Sub Category</div>
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
                      <label for="input-1">Name</label>
                      <input type="text" class="form-control" id="name" name="name" value="{{$Result->name}}" readonly>
                    </div> 
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="input-1">Sub Category</label>
                      <select class="form-control" id="sub-category" name="sub_category_id">
                        <option value="">Select</option>
                        @foreach ($subCategories as $scategory) {
                        <option value="<?php echo $scategory->id; ?>"><?php echo $scategory->name; ?></option>
                        @endforeach
                    </select>
                    </div> 
                  </div>

                   </div>
                  
                  <div class="row">
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

       
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
            
               <hr>
                <span id="Return_msg">
                  <?php
                  if(Session::has('message')){
                    echo Session::get('message');
                  }
                  ?>
                </span>
              <div class="table-responsive">
                <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th class="FontSize">#</th>
                      <th class="FontSize">Name</th>
                      <th class="FontSize">Date</th>
                      <th class="FontSize">Status</th>
                      <th class="FontSize">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($subCategories as $i => $row)
                    <tr>
                      <td class="FontSize">{{$i+1}}</td>
                      <td class="FontSize">{{ $row->name}}
                      </td>
                      <td class="FontSize">{{ date('d-m-Y',strtotime($row->created_at)) }}</td>
                      <td class="FontSize">@if($row->status==1) {{ "active" }} @else {{ "inactive" }} @endif</td>
                      <td class="FontSize">
                          <a href="{{route('EditCategory',['id'=>base64_encode($row->id)])}}">
                            <button class="btn btn-success"><i class="fa fa-edit"></i></button>
                          </a>
                          <!-- <a href="{{route('DeleteCategory',['id'=>base64_encode($row->id)])}}" onclick="return confirm('Are you sure?')">
                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                          </a> -->
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                 
                </table>
             </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>  

@stop

@section('javascript')
  <link rel="stylesheet" href="{{ asset('Admin/DatePicker/default.css')}}" type="text/css">
  <script src="{{ asset('Admin/assets/validation/Product.js')}}"></script>
@stop