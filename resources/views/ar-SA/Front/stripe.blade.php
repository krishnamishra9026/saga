<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h2>Pay </h2>
                <br>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 form-group"> 
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif 
        </div> 
    </div>
    
    {{--<div class="row">
        <div class="col-lg-12 form-group"> 
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div> 
    </div>--}}
    
     
    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             {{ session()->get('error') }}
        </div>
    @endif

    
    <div class="row">
        <div class="col-lg-12 form-group"> 
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
    </div>


    <div class="row">
        <div class="col-lg-3">
<!-- pk_test_iS5sLGz5CONWxJ8KHhBzHHvD -->
        </div>
        <div class="col-lg-6">
            <form  action="{{url('stripeRequestHandler')}}" onsubmit="return checkValidation();"  data-cc-on-file="false" data-stripe-publishable-key="pk_live_51Hzhv3EaUCnohzalgoKAmAkImmuqA2qIpJnmAzkxsMO8PHqk5jzx1ssrE7hPGVr0JKwX33SkeJJAre2FYhFGmiv400rCOclfNS" name="frmStripe" id="frmstripe" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label>Name on Card</label>
                        <input class="form-control" name="card_name" id="card_name" size="4" type="text">
                                                <span id="card_name_msg"></span>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label>Card Number</label>
                        <input autocomplete="off" class="form-control" id="card_no" size="20" type="text" name="card_no">
                                                <span id="card_no_msg"></span>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 form-group">
                        <label>CVC</label>
                        <input autocomplete="off" class="form-control" placeholder="ex. 311" size="3" type="text" id="cvv" name="cvv">
                                                                        <span id="cvv_msg"></span>

                    </div>
                    <div class="col-lg-4 form-group">
                        <label>Expiration</label>
                        <input class="form-control" placeholder="MM" size="2" type="text" id="expiry_month" name="expiry_month">
                                                                        <span id="expiry_month_msg"></span>

                    </div>
                    <div class="col-lg-4 form-group">
                        <label> </label>
                        <input class="form-control" placeholder="YYYY" size="4" type="text" id="expiry_year" name="expiry_year">
                                                                        <span id="expiry_year_msg"></span>

                    </div>
                </div>
                <?php 
                    $items = 0;
                    $quantity = 0;
                    $price = 0;
                    foreach($cartCollection as $item){

                        $items = $item->id;
                        $quantity = $item->quantity;
                        $price += $item->price;
                    }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-control total btn btn-primary">
                            <input type="hidden" name="amount" value="{{ $price }}">
                            <input type="hidden" name="quantity" value="{{ $quantity }}">
                            <input type="hidden" name="totalprice" value="{{ session()->get('final_amount')}}">

                            Total: <span class="amount">£{{ session()->get('final_amount')}} </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 form-group">
                        <button class="form-control btn btn-success submit-button" type="submit" name="submit" value="" style="margin-top: 10px;">Pay »</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

<script>

function checkValidation()
{
    var card_name = $('#card_name').val();
    var card_no = $('#card_no').val();
    var cvv = $('#cvv').val();
    var expiry_month = $('#expiry_month').val();
    var expiry_year = $('#expiry_year').val();

    if(card_name == '')
    {
         $('#card_name_msg').text("Enter card name").css('color','red'); 
      return false;

    }
     if(card_no == '')
    {
         $('#card_no_msg').text("Enter card no").css('color','red');
             return false;

  } 
  if(cvv == '')
    {
         $('#cvv_msg').text("Enter cvv").css('color','red'); 
             return false;

  
    } 
    if(expiry_month == '')
    {
         $('#expiry_month_msg').text("Enter Expiry Month").css('color','red'); 
             return false;

  
    }
    if(expiry_year == '')
    {
         $('#expiry_year_msg').text("Enter Expiry Year").css('color','red'); 
             return false;

  
    }


}
    
</script>
