@extends('en-SA.layouts.default')
@section('content')
<?php
/*echo "<pre>";
print_r($cartCollection);
die;*/

?>
<section class="wish_list_page my_cart_page mt-4">
	<div class="container-fluid">
		<h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">@if(session('locale')=='en')  MY CART @else  عربتي    @endif</span></h2>
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-left" style="width: 170px;">@if(session('locale')=='en')  IMAGE @elseصورة   @endif</th>
                            <th class="text-left">@if(session('locale')=='en')  PRODUCT NAME @else  اسم المنتج   @endif</th>
                            <th>@if(session('locale')=='en')  PRICE @elseسعر   @endif</th>
                            <th>@if(session('locale')=='en')  ADD @else يضيف  م@endif</th>
                            <th>@if(session('locale')=='en')  Total @else المجموع  م@endif</th>
                            <th>@if(session('locale')=='en')  Remove @else يزيل    @endif</th>
                        </tr>
                    </thead>

                    <tbody class="align-middle text-center">
                        <?php
                        $i = 1; 
                        foreach($cartCollection as $item){
                        $languageId = DB::table('language')->select('id')->where('status','=','1')->where('language_slug','=',session('locale'))->first();
                        $product = DB::table('products')->where('serial_no','=',$item->attributes->serialNo)->where('status','=','1')->where('language_id','=',$languageId->id)->first();
                        /*echo "<pre>";
                        print_r($product);*/
                        //die;
                        ?>
                        <tr>
                            <td style="width: 170px;" class="align-middle text-left">
                                <img src="{{ $item->attributes->image }}" alt="" style="width: 100px;">
                            </td>
                            <td class="align-middle text-left">{{ isset($product->name) ? $product->name : '' }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $item->price }} SAR</h5><h6 class="text-muted ml-2"><del>{{ $item->attributes->OldPrice }} SAR</del></h6>
                                </div>
                            </td>

                            <form class="form" action="{{ route('cart.update') }}" method="POST">
                                {{ csrf_field() }}
                                <td class="qty qua-col first-row" data-title="Qty" style="width: 120px; padding-top: 45px;">
                                  <div class="input-group">
                                      <input class="pro-qty" type="hidden" value="{{ $item->id}}" id="id" name="id">
                                      <input class="pro-qty" type="hidden" value="{{ $item->attributes->image }}" id="img" name="img">
                                      <input type="hidden" value="0" id="slug" name="slug">
                                      <input class="pro-qty" type="hidden" value="{{ $item->price}}" id="price" name="price">
                                      <div class="button minus"><button class="btn btn-sm btn-primary btn-plus" id="quantity_moins" onclick="decreaseQty('quantity', '<?php echo $i ?>');"><i class="fa fa-minus"></i></button></div>
                                      <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center input-number" value="{{ $item->quantity }}" id="quantity_<?php echo $i ?>" name="quantity" >
                                      <div class="button plus"><button class="btn btn-sm btn-primary btn-plus" id="quantity_plus" onclick="increaseQty('quantity', '<?php echo $i ?>',<?php echo  $item->id .','. $item->quantity ?>);" ><i class="fa fa-plus"></i></button></div>
                                  </div>
                                </td>
                            </form>

                            <td class="align-middle">
                                <h5>{{ $item->price*$item->quantity }} SAR</h5>
                            </td>
                            <td class="action close-td first-row" data-title="Remove" style=" padding-top: 40px;">
                                <form class="ssgroup" action="{{ route('cart.remove') }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" value="{{ $item->id }}" id="id" name="id">
                                  <input type="hidden" value="{{ session('user_id') }}" id="useridinsession" >
                                  <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>

                <div class="text-right">
                    <a href="{{ route('Home')}}" class="btn btn-primary font-weight-bold my-3 py-3">@if(session('locale')=='en')  Continue Shopping @else  مواصلة التسوق   @endif</a>
                    @if(!session('user_id'))
                    <a href="{{route('Login')}}" class="btn btn-primary font-weight-bold my-3 py-3">@if(session('locale')=='en')  Proceed To Checkout @else باشرالخروج من الفندق   @endif</a>
                    @else
                    <a href="{{route('AuthCheck')}}" class="btn btn-primary font-weight-bold my-3 py-3">@if(session('locale')=='en')  Proceed To Checkout @else باشرالخروج من الفندق   @endif</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('javascript')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
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


$(".checkbox").change(function() {
    if(this.checked) {

var shippingCharges = $('#shipping-charges').text();
var amountWithoutDiscount = $('#final-amount').text();
var amountWithDiscount = $('#amount-after-discount').val();
var finalAmountWithoutDiscount = parseInt(shippingCharges)+parseInt(amountWithoutDiscount);
var finalAmountWithDiscount = parseInt(shippingCharges)+parseInt(amountWithDiscount);
$('#final-amount').text(finalAmountWithoutDiscount);
$('#amount-after-discount').val(finalAmountWithDiscount);

    }
    if(this.checked != true)
    {       
        var shippingCharges = $('#shipping-charges').text();
var amountWithoutDiscount = $('#final-amount').text();
var amountWithDiscount = $('#amount-after-discount').val();
var finalAmountWithoutDiscount = parseInt(amountWithoutDiscount)-parseInt(shippingCharges);
var finalAmountWithDiscount = parseInt(amountWithDiscount)-parseInt(shippingCharges);


$('#final-amount').text(finalAmountWithoutDiscount);
$('#amount-after-discount').val(finalAmountWithDiscount);

}



});




function getCoupenCode()
{
var coupen = $('#coupen-code-for-user').val();

$.ajax({


url: '{{route("CalculateCoupenPriceAccToCoupen")}}',
          method: 'post',
          headers:{
      'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
          data: {
            action:'calculate-price',
            coupen:coupen,
            totalPrice:'{{session("totalPrice")}}'
            
              
          },
          success: function (data) {  
              dataArray = JSON.parse(data);  
if(dataArray.status == 'success')
{

$('#final-amount-with-discount').css('display','none');
$('#final-amount-vfvgvvfg').css('display','block');
$('#amount-after-discount').val('₹'+dataArray.amount);

$('#hide-amount-for-save-without-discount').css('display','none');
$('#show-amount-for-save-with-discount').css('display','block');
$('#amount-for-save-with-discount').val('₹'+dataArray.saveAmount);

$('#hide-discount').css('display','none');
$('#show-discount').css('display','block');
$('#discount-amount').val(dataArray.discount+'%');

}
else
{
    
    alert("Wrong Coupen Code Applied");
    window.location.reload();
}
},
});

}

function removeItemFromCart(itemId)
{

    swal({
  title: "Are you sure?",
  text: "Once deleted, you have to add the product again",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Poof! Your product has been deleted!", {
      icon: "success",
    });


    $.ajax({


url: '/front/remove-item-from-cart',
          method: "post",
          headers:{
      'X-CSRF-TOKEN' : '{{ csrf_token() }}'
  },
          data: {
            action:'remove-item',
            item_id:itemId,
            user_id:'1'
              
          },
          success: function (data) {  
              dataArray = JSON.parse(data);  
if(dataArray.status == 'success')
{

var item_Id =  dataArray.item_id;
$('#remove-item-'+item_Id).css('display','none');


}

},



});

  } else {
    swal("Your product is safe!");
  }
});

}

function addQuantityInCart(id)
{
var quantity = $('#get-quantity-count').val();
 alert(quantity);
            $.ajax({
               url:'{{route("UpdateCart")}}',
               method:'post',
               data: {
                   _token:'{{ csrf_token() }}', 
                   id:id, 
               quantity: quantity},
               success: function (response) {
                   window.location.reload();
               }
            });


}

function reduceQuantityInCart(id)
{
    // alert(id);
var quantity = $('#get-quantity-count').val();
            $.ajax({
               url:'{{route("ReduceQuantityCart")}}',
               method:'post',
               data: {
                   _token:'{{ csrf_token() }}', 
                   id:id, 
               quantity: quantity},
               success: function (response) {
                   window.location.reload();
               }
            });


}

function removeFromCart(id)
{
            swal({
  title: "Are you sure?",
  text: "Once deleted, you have to add the product again",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Poof! Your product has been deleted!", {
      icon: "success",
    });

    $.ajax({
                    url: '{{route("RemoveFromCart")}}',
                    method: 'post',
                    data: {
                    _token:'{{ csrf_token() }}', 
                    id: id
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            
        

    } else {
    swal("Your product is safe!");
  }
});

}
     

</script>

@endsection