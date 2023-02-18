$("#eye1").click(function(){
    let x = document.getElementById("pass1");
    if(x.type == "password"){
        x.type = "text";
        $("#eye1").addClass("fa-eye");
        $("#eye1").removeClass("fa-eye-slash");
    }else{
        x.type = "password";
        $("#eye1").addClass("fa-eye-slash");
        $("#eye1").removeClass("fa-eye");
    }
});
$("#eye2").click(function(){
    let x = document.getElementById("pass2");
    if(x.type == "password"){
        x.type = "text";
        $("#eye2").addClass("fa-eye");
        $("#eye2").removeClass("fa-eye-slash");
    }else{
        x.type = "password";
        $("#eye2").addClass("fa-eye-slash");
        $("#eye2").removeClass("fa-eye");
    }
});
$("#eye3").click(function(){
    let x = document.getElementById("pass3");
    if(x.type == "password"){
        x.type = "text";
        $("#eye3").addClass("fa-eye");
        $("#eye3").removeClass("fa-eye-slash");
    }else{
        x.type = "password";
        $("#eye3").addClass("fa-eye-slash");
        $("#eye3").removeClass("fa-eye");
    }
});
$("#eye4").click(function(){
    let x = document.getElementById("pass4");
    if(x.type == "password"){
        x.type = "text";
        $("#eye4").addClass("fa-eye");
        $("#eye4").removeClass("fa-eye-slash");
    }else{
        x.type = "password";
        $("#eye4").addClass("fa-eye-slash");
        $("#eye4").removeClass("fa-eye");
    }
});
$("#flip").change(function(){
    if($("#flip").is(':checked') == true){
      setTimeout(function(){
        $(".back").show();
        $(".front").hide();
      }, 300)
    }else{
      setTimeout(function(){
        $(".front").show();
        $(".back").hide();
      }, 300)
    }
});
$("#adminflip").change(function(){
    if($("#adminflip").is(':checked') == true){
      setTimeout(function(){
        $(".front>img").attr("src", "../assets/img/backImg.jpg");
      }, 500)
    }else{
      setTimeout(function(){
        $(".front>img").attr("src", "../assets/img/frontImg.jpg");
      }, 500)
    }
});