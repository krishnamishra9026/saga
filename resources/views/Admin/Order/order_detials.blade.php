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
            <li class="breadcrumb-item active" aria-current="page">Order</li>
          </ol>
        </div>
      </div>   
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <h5 class="card-title">Order List</h5>
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
                      <th class="FontSize text-white">Transaction ID</th>
                      <th class="FontSize text-white">Invoice</th>
                      <th class="FontSize text-white">Order Details</th>
                      <th class="FontSize text-white">Amount</th>
                      <th class="FontSize text-white">Order Status</th>
                      <th class="FontSize text-white">Order ship Status</th>
                      <th class="FontSize text-white">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=1;
  
                        $user = DB::table('user_authentication_details')
                                    ->select('*')
                                    ->where('id',$orderData->user_id)
                                    ->first();
                        
                         $Status = '<span class="badge badge-success m-1">Success</span>';
                        if($orderData->payment_type=='Cash On Delivery'){
                            $Status = '<span class="badge badge-success m-1">Success</span>';
                        }
                            //   print_r($user);
                            //     exit();
                    ?>
                      <tr>
                        <td class="FontSize"><?=$i?></td>
                        
                        <td class="FontSize"><?=$user->first_name.$user->last_name?></td>
                        <td class="FontSize"><?=$user->email?></td>
                        <td class="FontSize"><?=$user->mobile?></td>
                        <td class="FontSize"><?=$orderData->order_id?></td>
                        <td class="FontSize"><?=$orderData->transaction_id?></td>
                        <td class="FontSize"><a href="{{route('GenerateInvoice',['id'=>$orderData->order_id])}}" >Get Invoice</a></td>
                        <td class="FontSize"><a href="{{route('GetOrderDetails',['id'=>$orderData->order_id])}}" >Get Order Details</a></td>

                        <td class="FontSize">SAR <?=$orderData->txn_amount?></td>
                        <td class="FontSize"><?=$Status?></td>
                        	 	<td >
							@if($orderData->order_ship_status == 'shipping')
						<span class="badge badge-primary " style="font-size:10px" >Shipping</span>
							@elseif($orderData->order_ship_status == 'pending')
						    <span class="badge badge-warning " style="font-size:10px" >Pending</span>
							@elseif($orderData->order_ship_status == 'processing')
						    <span class="badge badge-secondary " style="font-size:10px" >Processing</span>
	                         @elseif($orderData->order_ship_status == 'complete')
						    <span class="badge badge-success " style="font-size:10px" >Complete</span>
	                         @else
						    <span class="badge badge-danger " style="font-size:10px" >Cancel</span>

							@endif
						</td>
                        <td class="FontSize"><?=date('Y-m-d H:i:s',strtotime($orderData->txn_date))?></td>
                      </tr>
                    <?php
                    $i++;
                 
                    ?>
                  </tbody>
                </table>
                                  <!--<tr>-->
                                      
            </div>
	                          <h4   class=" mt-4 mb-4"> 
	                          @if($orderData->order_ship_status == 'shipping')
					  Order status :	<span class="badge badge-primary " style="font-size:15px" >Shipping</span>
							@elseif($orderData->order_ship_status == 'pending')
						  Order status :    <span class="badge badge-warning " style="font-size:15px" >Pending</span>
							@elseif($orderData->order_ship_status == 'processing')
						    Order status :  <span class="badge badge-secondary " style="font-size:15px" >Processing</span>
	                         @elseif($orderData->order_ship_status == 'complete')
						    Order status :  <span class="badge badge-success " style="font-size:15px" >Complete</span>
	                         @else
						    Order status :  <span class="badge badge-danger " style="font-size:15px" >Cancel</span>

							@endif
               
                    <!--Order status : {{$orderData->status}}-->
                </h4>
            
                                      
    <form action="{{route('ShipUserOrder')}}" enctype="multipart/form-data" method="post" id="AddForm" name="AddForm"  autocomplete="off">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="user_id" value="{{$orderData->user_id}}">
      <input type="hidden" name="order_id" value="{{$orderData->id}}">

    <div class="row ">
         <div class="col-sm-12">
                    <div class="form-group">
                      <label for="input-1">Order Type</label>
                      <select class="form-control " id="order_status" name="status" onchange="showpacketdetails(this);" >
                        <option value="" selected >Select Status</option>
                        <option value="shipping">Shipping</option>
                        <!--<option value="pending">Pending</option>-->
                        <option value="processing">Processing</option>
                        <option value="complete">Complete</option>
                        <option value="cancel">Cancel</option>

                        <!--<option value="trending_item">Trending</option>-->
                      </select>
                       <span id="product_type_status_msg"></span>
                    </div> 
                  </div>
                  
                  
                        <div class="col-md-12" id="orderlengthbreadth" style="display:none">
                        <div class="row"  >
                    <div class="col-sm-3">
                    <div class="form-group">
                      <label for="input-1">Packet length</label>
                      <input type="text" class="form-control" id="name" name="length" placeholder="in cms" placeholder="Name" onchange="HideErr('product_name_msg')">
                       <span id="product_name_msg"></span>

                    </div> 
                  </div>
                  
                  <div class="col-sm-3">
                    <div class="form-group">
                    <label for="input-1">Packet breadth</label>
                      <input type="number" class="form-control" id="price" name="breadth" placeholder="in cms" onchange="HideErr('price_msg')" >
                        <span id="price_msg"></span> 
                </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="form-group">
                      <label for="input-1">Packet height</label>
                      <input type="text" class="form-control" id="name" name="height" placeholder="in cms" placeholder="Name" onchange="HideErr('product_name_msg')">
                       <span id="product_name_msg"></span>

                    </div> 
                  </div>
                  
                  <div class="col-sm-3">
                    <div class="form-group">
                    <label for="input-1">Packet weight</label>
                      <input type="number" class="form-control" id="price" name="weight" placeholder="in kgs." onchange="HideErr('price_msg')" >
                        <span id="price_msg"></span> 
                </div>
                </div>   
                  </div>
                                    <!--</div>-->
                        </div>
                        <div class="col-md-12 mb-4">
                             <button type="submit" class="btn btn-primary pull-right" id="SaveBtn">Submit</button>
                        </div>
                        
                        <div class="col-md-12">
                  </form>
<!--</tr>-->
                  <!--<tr>-->
                    <!--<td align="left" bgcolor="#ffffff">-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">
                         <br>
        
     <!--<table style=" font-family: arial, sans-serif;border-collapse: collapse;width: 100%;">-->
  <tr>
    <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">#</th>   
    <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Item</th>
    <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Qty</th>
    <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Size</th>
    <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Unit Rs.</th>
    <th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Price</th>
    {{-- <th style="border: 1px solid #dddddd; text-align: left;  padding: 8px;">Vat(15%)</th> --}}
    <th style="border: 1px solid #dddddd;  text-align: left;  padding: 8px;">Total Price</th>
  </tr>
 
      <?php
      $sum=0;
      $i=1;
      
         $orderDetails=$orderData->billing_order_details; 
          $orderDetailsArray = json_decode($orderDetails); 
          
         
        foreach($orderDetailsArray as $item){  
        
         $productCtegoryDetails = DB::table('products')->select('category_id')->where('id','=',$item->id)->first();
         $GstOnProduct = DB::table('category')->select('gst')->where('id','=',$productCtegoryDetails->category_id)->first();
            $gstAmount = ($GstOnProduct->gst/100)*($item->price*$item->quantity);
			$ProductPriceWithGst = ($item->price*$item->quantity)+$gstAmount;
            $totalProductPriceWithGst[] =  $ProductPriceWithGst;
            $TotalGst[] =  $GstOnProduct->gst;
            
     
      ?>
<tr>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$i}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$item->name}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$item->quantity}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{@$item->size}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$item->price}}</td>
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$item->quantity*$item->price}}</td>
    {{-- <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$GstOnProduct->gst}}</td> --}}
    <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$ProductPriceWithGst}}</td>
</tr>
   <?php
  $i++;
        }
      
       
      ?>
      <tr>
        <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">SUB TOTAL:</td>
        <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderData->txn_amount}}</td>
      </tr>
   <?php
          
        if(!empty($orderData->billing_address))
        {
          
             
    ?>
           
        <tr>
            <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;">DISCOUNT({{$orderDetailsArray[0]->Discount}}%)</td>
            <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderDetailsArray[0]->discountAmount}}</td>
        </tr>
        <tr>
            <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >ORDER TOTAL:</td>
            <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderDetailsArray[0]->totalAmountForPaidAfterDiscount}}</td>
        </tr>
        <tr>
            <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >Vat(15%):</td>
            <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderData->vat_amt}}</td>
        </tr>
        <tr>
            <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >You Pay :</td>
            <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderDetailsArray[0]->totalAmountForPaidAfterDiscountAndGST}}</td>
        </tr>     
      
        <?php    
        }else
        {
            ?>
            
        <tr>
            <td  colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >DISCOUNT(0%)</td>
            <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">SAR.0</td>
        </tr>
        <tr>
            <td colspan="6" style="border: 1px solid #dddddd;text-align: left;padding: 8px;" >:</td>
            <td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">SAR.{{$sum}}</td>
            </tr>
            
            
          <?php  
        }
        ?>
 

    
    <!--</td>-->

        <!--<tr>-->
            <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;"><br>Warm regards, <br>
                <strong><a onclick="window.print()" >Saga bags</a></strong><br>
                <br>
                </td>
            <!--</tr>-->
        <!--</tr>-->
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


function showpacketdetails(node)
{    var value = $(node).val();

    if( value == 'shipping')
    {
        $('#orderlengthbreadth').css('display','block');
    }
    else
    {
            $('#orderlengthbreadth').css('display','none');
    
    }
    // var value = $(node).val();
    // alert(value);
}
</script>


@stop  