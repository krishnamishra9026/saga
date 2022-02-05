@extends('Admin.default')
@section('css')
<link href="{{ asset('public/Admin/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('public/Admin/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
@stop
@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reservation</li>
          </ol>
        </div>
      </div>   
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Reservation List</h5>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" id="example">
                  <thead class="thead-dark">
                    <tr>
                      <th class="FontSize">#</th>
                      <th class="FontSize">Name</th>
                      <th class="FontSize">Mobile</th>
                      <th class="FontSize">Reserved Date</th>
                      <th class="FontSize">Reserved Time</th>
                      <th class="FontSize">No. of Guest</th>
                      <th class="FontSize">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=1;
                    foreach($ReservationArr as $row) {
                        
                        $Status = '<button class="btn btn-danger">Pending</button>';
                        if($row->status=='1'){
                            $Status = '<button class="btn btn-success">Accepted</button>';
                        }
                    ?>
                      <tr>
                        <td class="FontSize"><?=$i?></td>
                        <td class="FontSize"><?=$row->name?></td>
                        <td class="FontSize"><?=$row->mobile?></td>
                        <td class="FontSize"><?=date('Y-m-d',strtotime($row->reserved_date))?></td>
                        <td class="FontSize"><?=date('H:i:s',strtotime($row->reserved_time))?></td>
                        <td class="FontSize"><?=$row->no_of_guest?></td>
                        <td class="FontSize"><button class="btn btn-success">Details</button> <?=$Status?></td>
                      </tr>
                    <?php
                    $i++;
                    }
                    ?>
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
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="{{ asset('public/Admin')}}/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>
  <script>
    $(document).ready(function() {
      //Default data table
       $('#default-datatable').DataTable();
       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print']
      });
      table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );     
    });
    function OpenModal(id,status){
      $('#DispalyModal').trigger('click');
    }
  </script>
@stop  