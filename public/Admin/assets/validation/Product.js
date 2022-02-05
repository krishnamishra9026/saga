$(function() { 
  $("#AddForm").validate({
    rules: {   
      name: {required: true},
      language_id: {required: true},
      price: {required: true},
      category: {required: true},
      sku_id: {required: true},
      description: {required: true}
    },    
    messages: {
      name:{required:"Please enter name."},
      price:{required:"Please enter price."},
      category:{required:"Please select category."},
      sku_id:{required:"Please enter SKU ID."},
      language_id:{required:"Please select language."},
      description:{required:"Please enter description."}
    },
    submitHandler: function(form) {
      $('#SaveBtn').prop("disabled",true);
      $('#SaveBtn').html('Loading..');
      form.submit();
    }  
  });
  

  

  $("#EditForm").validate({
    rules: {   
      name: {required: true},
      price: {required: true},
      category: {required: true},
      sku_id: {required: true},
      description: {required: true}
    },    
    messages: {
      name:{required:"Please enter name."},
      price:{required:"Please enter price."},
      category:{required:"Please select category."},
      sku_id:{required:"Please enter SKU ID."},
      description: {required: "Please enter description."}
    },
    submitHandler: function(form) {
      $('#SaveBtn').prop("disabled",true);
      $('#SaveBtn').html('Loading..');
      form.submit();
    }  
  });

  $("#name").on("keypress keyup blur",function(){
    Slug($('#name').val());
  });

  $("#slug").on("keypress keyup blur",function(){
    Slug($('#slug').val());
  });
});
$('.Number').keypress(function(event) {      
  if((event.which != 46 || $(this).val().indexOf('.') != -1) && ((event.which < 48 || event.which > 57) && (event.which != 0 && event.which != 8))) {
    event.preventDefault();
  }
  var text = $(this).val();
  if((text.indexOf('.') != -1) && (text.substring(text.indexOf('.')).length > 2) && (event.which != 0 && event.which != 8) && ($(this)[0].selectionStart >= text.length - 2)) {
    event.preventDefault();
  }
});




