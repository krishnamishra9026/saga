@extends('Admin.default')

@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Menu</li>
          </ol>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Menu List</h5>
                </div>
                <div class="col-sm-6">
                  <a href="{{route('AddMenu')}}">
                    <button type="button" class="btn  btn-secondary m-1 pull-right">Add Menu</button>
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
                  <thead class="thead" style="background-color:#16088E;" >
                    <tr>
                      <th class="FontSize text-white">#</th>
                      <th class="FontSize text-white">Name</th>
                      <th class="FontSize text-white">Status</th>
                      <th class="FontSize text-white">Action</th>
                    </tr>
                  </thead>
                    <tbody>
                  @foreach($Result as $i => $row)

                  <tr>
                    <td class="FontSize">{{$i+1}}</td>
                    <td class="FontSize">{{ ucfirst($row->name) }}</td>
                    <td class="FontSize">@if($row->status==1) {{ "active" }} @else {{ "inactive" }} @endif</td>
                    <td class="FontSize">
                        <a href="{{route('EditMenu',['id'=>base64_encode($row->id)])}}">
                          <button class="btn btn-success"><i class="fa fa-edit"></i></button>
                        </a>
                        <a href="{{route('DeleteMenu',['id'=>base64_encode($row->id)])}}" onclick="return confirm('Are you sure?')">
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

  <span id="DispalyModal" data-toggle="modal" data-target="#smallsizemodal"></span>
  <div class="modal fade" id="smallsizemodal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fa fa-star"></i> Change Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="CloseBtn" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          <button type="button" class="btn btn-primary" id="ModalBtn"><i class="fa fa-check-square-o"></i> Save</button>
        </div>
      </div>
    </div>
  </div>
@stop

@section('javascript')
<script src="{{ asset('public/Admin')}}/assets/validation/User.js"></script>
<script type="text/javascript">
  $(document).ready( function () {
    $('.table').DataTable();
});
</script>

@stop  