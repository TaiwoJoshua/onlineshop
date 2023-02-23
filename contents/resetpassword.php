<?php
    include './dbconnect.php';

    $empty = $emailpwordmismatch = $lemail = $invalidtoken = $token = $mismatch = $oldpassword = $loginerror = $resetsuccessful = $_SESSION['resetsuccessful'] = '';

    $DateTime = date('Y-m-d H:i:s');

    //Onsubmission of Login Form
    if(isset($_POST['lsubmit'])){
        $lemail = $_POST['lemail'];
        $lpassword = $_POST['lpassword'];
        $lcheck = $conn->query("SELECT * FROM `customers` WHERE (`username`='$lemail' || `email`='$lemail')");
        if($lcheck->num_rows > 0){
        while($row = $lcheck->fetch_assoc()){
            $hpassword = $row['password'];
            $lusername = $row['username'];
        }
        if(password_verify($lpassword, $hpassword)){
            $empty = 'empty';
            $_SESSION['username'] = $lusername;
            unset($_SESSION['admin']);
            header("location: ./preloader.php");
        }else{
            $loginerror = 'error';
            $emailpwordmismatch = "email or password mismatched";
        }
        }else{
            $loginerror = 'error';
            $emailpwordmismatch = "email or password mismatched";
        }
    }

    //Onsubmission of Reset Form
    if(isset($_POST['submit'])){
        $token = $_POST['token'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $check = $conn->query("SELECT * FROM `forgotten_password` WHERE `token`='$token'");
        if($check->num_rows > 0){
            while($row = $check->fetch_assoc()){
                $username = $_SESSION['resetusername'] = $row['username'];
            }
            if($password != $confirmPassword){
                $mismatch = "Passwords Mismatched";
            }else{
                $get = $conn->query("SELECT * FROM `customers` WHERE `username`='$username'");
                if($get->num_rows > 0){
                    while($row = $check->fetch_assoc()){
                        $oldpassword = $row['password'];
                        $resetemail = $_SESSION['resetemail'] = $row['email'];
                    }
                    if(password_verify($password, $oldpassword)){
                        $mismatch = "New Password cannot be the same as Old Password";
                    }else{
                        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
                        $conn->query("UPDATE `customers` SET `password`='$password' WHERE `username`='$username'");
                        $conn->query("DELETE FROM `forgotten_password` WHERE `token`='$token'");
                        header("location: ./Mails/send_reset_password_successful.php");
                        $empty = 'empty';
                    }
                }
            }
        }else{
            $invalidtoken = "Invalid Token";
        }
    }

    //Checks the Database for Expired Tokens (Used in place of EVENTS)
    $checktime = $conn->query("SELECT * FROM `forgotten_password`");
    if($checktime->num_rows > 0){
        while($row = $checktime->fetch_assoc()){
            $requesttime = $row['time'];
            $timeusername = $row['username'];
            $timelimit = strtotime($DateTime) - 600;
            if(strtotime($requesttime) < $timelimit){
                $conn->query("DELETE FROM `forgotten_password` WHERE `username`='$timeusername' AND `time`='$requesttime'");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="shop e-commerce online buying teejay store">
    <meta property="author" content="Taiwo Joshua">
    <meta name="description" content="An e-commerce website where you can buy products">
    <meta property="og:description" content="An e-commerce website where you can buy products">
    <meta property="og:locale" content="en_UK">
    <meta property="og:image" content="https://">
    <meta property="og:title" content="Change me">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://">
    <meta name="theme-color" content="#F28123 #012738">
    <link rel="icon" href="../assets/img/logo.png">
    <link rel="apple-touch-icon" href="../assets/img/logo.png">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title class="rtitle">Reset Password</title>
   </head>
<body>
    
    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->

  <!-- logo -->
  <div class="site-logo">
    <a href="../index.php">
      <img src="../assets/img/logo.png" alt="">
    </a>
  </div>
  <!-- logo Ends -->

  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="../assets/img/frontImg.jpg" alt="">
        <div class="text">
          <span class="text-1">Every new friend is a <br> new adventure</span>
          <span class="text-2">Let's get connected</span>
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="../assets/img/backImg.jpg" alt="">
        <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
            <div class="signup-form">
                <div class="title">Reset Password</div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <div class="input-boxes">
                        <div class="input-box">
                            <i class="fas fa-key"></i>
                            <input type="text" name="token" placeholder="Enter your token" value="<?php if($empty == 'empty'){}else{echo $token;} ?>" required>
                        </div>
                        <p class="red"><?php if($empty == 'empty'){}else{echo $invalidtoken;} ?></p>
                        <div class="input-box">
                            <i class="fas fa-eye-slash" id="eye3"></i>
                            <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" maxlength="20" id="pass3" placeholder="Enter your new password" required>
                        </div>
                        <div class="input-box">
                            <i class="fas fa-eye-slash" id="eye4"></i>
                            <input type="password" name="confirmPassword" id="pass4" placeholder="Confirm new password" maxlength="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required>
                            <span class="tooltip" data-tooltip="At least 6 characters, 1 upper case, 1 lowercase, 1 number and a special character">?</span>
                        </div>
                        <p class="red"><?php if($empty == 'empty'){}else{echo $mismatch;} ?></p>
                        <div class="button input-box">
                            <input type="submit" value="submit" name="submit">
                        </div>
                        <input type="hidden" name="raccept" value="accept" />
                        <div class="text sign-up-text"><label for="flip">Login Now</label></div>
                    </div>
                </form>
            </div>

            <div class="login-form">
                <p><?php echo $_SESSION['resetsuccessful']; ?></p>
                <div class="title">Login</div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="input-boxes">
                    <div class="input-box">
                        <i class="fas fa-envelope"></i>
                        <input type="text" name="lemail" value="<?php if($empty == 'empty'){}else{echo $lemail;} ?>" placeholder="E-Mail/Username here..." required>
                    </div>
                    <div class="input-box">
                        <i class="fas fa-eye-slash" id="eye1"></i>
                        <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="lpassword" id="pass1" maxlength="20" placeholder="Password here..." required>
                    </div>
                    <p class="red"><?php if($empty == 'empty'){}else{echo $emailpwordmismatch;} ?></p>
                    <div class="button input-box">
                        <input type="submit" value="submit" name="lsubmit">
                    </div>
                    <div class="text sign-up-text"><label for="flip">Go Back</label></div>
                </div>
                </form>
            </div>
        </div>
    </div>
  </div>

  <!-- Javascript Files and Libraries -->

  <!-- jquery -->
  <script src="../assets/js/jquery-1.11.3.min.js"></script>
  
  <!-- login js -->
  <script src="../assets/js/login.js"></script>

  <script>
    //Remove Preloader
    setTimeout(function(){
      $(".loader").fadeOut();
    }, 500);

    $("#flip").change(function(){
        if($("#flip").is(':checked') == true){
        setTimeout(function(){
            $(".back").show();
            $(".front").hide();
            $(".rtitle").text("Login")
        }, 300)
        }else{
        setTimeout(function(){
            $(".front").show();
            $(".back").hide();
            $(".rtitle").text("Reset Password")
        }, 300)
        }
    });
  </script>
</body>
</html>
<?php
    if($loginerror == 'error'){
        echo '<script>$("#flip").prop("checked", true);</script>';
    }
    if(isset($_SESSION['sentstatus'])){
        if($_SESSION['sentstatus'] == "sent"){
          echo '<script>$("$("#flip").prop("checked", true);</script>';
        }
      }
?>
