@extends('Admin.default')

@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Offers List</li>
          </ol>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Offers List</h5>
                </div>
                <div class="col-sm-6">
                  <a href="{{route('AddOffers')}}">
                    <button type="button" class="btn btn-secondary m-1 pull-right">Add Offer</button>
                  </a>
                </div>
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
                      <th class="FontSize">Title</th>
                      <th class="FontSize">Description</th>
                      <th class="FontSize">Spent Amount(£)</th>
                      <th class="FontSize">Offer For</th>
                      <th class="FontSize">Offer Day/s</th>
                      <th class="FontSize">First order offer</th>
                      <th class="FontSize">Default Offer</th>
                      <th class="FontSize">Date</th>
                      <th class="FontSize">Status</th>
                      <th class="FontSize">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($Offers as $i => $row)
                    @php
                    $Days ="";
                    if(isset($row->offer_day)){
                      $dayArr = json_decode($row->offer_day);
                      $Days = implode(', ', $dayArr);
                    }
                     
                    @endphp
                    <tr>
                      <td class="FontSize">{{$i+1}}</td>
                      <td class="FontSize">{{ $row->offer_title }}</td>
                      <td class="FontSize">{{ $row->offer_description}}</td>
                      <td class="FontSize">{{ $row->spent_amount}}</td>
                      <td class="FontSize">{{ $row->offer_for}}</td>
                      <td class="FontSize">{{ $Days}}</td>
                      <td class="FontSize">{{ $row->first_order_offer}}</td>
                      <td class="FontSize">{{ $row->default_offer}}</td>
                      <td class="FontSize">{{ date('d-m-Y',strtotime($row->created_at)) }}</td>
                      <td class="FontSize">@if($row->status==1) {{ "active" }} @else {{ "inactive" }} @endif</td>
                      <td class="FontSize">
                          <a href="{{route('EditOffers',['id'=>base64_encode($row->id)])}}">
                            <button class="btn btn-success"><i class="fa fa-edit"></i></button>
                          </a>
                          <a href="{{route('DeleteOffers',['id'=>base64_encode($row->id)])}}" onclick="return confirm('Are you sure?')">
                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                          </a>
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
<script type="text/javascript">
  $(document).ready( function () {
    $('.table').DataTable();
});
</script>
@stop

  