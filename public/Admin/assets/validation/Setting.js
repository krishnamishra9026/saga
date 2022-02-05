$(function() { 
	$("#ProfileForm").validate({
    rules: {   
      first_name: {required: true},
      last_name: {required: true},
     /* mobile:{          
        required: true,             
        number: true        
      },*/
      email:{          
        required: true,             
        email: true         
      }
    },    
    messages: {
      first_name:{required:"Please enter first name."},
      last_name:{required:"Please enter last name."},
      /*mobile:{               
        required: "Please enter number of results per page.",               
        number: "Please enter valid number."            
      },*/
      email:{               
        required: "Please enter email address.",               
        email: "Please enter valid email address."            
      }
    },
    submitHandler: function(form) {
      form.submit();
    }  
  });

  $("#ChangePasswrodForm").validate({
    rules: {   
      old_password: {
            required: true,
            minlength: 5
          },
      new_password: {
            required: true,
            minlength: 5
          },
      confirm_password: {
            required: true,
            minlength: 5,
            equalTo : "#new_password"
          }
    },    
    messages: {
      old_password:{               
          required: "Please enter old password.",               
          minlength: "Your password must be at least 5 characters long."            
        },
      new_password:{               
          required: "Please enter new password.",               
          minlength: "Your password must be at least 5 characters long."            
        },
      confirm_password:{               
          required: "Please enter password.",               
          minlength: "Your password must be at least 5 characters long.",
          equalTo: " Enter Confirm Password Same as Password"
        }
    },
    submitHandler: function(form) {
      var old_password  = $('#old_password').val();
      var password      = $('#confirm_password').val();
      var siteurl       = $('#url').val();
      var _token        = $('#_token').val();
      
      $('#ChangePasswordBtn').prop("disabled",true);
      $('#ChangePasswordBtn').val('Loading..');
      $.post(siteurl+"/ChangePassword", {old_password:old_password,password:password,_token:_token}, function(data){
        var obj = $.parseJSON(data);
        $('#Profile_msg').html(obj['msg']);
        $('#Profile_msg').show();
        if(obj['status']=='1'){
          $('#ChangePasswrodForm')[0].reset();
        }
        $('#ChangePasswordBtn').prop("disabled",false);
        $('#ChangePasswordBtn').val('Save');
      });
    }  
  });
  
  $("#profile_img").change(function() {
    readURL(this);
  });

});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#ImagePreview').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

