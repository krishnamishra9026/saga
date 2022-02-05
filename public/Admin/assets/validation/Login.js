$(function() { 
	$("#LoginForm").validate({
    rules: {   
      password: {
        required: true,
        minlength: 5
      },
      email:{          
        required: true,             
        email: true         
      }
    },    
    messages: {
      password:{               
        required: "Please enter password.",               
        minlength: "Your password must be at least 5 characters long."            
      },
      email:{               
        required: "Please enter email address.",               
        email: "Please enter valid email address."            
      }
    },
    submitHandler: function(form) {
      var password  = $('#password').val();
      var email     = $('#email').val();
      var referer_url= $('#referer_url').val();
      var siteurl   = $('#url').val();
      var _token    = $('#_token').val();
      $('#LoginBtn').prop("disabled",true);
      $('#LoginBtn').html('Loading..');
      $.post(siteurl+"/AdminLoginValidate", {referer_url:referer_url,email:email,password:password,_token:_token}, function(data){
        var obj = $.parseJSON(data);
        $('#Login_msg').html(obj['msg']);
        $('#Login_msg').show();
        if(obj['status']=='1'){
          $('#LoginForm')[0].reset();
          location.href = obj['RefererURL'];
        }else{
          $('#LoginBtn').prop("disabled",false);
          $('#LoginBtn').html('Sign In');
        }
      });
    }  
  });
  
});