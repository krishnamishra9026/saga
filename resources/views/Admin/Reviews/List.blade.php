@extends('Admin.default')

@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Review List</li>
          </ol>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Review List</h5>
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
                      <th class="FontSize">Product Name</th>
                      <th class="FontSize">Name</th>
                      <th class="FontSize">Email Id</th>
                      <th class="FontSize">Phone</th>
                      <th class="FontSize">Review</th>
                      <th class="FontSize">Image</th>
                      <th class="FontSize">date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($OurReviewList as $i => $row)
                    <?php
                    
                       $user = DB::table('user_authentication_details')
                                    ->select('*')
                                    ->where('id',$row->user_id)
                                    ->first();
                                     
                      $productDetails = DB::table('products')
                                    ->select('name')
                                    ->where('id',$row->product_id)
                                    ->first();
                     
                    ?>
                    
                    <tr>
                      <td class="FontSize">{{$i+1}}</td>
                      <td class="FontSize">{{$productDetails->name}}</td>
                      <td class="FontSize">{{$user->first_name}} {{$user->last_name}}</td>
                      <td class="FontSize">{{ $user->email}}</td>
                      <td class="FontSize">{{ $user->mobile}}</td>
                      <td class="FontSize">{{ $row->review}}</td>
                      <td class="FontSize"><img  width="50" height="50" src="{{ asset('/images/'.$user->image) }}" ></td>
                      <td class="FontSize">{{ date('d-m-Y',strtotime($row->created_at)) }}</td>
                 
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

  