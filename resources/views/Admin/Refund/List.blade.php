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
            <li class="breadcrumb-item active" aria-current="page">Refund</li>
          </ol>
        </div>
      </div>   
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Refund List</h5>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" >
                  <thead class="thead" style="background-color:#016937;" >
                    <tr>
                      <th class="FontSize text-white">#</th>
                      <th class="FontSize text-white">Name</th>
                      <th class="FontSize text-white">Email</th>
                      <th class="FontSize text-white">Mobile</th>
                      <th class="FontSize text-white">Order ID</th>
                      <th class="FontSize text-white">RazorPay Payment ID</th>
                      <th class="FontSize text-white">Invoice</th>
                      <th class="FontSize text-white">Amount</th>
                      <th class="FontSize text-white">Status</th>
                      <th class="FontSize text-white">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=1;
                    foreach($OrderArr as $row) {
                        
                        $user = DB::table('user_authentication_details')
                                    ->select('*')
                                    ->where('id',$row->user_id)
                                    ->first();
                        
                        $Status = '<span class="badge badge-danger m-1">Failed</span>';
                        if($row->status=='success'){
                            $Status = '<span class="badge badge-success m-1">Success</span>';
                        }
                    ?>
                      <tr>
                        <td class="FontSize"><?=$i?></td>
                        
                        <td class="FontSize"><?=$user->first_name.$user->last_name?></td>
                        <td class="FontSize"><?=$user->email?></td>
                        <td class="FontSize"><?=$user->mobile?></td>
                        <td class="FontSize"><?=$row->order_id?></td>
                        <td class="FontSize"><?=$row->razorpay_payment_id?></td>
                        <td class="FontSize"><a href="#">Get Invoice</a></td>
                        <td class="FontSize"><i aria-hidden="true" class="fa fa-inr"><?=$row->txn_amount?></i></td>
                        <td class="FontSize"><?=$Status?></td>
                        <td class="FontSize"><?=date('Y-m-d H:i:s',strtotime($row->txn_date))?></td>
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
  <script src="https://printjs-4de6.kxcdn.com/print.min.css"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <script>
$(document).ready(function() {
    $('.table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );
</script>

<script type="text/javascript">
  $(document).ready( function () {
    $('.table').DataTable();
});
</script>
@stop  