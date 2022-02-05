$(document).ready(function() {
  $("#FormRegister").validate({
    rules: {   
      name:'required',   
      password: {
        required: true,
        minlength: 6
      },
      password_confirm: {
          required: true,
          minlength: 6,
          equalTo: "#password"
      },
      email:{          
        required: true,             
        email: true         
      }
    },    
    messages: {
      name:'Please enter name.',
      password:{               
        required: "Please enter password.",               
        minlength: "Your password must be at least 6 characters long."            
      },
      password_confirm:{               
        required: "Please enter confirm password.",               
        minlength: "Your password and confirm password do not match."            
      },
      email:{               
        required: "Please enter email.",               
        email: "Please enter valid email."            
      }
    },
    submitHandler: function(form) {
      $('#Register_msg').hide(); 
        var siteurl   = $('#url').val();
        var FormValue = $("#FormRegister").serializeArray();
        $('#RegisterSubmitBtn').prop("disabled",true);
        $('#RegisterSubmitBtn').val('Loading..');
        $.post(siteurl+"/InsertRegisterUser", FormValue, function(data){
          var obj = $.parseJSON(data);
          if(obj['status']=='1'){
            $('#FormRegister')[0].reset();
            location.href = siteurl+"/menus";
          }
          $('#RegisterSubmitBtn').prop("disabled",false);
          $('#RegisterSubmitBtn').val('Sign Up');      
          $('#Register_msg').html(obj['msg']);
          $('#Register_msg').show();        
        });
      }  
  });

  $("#FormLogin").validate({
    rules: {   
      LoginPassword: {
        required: true,
        minlength: 6
      },
      LoginEmail:{          
        required: true,             
        email: true         
      }
    },    
    messages: {
      LoginPassword:{               
        required: "Please enter password.",               
        minlength: "Your password must be at least 6 characters long."            
      },
      LoginEmail:{               
        required: "Please enter email.",               
        email: "Please enter valid email."            
      }
    },
    submitHandler: function(form) {

      var siteurl   = $('#url').val();
      var FormValue = $("#FormLogin").serializeArray();

      $('#LoginSubmitBtn').prop("disabled",true);
      $('#LoginSubmitBtn').val('Loading..');
      $.post(siteurl+"/CheckUserLogin", FormValue, function(data){
        var obj = $.parseJSON(data);
        if(obj['status']=='1'){
          $('#FormLogin')[0].reset();
          location.href = siteurl+"/menus";
        }
        $('#LoginSubmitBtn').prop("disabled",false);
        $('#LoginSubmitBtn').val('Login');      
        $('#Login_msg').html(obj['msg']);
        $('#Login_msg').show();        
      });
    }  
  });

  $("#FormForgot").validate({
    rules: {   
      ForgotEmail:{          
        required: true,             
        email: true         
      }
    },    
    messages: {
      ForgotEmail:{               
        required: "Please enter email.",               
        email: "Please enter valid email."            
      }
    },
    submitHandler: function(form) {

      var siteurl   = $('#url').val();
      var FormValue = $("#FormForgot").serializeArray();

      $('#ForgotSubmitBtn').prop("disabled",true);
      $('#ForgotSubmitBtn').val('Loading..');
      $.post(siteurl+"/UserForgotPassword", FormValue, function(data){
        var obj = $.parseJSON(data);
        if(obj['status']=='1'){
          $('#FormForgot')[0].reset();
        }
        $('#ForgotSubmitBtn').prop("disabled",false);
        $('#ForgotSubmitBtn').val('Login');      
        $('#Login_msg').html(obj['msg']);
        $('#Login_msg').show();        
      });
    }  
  });

  $(".EnterNumber").on("keypress keyup blur",function (event) {
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
  });

  $('#mobile').on("change",function(event){
    var mobile = $('#mobile').val();
  });

});
function LostPassword(){
  $('#FormLogin').hide();
  $('#FormForgot').show();
  $('#LoginText').html('Forgot Passwrod');
}

function Login(){
  $('#FormForgot').hide();
  $('#FormLogin').show();
  $('#LoginText').html('Login');
}