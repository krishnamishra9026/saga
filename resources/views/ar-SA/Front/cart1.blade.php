@extends('layouts.default')
@section('content')

<section class="inner_banner" style="background: url('images/bg_3.jpg') no-repeat;background-position: center;background-size: cover;background-position: 50% 90%;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="vl-filter-text-box">
                    <h1>Cart</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="table-responsive cart-table">
                        <table>
                            <thead>

                                
                                <tr>
                                    <th>Image</th>
                                    <th class="p-name">Menu Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>X</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach($cartCollection as $item)
                                <tr>
                                    <td class="cart-pic first-row"><img src="{{ $item->attributes->image }}" alt=""></td>
                                    <td class="cart-title first-row">
                                        <h5>{{ $item->name }}</h5>
                                    </td>
                                    <td class="p-price first-row">£{{ $item->price }}</td>
                                    <!-- <td class="qua-col first-row">
                                        <div class="quantity">
                                            <div class="pro-qty"><span class="dec qtybtn">-</span>
                                                <input type="text" value="1">
                                            <span class="inc qtybtn">+</span></div>
                                        </div>
                                    </td> -->

                                    <form class="ssgroup oneeee" action="{{ route('cart.update') }}" method="POST">
                                        {{ csrf_field() }}
                                        <td class="qua-col first-row">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                <input class="pro-qty" type="hidden" value="{{ $item->id}}" id="id" name="id">
                                                <button class="dec qtybtn" id="quantity_mins" onclick="decreaseQty('quantity', '<?php echo $i ?>');">-</button>
                                                <input type="text" class="" value="{{ $item->quantity }}" id="quantity_<?php echo $i ?>" name="quantity" >
                                                <button class="inc qtybtn" id="quantity_plus" onclick="increaseQty('quantity', '<?php echo $i ?>',{{ $item->id}},{{ $item->quantity }});" >+</button>
                                            </div>
                                        </div>
                                    </td>
                                    </form>

                                    <td class="total-price first-row">£{{ $item->price*$item->quantity  }}</td>
                                    <td class="close-td first-row">
                                        <form class="ssgroup" action="{{ route('cart.remove') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                            <input type="hidden" value="{{ session('user_id') }}" id="useridinsession" >
                                            <button class="btn-sm btn btn-danger" style="margin-right: 10px;"><a >X</a></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="">
                               <span id="Return_msg">
                <?php
                if(Session::has('message')){
                  echo Session::get('message');
                }
                ?>
              </span>
                            <div class="discount-coupon">
                                <h6>Delivery Options</h6>
                                
                                 <div id="myRadioGroup">
                                <?php
                                if(!empty(session('payment_mode')) &&  session('payment_mode') == 'collection')
                                {
                                    ?>
                                  <label class="pr-2 btn btn-primary btn-md"><input type="radio" name="cars"  value="2"  /> Delivery 60 min</label>
                                <label class="pr-2 btn btn-primary btn-md"><input type="radio" name="cars" checked="checked" value="3" /> Collection 20 min</label>
                               <?php
   
                                }
                                
                                else
                                {
                                  ?>  
                                    
                                <label class="pr-2 btn btn-primary btn-md"><input type="radio" name="cars" checked="checked" value="2"  /> Delivery 60 min</label>
                                <label class="pr-2 btn btn-primary btn-md"><input type="radio" name="cars" value="3" /> Collection 20 min</label> 
                                
                                <?php  
                                }
                                
                                ?>
                                
                                
                                <h6>Discount Codes</h6>
                                <div id="Cars2" class="desc">
                                    <span id="Cars2Delivery">
                                        
                                        
                                    </span>
                                </div>
                                <div id="Cars3" class="desc" style="display: none;">
                                    
                                      <span id="Cars3Collection">
                                        
                                        
                                    </span>
                                   
                                </div>
                            </div>
                            <div class="clearfix"></div>

                                 <ul>
  <!--                                 @foreach($Discount as $DiscountList)-->
                                
 
  <!--                                <li class="subtotal"><span>{{$DiscountList->discount_title}}</span></br><span><?php echo $DiscountList->discount_description; ?></span> <span>-->
  <!--                                      <form action="{{route('ApplyDiscountCode')}}" onsubmit="return checkUserLoginBeforeDiscountCodeApplied()" class="coupon-form" method="POST">-->
  <!--                                      <input type="hidden" name="discount_code" id="discount_code" value="{{$DiscountList->discount_code}}">-->
  <!--                                      <input type="hidden" name="user_id" id="userIdBeforeDiscountApplied" value="{{session('user_id')}}">-->


  <!--                                  {{ csrf_field() }}-->
                                    
  <!--                                  <button type="submit">Accept</button>-->
  <!--                              </form>-->
                               
  <!--                                    </span></li>-->
  <!--@endforeach-->
                                   </ul>   
                                <!--<form action="{{route('ApplyDiscountCode')}}" class="coupon-form" method="POST">-->
                                <!--    {{ csrf_field() }}-->
                                <!--    <input type="text" name="discount_code" id="discount_code" placeholder="Enter your codes">-->
                                <!--    <button type="submit" class="site-btn coupon-btn">Apply</button>-->
                                <!--</form>-->
                            </div>
                        </div>
                        <div class="">
                            
                            <!--<span id="dhghdvhff"></span>-->
                            <h6>Cart Totals</h6>
                            <div class="proceed-checkout">
                                <ul>
                                    <li class="subtotal">Subtotal <span>£ {{ \Cart::getTotal() }}</span></li>
                                    <li class="subtotal">Discount({{ session()->get('Discount_coupen_code')['name']}}%) <span>£ {{ session()->get('Discount_coupen_code')['discount']}}</span></li>
                                     <?php
                                     if(session('Discount_coupen_code')['name'] != 0){
                                     ?>
                                     <form action="{{route('RemoveDiscountCode')}}" class="coupon-form"  method="POST">
                                    {{ csrf_field() }}
                                   
                                    <button type="submit">Remove</button>
                                </form>
                                <?php
                                     }
                                     
                                     
                                ?>
                                    <li class="cart-total">Total <span>£ {{ session()->get('final_amount')}}</span></li>
                                </ul>
                                
                                <?php
                                
                              
                                $itemsCount= \Cart::getContent()->count();

                               if($itemsCount == 0)
                                {
                                 ?> 
                               <a  onClick="goToCheckOut();" class="btn btn-primary mb-2 w-100  disabled "  >Proceed To Checkout</a><br>
  
                                  
<?php                                    
                                }
                                else
                                {
                                 ?>   
                                  
                                                                    <a  onClick="goToCheckOut();" class="btn btn-primary mb-2 w-100">Proceed To Checkout</a><br>

                                  <?php  
                                }
                                ?>
                                
                                 <a href="{{route('Menus')}}" class="btn btn-primary  w-100">Continue Order...</a> 
                               
                            </div>
                        </div>
                    </div>

            </div>
        </div>
        
        <!--//modal start-->
        
        <!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">-->
<!--  Launch demo modal-->
<!--</button>-->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Please add more item</h5>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
Your Price should be grater than or equal to £20    

      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
        
        
      <!--//modal end  -->
        
    </section>


@endsection
@section('javascript')

<script type="text/javascript">
$(document).ready(function() {
    $("input[name$='cars']").click(function() {
        var test = $(this).val();
        if(test == 2)
        {
            
           $.ajax({

url: '{{route('CheckOrderOption')}}',
		  method: 'post',
		  headers:{
	  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
		  data: {
			action:'delivery'
	},
		  success: function (data) {  
			  dataArray = JSON.parse(data);
			  
if(dataArray.status == 'success')
{
    $('#Cars2Delivery').html(dataArray.html);
    window.location.reload();

    
    
    // window.location.href = "{{ route('Checkout')}}";

    
}
else
{
        $('#Cars2Delivery').html(dataArray.html);
    window.location.reload();

    //  $("div.desc").hide();
    //     $("#Cars" + test).show();
    
}
},
});


}
else{
            
   
           $.ajax({

url: '{{route('CheckOrderOption')}}',
		  method: 'post',
		  headers:{
	  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
		  data: {
			action:'collection'
			  
		  },
		  success: function (data) {  
		     

			  dataArray = JSON.parse(data); 
			 
if(dataArray.status == 'success')
{
    
        $('#Cars3Collection').html(dataArray.html);
        // $('#dhghdvhff').text(dataArray.payment_mode);
    window.location.reload();

    // window.location.href = "{{ route('Checkout')}}";
     
   

}
},
});

   
            
            
}
        

        $("div.desc").hide();
        $("#Cars" + test).show();
    });
    
    
    <?php
    if(session('payment_mode') == 'collection')
    {
    ?>    
   
      
           $.ajax({

url: '{{route('CheckOrderOption')}}',
		  method: 'post',
		  headers:{
	  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
		  data: {
			action:'collection'
			  
		  },
		  success: function (data) {  
		     

			  dataArray = JSON.parse(data); 
			 
if(dataArray.status == 'success')
{
    
        $('#Cars2Delivery').html(dataArray.html);
        // $('#dhghdvhff').text(dataArray.payment_mode);

    // window.location.href = "{{ route('Checkout')}}";
     
   

}
},
});
     
     
     <?php   
    }
    else
    {
        ?>
        
                      $.ajax({

url: '{{route('CheckOrderOption')}}',
		  method: 'post',
		  headers:{
	  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
		  data: {
			action:'delivery'
	},
		  success: function (data) {  
			  dataArray = JSON.parse(data);
			  
if(dataArray.status == 'success')
{
    $('#Cars2Delivery').html(dataArray.html);

    
    // window.location.href = "{{ route('Checkout')}}";

    
}
else
{
       $('#Cars2Delivery').html(dataArray.html);

    
}
},
}); 
        
        
     <?php   
    }
    
    ?>
    
    

    
    
});

function checkUserLoginBeforeDiscountCodeApplied()
{
    var userid = $('#userIdBeforeDiscountApplied').val();
 
  if( userid == '' )
    {
    $('#loginform').modal('show');
    return false;
    }
    // alert(userid);
}

function goToCheckOut()
{

 var userid = $('#useridinsession').val();

    if( userid == '' )
    {
    $('#loginform').modal('show');
    }
   else
   {
   $.ajax({

url: '{{route('CheckPaymentOptionAndPrice')}}',
		  method: 'post',
		  headers:{
	  'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
		  data: {
			action:'checkthedeliveryandpayment',
			payment_mode:'{{session("payment_mode")}}'
	},
		  success: function (data) {  
			  dataArray = JSON.parse(data);
			  
if(dataArray.status == 'success')
{
    
     window.location.href = "{{ route('Checkout')}}";
}
else
{
    if(dataArray.data == 'delivery'){
        
          $('#exampleModalCenter').modal('show');

    }
    else
    {
           window.location.href = "{{ route('Checkout')}}";
  
        
    }
    
    //   $('#Cars2Delivery').html(dataArray.html);
 
    
}
},
});



       
       
   }
 
}

    function increaseQty(field, id,itemId,quantity) {
        
       
        var field = field +'_'+ id;
        var number = parseInt(document.getElementById(field).value);
        document.getElementById(field).value = number + 1;
        
        
        
        
    }
     
    function decreaseQty(field, id) {
        var field = field +'_'+ id;
        var number = parseInt(document.getElementById(field).value);
        if (number > 0) {
            if( (number - 1) > 0) {
                document.getElementById(field).value = number - 1;
            }
        }
        
      
    } 
    
</script>

@endsection

