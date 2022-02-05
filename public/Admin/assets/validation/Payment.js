$(function() { 
  $("#order_id").keypress(function(event) {
    if(event.which == 13){
      event.preventDefault();
      loadData(1);
    }
  });
  $("#amount").keypress(function(event) {
    if(event.which == 13){
      event.preventDefault();
      loadData(1);
    }
  });
});

function Search(){
  var page = $('#CurrentPage').val();
  loadData(page);
}
function Pagination(page){
  loadData(page);
}
function loadData(page){
  //$("#Result").html('<tr><td colspan="10"><center>Loading..</center></td></tr>');
  var order_id      = $("#order_id").val();
  var amount        = $("#amount").val();
  var user_id       = $("#user_id").val();
  var status        = $("#status").val();
  var no_of_page    = 20;
  var siteurl       = $('#url').val();
  var _token        = $('#_token').val();
  
  $.ajax(
  {
    url : siteurl+'/PaymentListing',
    type: "POST",
    data : {order_id:order_id,amount:amount,user_id:user_id,status:status,_token:_token,no_of_page:no_of_page,page:page},
    success:function(a)
    {
      $("#Result").html(a);
    }
  });
}