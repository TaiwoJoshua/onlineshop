setTimeout(function(){
    $(".loader").fadeOut();
}, 1000);
  
$("#name").keyup(function(){
      $("#pname").text($(this).val());
});

$("#price").keyup(function(){
      $("#pprice").text('₦' + $(this).val());
});
  
$("#rate").keyup(function(){
      $("#prate").text($(this).val());
});
  
$("#file").change(function(){
      var fileSize = this.files[0].size;
      if(fileSize > 102400){
          $("#max").show();
          $("#format").hide();
          $("#submit").attr("disabled", true);
      }else{
          $("#max").hide();
          var oFReader = new FileReader();
          oFReader.readAsDataURL(this.files[0]);
          oFReader.onload = function (oFREvent) {
              document.getElementById("pimg").src = oFREvent.target.result;
              var fname = (this.files[0].name).toString();;
              var start = fname.length - 4;
              var end = fname.length + 1;
              var ext = fname.slice(start, end).toLowerCase();
              if(ext == "jpeg" || ext == ".jpg" || ext == ".png" || ext == "heic"){
                  $("#submit").attr("disabled", false);
                  $("#format").hide();
              }else{
                  $("#submit").attr("disabled", true);
                  $("#format").show();
              }
          };
      }
});
  
$("#flip").change(function(){
      if($("#flip").is(':checked') == true){
        setTimeout(function(){
          $("#updateproductform").css('display', 'flex');
          $("#addproductform").hide();
          $(".pagetitle").text("Update Product");
        }, 300)
      }else{
        setTimeout(function(){
          $("#addproductform").css('display', 'flex');
          $("#updateproductform").hide();
          $(".pagetitle").text("Add New Product");
        }, 300)
      }
});
  
$("#uname").keyup(function(){
      $("#upname").text($(this).val());
});
  
$("#uprice").keyup(function(){
      $("#upprice").text('₦' + $(this).val());
});
  
$("#urate").keyup(function(){
      $("#uprate").text($(this).val());
});
  
$("#ufile").change(function(){
      var fileSize = this.files[0].size;
      if(fileSize > 102400){
          $("#umax").show();
          $("#uformat").hide();
          $("#usubmit").attr("disabled", true);
      }else{
          $("#umax").hide();
          var oFReader = new FileReader();
          oFReader.readAsDataURL(this.files[0]);
          oFReader.onload = function (oFREvent) {
              document.getElementById("upimg").src = oFREvent.target.result;
              var fname = (this.files[0].name).toString();;
              var start = fname.length - 4;
              var end = fname.length + 1;
              var ext = fname.slice(start, end).toLowerCase();
              if(ext == "jpeg" || ext == ".jpg" || ext == ".png" || ext == "heic"){
                  $("#usubmit").attr("disabled", false);
                  $("#uformat").hide();
              }else{
                  $("#usubmit").attr("disabled", true);
                  $("#uformat").show();
              }
          };
      }
});