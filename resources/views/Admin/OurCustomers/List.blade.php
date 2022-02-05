@extends('Admin.default')

@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Comment List</li>
          </ol>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Comment List</h5>
                </div>
                <!--<div class="col-sm-6">-->
                <!--  <a href="{{route('AddOurCustomers')}}">-->
                <!--    <button type="button" class="btn btn-secondary m-1 pull-right">Add Our Customers</button>-->
                <!--  </a>-->
                <!--</div>-->
              </div>
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
                      <th class="FontSize">Comment</th>
                      <!--<th class="FontSize">Description</th>-->
                      <th class="FontSize">Name</th>
                      <th class="FontSize">Email Id</th>
                      <th class="FontSize">date</th>
                      <!--<th class="FontSize">Action</th>-->
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($OurCustomers as $i => $row)
                    <tr>
                      <td class="FontSize">{{$i+1}}</td>
                      <td class="FontSize">{{ $row->user_comment}}</td>
                      <td class="FontSize">{{ $row->user_name}}</td>
                      <td class="FontSize">{{ $row->user_email_id}}</td>
                      <td class="FontSize">{{ date('d-m-Y',strtotime($row->comment_add_date)) }}</td>
                 
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
<script type="text/javascript">
  $(document).ready( function () {
    $('.table').DataTable();
});
</script>
@stop

  