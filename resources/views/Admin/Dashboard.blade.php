@extends('Admin.default')
@section('content')
  
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3 class="fa fa-list"></h3>
            <p>User List</p>  
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="{{route('User')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
       <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner"> 
            <h3 class="fa fa-list"></h3>
            <p>Order List</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div> 
      
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
           <h3 class="fa fa-list"></h3>
            <p>Products List</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{route('Product')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
              <h3 class="fa fa-list"></h3>
             <p>Categories List</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{route('Category')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
              <h3 class="fa fa-list"></h3>
             <p> Sub Categories List</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{route('SubCategory')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
              <h3 class="fa fa-list"></h3>
             <p>Sizes List</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{route('Size')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div> 

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
          <div class="inner">
              <h3 class="fa fa-list"></h3>
             <p>Colors List</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{route('Color')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div> 
      
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3 class="fa fa-list"></h3>
            <p>Bnners List</p>  
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="{{route('Banner')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
</div>
@endsection