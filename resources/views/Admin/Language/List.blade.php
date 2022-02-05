@extends('Admin.default')

@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Language List</li>
          </ol>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Language List</h5>
                </div>
                <div class="col-sm-6">
                  <a href="{{route('AddLanguage')}}">
                    <button type="button" class="btn btn-secondary m-1 pull-right">Add Language</button>
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
                <table class="table"  >
                  <thead class="thead" style="background-color:#16088E;" >
                    <tr>
                      <th class="FontSize text-white">#</th>
                      <th class="FontSize text-white">Language</th>
                      <th class="FontSize text-white">Language Slug</th>
                       <th class="FontSize text-white">Date</th>
                      <th class="FontSize text-white">Status</th>
                      <th class="FontSize text-white">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($Category as $i => $row)
                    <tr>
                      <td class="FontSize">{{$i+1}}</td>
                      <td class="FontSize">{{ $row->language_name}}</td>
                      <td class="FontSize">{{ $row->language_slug}}</td>
                      <td class="FontSize">{{ date('d-m-Y',strtotime($row->created_at)) }}</td>
                      <td class="FontSize">@if($row->status==1) {{ "active" }} @else {{ "inactive" }} @endif</td>
                      <td class="FontSize">
                          <a href="{{route('EditLanguage',['id'=>base64_encode($row->id)])}}">
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
<!--   <script>
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
</script> -->

<script type="text/javascript">
  $(document).ready( function () {
    $('.table').DataTable();
});
</script>
@stop

  