@extends('Admin.default')

@section('content')

  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
          </ol>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">User List</h5>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead class="thead " style="background-color:#16088E;">
                    <tr>
                      <th class="FontSize text-white">#</th>
                      <th class="FontSize text-white">Name</th>
                      <th class="FontSize text-white">Email</th>
                      <th class="FontSize text-white">Number</th>

                      <!-- <th class="FontSize text-white">Address</th>
                      <th class="FontSize text-white">User Image</th> -->

                      <th class="FontSize text-white">Date</th>
                      <th class="FontSize text-white">Status</th>
                      <!-- <th class="FontSize text-white">Action</th> -->

                    </tr>
                  </thead>
                    <tbody>
                  @foreach($Result as $i => $row)
                  <tr>
                    <td class="FontSize">{{$i+1}}</td>
                    <td class="FontSize">{{ ucfirst($row->first_name) }} {{ ucfirst($row->last_name) }}</td>
                    <td class="FontSize">{{ $row->email }}</td>
                    <td class="FontSize">{{ $row->mobile }}</td>
                    <td class="FontSize">{{ date('d-m-Y',strtotime($row->created_at)) }}</td>
                    <td class="FontSize">
                    <select   onChange="changeStatus({{$row->id}});">
                    @if($row->status==1) 
                    <option value="1" selected>Active</option>
                    <option value="0">In Active</option>
                    @else 
                    <option value="1" >Active</option>
                    <option value="0" selected>In Active</option>
                    @endif
                   </select>
                    
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

<!-- <script>
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

function changeStatus(id)
{


  swal({
  title: "Are you sure?",
  text: "Want to change Status?",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {

    $.ajax({
url: '{{route('UserChangeStatus')}}',
          method: "post",
          headers:{
      'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
          data: {
            action:'ChangeStatus',
             user_id:id,
  },
          success: function (data) {  
              dataArray = JSON.parse(data);  
if(dataArray.status == 'success')
{
}
else{
}
},
});

    swal("User Status Changed!", {
      icon: "success",
    });

    location.reload(true);

  } else {
    
    swal("User Status Not Changed!");
    location.reload(true);
  }
});











  
}

  $(document).ready( function () {
    $('.table').DataTable();
});
</script>

@stop  