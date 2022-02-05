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
            <li class="breadcrumb-item active" aria-current="page">Payment History</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Payment History</h5>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" id="example">
                  <thead class="thead-dark">
                    <tr>
                      <th class="FontSize">Sr</th>
                      <th class="FontSize">Name</th>
                      <th class="FontSize">Email</th>
                      <th class="FontSize">Mobile</th>
                      <th class="FontSize">Order ID</th>
                      <th class="FontSize">Amount</th>
                      <!--<th class="FontSize">Payment Status</th>-->
                      <th class="FontSize">Status</th>
                      <th class="FontSize">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php
                    $i=1;
                    foreach($Result as $row) {
    
                      $Status = '<a href="javascript:void(0)"><span class="badge badge-danger m-1">'.$row->STATUS_PMT.'</span></a>';
											if($row->STATUS_PMT=='Successful'){
												$Status = '<a href="javascript:void(0)"><span class="badge badge-success m-1">Success</span></a>';
											}
		      
		      						$user = DB::table('users')->select('name','email','mobile')->where('id',$row->user_id)->first();
		      						$UserName = $user->name; 
                    ?>
                      <tr>
				        				<td class="FontSize"><?=$i?></td>
				        				<td class="FontSize"><?=$UserName?></td>
                                        <td class="FontSize"><?=$user->email?></td>
                                        <td class="FontSize"><?=$user->mobile?></td>
										<td class="FontSize"><?=$row->ORDERID_PMT?></td>
										<td class="FontSize"><i aria-hidden="true" class="fa fa-inr"></i><?=$row->TXNAMOUNT_PMT?></td>
				        				<!--<td class="FontSize"><?=$row->RESPCODE_PMT?></td>-->
				        				<td class="FontSize"><?=$Status?></td>
				        				<td class="FontSize"><?=date('Y-m-d H:i:s',strtotime($row->TXNDATE_PMT))?></td>
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
  <script src="{{ asset('public/Admin')}}/assets/validation/Payment.js"></script>
@stop  