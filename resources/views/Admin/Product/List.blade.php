@extends('Admin.default')

@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Products List</li>
          </ol>
        </div>
      </div>
      
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Products List</h5>
                </div>
                <div class="col-sm-6">
                  <a href="{{route('AddProduct')}}">
                    <button type="button" class="btn btn-secondary m-1 pull-right">Add Product Manually</button>
                  </a>
                  <a href="#">
                    <button type="button" class="btn btn-secondary m-1 pull-right">Import Products</button>
                  </a>
                  <a href="#">
                    <button type="button" class="btn btn-secondary m-1 pull-right">Export Products</button>
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
                  <thead class="thead" style="background-color:#16088E;">
                    <tr>
                      <th class="FontSize text-white">#</th>
                      <th class="FontSize text-white">Name</th>
                      <th class="FontSize text-white">Price(SR)</th>
                      <th class="FontSize text-white">Discount Price(SR)</th>
                      <!-- <th class="FontSize text-white">Quantity</th> -->
                      <th class="FontSize text-white">Image</th>
                      <th class="FontSize text-white">Date</th>
                      <th class="FontSize text-white">Status</th>
                      <th class="FontSize text-white">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=1;  ?>
                    @foreach ($Result as $i => $row)
                    <?php
                    $imageArray = explode('|',$row->image);
                    ?>
                    <tr>
                      <td class="FontSize">{{ $row->id }}</td>
                      <td class="FontSize">{{ $row->name}}</td>
                      <td class="FontSize">SR {{ $row->price}}</td>
                      <td class="FontSize">SR {{ $row->discount_price}}</td>
                      <!-- <td class="FontSize">{{ $row->quantity}}</td> -->
                      <td class="FontSize">
                      <a><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal_<?php echo $i;?>">View image</button></a>
                      <div class="modal fade" id="myModal_<?php echo $i;?>" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title">Product Image</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                             </div>
                               <div style="height: 160px;overflow-y: auto;">
                            <div class="modal-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                      <th>Image</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                   foreach($imageArray as $key=>$value)
                                   {
                                     if(!empty($value))
                                  {
                                    ?>
                                    <tr>
                                <td class="FontSize"><img  width="70" height="70" src="{{ url('/upload/prd/'.$value) }}"></td>
                                    <td class="FontSize">
                                    <form class="ssgroup" action="{{ route('RemoveProductImg') }}" method="POST">
                                      {{ csrf_field() }}
                                      <input type="hidden" value="{{ $value }}" id="id" name="img">
                                      <input type="hidden" value="{{ $row->id }}" id="productId"  name="productId">
                                      <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                   </td>
                                  </tr>
                                  <?php 
                                  }
                                   }
                                    ?>
                                    </tbody>
                                  </table>
                                </div>
                                 
                            </div>
                          </div>
                        </div>
                    </div>
                      </td>

                      <!-- Button trigger modal -->

                      <!-- <td class="FontSize"><img  width="100" height="100" src="{{ url('/images/prd/'.$imageArray[0]) }}"></td> -->


                      <td class="FontSize">{{ date('d-m-Y',strtotime($row->created_at)) }}</td>
                      <td class="FontSize">@if($row->status==1) {{ "active" }} @else {{ "inactive" }} @endif</td>
                      <td class="FontSize">
                          <a href="{{route('EditProduct',['id'=>base64_encode($row->id)])}}">
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
    $('.table').DataTable( {
  "pageLength": 50
} );
});
</script>
@stop

  