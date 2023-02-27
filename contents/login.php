<?php
  include './dbconnect.php';

  $username = $regstatus = $email = $empty = $mismatch = $takenemail = $takenusername = $emailpwordmismatch = $incorrectpassword = $lemail = $signuperror = $msg = $sentstatus = $invalidusername = $fname = '';

  $DateTime = date('Y-m-d H:i:s');

  //Onsubmission of Registration Form
  if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $_SESSION['saccept'] = $_POST['saccept'];
    if($password != $confirmPassword){
      $mismatch = "Password Mismatched";
    }else{
      //Check whether E-Mail and Username are Available
      $echeck = $conn->query("SELECT * FROM `customers` WHERE `email`='$email'");
      $ucheck = $conn->query("SELECT * FROM `customers` WHERE `username`='$username'");
      if($echeck->num_rows > 0){
        $takenemail = "email already in use";
        $signuperror = 'error';
      }elseif($ucheck->num_rows > 0){
        $takenusername = "username already in use";
        $signuperror = 'error';
      }else{
        $signuperror = '';
        $_SESSION['receiveremail'] = $email;
        $_SESSION['receiverusername'] = $username;
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $conn->query("INSERT INTO `customers`(`username`, `email`, `password`) VALUES('$username', '$email', '$password')");
        $empty = 'empty';
        $regstatus = $_SESSION['regstatus'] = 'Registration Successful, proceed to login';
        header("location: ./Mails/send_welcome_mail.php");
      }
    }
  }

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

        $conn->query("UPDATE `customers` SET `time`='$DateTime' WHERE `username`='$lusername'");

        //If Redirection was from Checkout Page
        if(isset($_SESSION['checkout']) && $_SESSION['checkout'] == 1){
          $_SESSION['checkout'] = 0;
          header("location: ./checkout.php");

        //If Redirection was from Cart Page
        }else if(isset($_SESSION['cart']) && $_SESSION['cart'] == 1){
          $_SESSION['cart'] = 0;
          header("location: ./cart.php");

        //If Redirection was from Shop Page
        }else if(isset($_SESSION['shop']) && $_SESSION['shop'] == 1){
          $_SESSION['shop'] = 0;
          header("location: ./shop.php");
        }else if(isset($_SESSION['contact']) && $_SESSION['contact'] == "contact"){
          $_SESSION['contact'] == "false";
          header("location: ./contact.php");
        }else if(isset($_SESSION['ticketpage']) && $_SESSION['ticketpage'] == "ticket"){
          $_SESSION['ticketpage'] = "false";
          header("location: ./ticket.php");
        }else{
          header("location: ./preloader.php");
        }
      }else{
        $emailpwordmismatch = "email or password mismatched";
      }
    }else{
      $emailpwordmismatch = "email or password mismatched";
    }
  }

  //Onsubmission of Admin Login Form
  if(isset($_POST['asubmit'])){
    $apassword = $_POST['apassword'];
    $acheck = $conn->query("SELECT * FROM `admin`");
    if($acheck->num_rows > 0){
      while($row = $acheck->fetch_assoc()){
        $hpassword = $row['password'];
      }
      if(password_verify($apassword, $hpassword)){
        $_SESSION['admin'] = "admin";
        unset($_SESSION['username']);
        $empty = 'empty';
        $conn->query("UPDATE `admin` SET `time`='$DateTime' WHERE `time` !='$DateTime'");
        if($_SESSION['addproduct'] == 1){
          $_SESSION['addproduct'] = 0;
          header("location: ./addproduct.php");
        }else{
          header("location: ./preloader.php");
        }
      }else{
        $incorrectpassword = "incorrect password";
      }
    }
  }

  //Onsubmission of Forgotten Password Form
  if(isset($_POST['fsubmit'])){
    $fname = $_SESSION['fname'] = $_POST['fname'];
    $_SESSION['taccept'] = $_POST['taccept'];
    $fcheck = $conn->query("SELECT * FROM `customers` WHERE `username`='$fname'");
    if($fcheck->num_rows > 0){
      while($row = $fcheck->fetch_assoc()){
        $femail = $_SESSION['femail'] = $row['email'];
        $token = substr(md5(time()+123456789% rand(4000, 55000000)), 0, 10);
        $_SESSION['token'] = $token;
      }
      
      $check = $conn->query("SELECT * FROM `forgotten_password` WHERE `username`='$fname'");
      if($check->num_rows == 0){
        $conn->query("INSERT INTO forgotten_password VALUES(null,'$fname','$femail','$token','$DateTime')");
        $empty = "empty";
        header("location: ./Mails/send_token_mail.php");
      }else{
        $conn->query("UPDATE forgotten_password SET `token`='$token', `time`='$DateTime' WHERE `username`='$fname'");
        $empty = "empty";
        header("location: ./Mails/send_token_mail.php");
      }
    }else{
        unset($_SESSION['sentstatus']);
        $invalidusername = "Username is not Registered";
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
    <title class="ptitle">Login</title>
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
    <input type="checkbox" id="adminflip">
    <input type="checkbox" id="forgotflip">
    
    <!-- Cover Image -->
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
    <!-- Cover Image Ends -->

    <div class="forms">
        <div class="form-content">

          <!-- Login Form -->
          <div class="login-form loginform">
            <p><?php echo $regstatus; ?></p>
            <div class="title">Login</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-envelope"></i>
                  <input type="text" name="lemail" placeholder="E-Mail/Username here..." value="<?php if($empty == 'empty'){}else{echo $lemail;} ?>" required>
                </div>
                <div class="input-box">
                  <i class="fas fa-eye-slash" id="eye1"></i>
                  <input type="password" maxlength="20" name="lpassword" id="pass1" placeholder="Password here..." required>
                </div>
                <p class="red"><?php if($empty == 'empty'){}else{echo $emailpwordmismatch;} ?></p>
                <div class="text"><label style="color: #F28123;" for="forgotflip">Forgot password?</label></div>
                <div class="button input-box">
                  <input type="submit" value=" Submit" name="lsubmit">
                </div>
                <div class="text sign-up-text">Don't have an account? <label for="flip">SignUp</label></div>
                <div class="text sign-up-text"><label for="adminflip">Admin Login</label></div>
              </div>
            </form>
          </div>
          <!-- Login Form Ends -->
          
          <!-- Admin Login Form -->
          <div class="login-form adminform">
            <div class="title">Admin Login</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-eye-slash" id="eye2"></i>
                  <input type="password" maxlength="20" name="apassword" id="pass2" placeholder="Password here..." required>
                </div>
                <p class="red"><?php if($empty == 'empty'){}else{echo $incorrectpassword;} ?></p>
                <div class="button input-box">
                  <input type="submit" value=" Submit" name="asubmit">
                </div>
                <div class="text sign-up-text"><label for="adminflip">Customer Login</label></div>
              </div>
            </form>
          </div>
          <!-- Admin Login Form Ends -->

          <!-- SignUp Form -->
          <div class="signup-form signform">
            <div class="title">Signup</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-user"></i>
                  <input type="text" name="username" placeholder="Username here..." value="<?php if($empty == 'empty'){}else{echo $username;} ?>" required>
                </div>
                <p class="red"><?php if($empty == 'empty'){}else{echo $takenusername;} ?></p>
                <div class="input-box">
                  <i class="fas fa-envelope"></i>
                  <input type="email" name="email" placeholder="E-Mail here..." value="<?php if($empty == 'empty'){}else{echo $email;} ?>" required>
                </div>
                <p class="red"><?php if($empty == 'empty'){}else{echo $takenemail;} ?></p>
                <div class="input-box">
                  <i class="fas fa-eye-slash" id="eye3"></i>
                  <input type="password" maxlength="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="password" id="pass3" placeholder="Password here..." required>
                </div>
                <div class="input-box">
                  <i class="fas fa-eye-slash" id="eye4"></i>
                  <input type="password" maxlength="20" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="confirmPassword" id="pass4" placeholder="Confirm password..." required>
                  <span class="tooltip" data-tooltip="At least 6 characters, 1 upper case, 1 lowercase, 1 number and a special character">?</span>
                </div>
                <p class="red"><?php if($empty == 'empty'){}else{echo $mismatch;} ?></p>
                <input type="hidden" name="saccept" value="accept"/>
                <div class="button input-box">
                  <input type="submit" value=" Submit" name="submit">
                </div>
                <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
              </div>
            </form>
          </div>
          <!-- SignUp Form Ends -->

          <!-- Forgot Password Form -->
          <div class="signup-form forgotform">
            <div class="text"><label id="back" class="back"><i class="fas fa-chevron-left"></i> Back</label></div>
            <div class="title">Forgotten Password</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="forgot">
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-user"></i>
                  <input type="text" name="fname" placeholder="Enter your username" value="<?php if($empty == 'empty'){}else{echo $fname;} ?>" required>
                </div>
                <p class="red"><?php if($empty == 'empty'){}else{echo $invalidusername;} ?></p>
                <input type="hidden" name="taccept" value="accept" />
                <div class="button input-box">
                  <input type="submit" name="fsubmit" value="submit">
                </div>
                <div class="text sign-up-text"><label for="forgotflip">Login</label></div>
              </div>
            </form>
            <div class="messagewrapper">
              <p class="message">
                <?php echo $msg; if(isset($_SESSION['msg'])){echo $_SESSION['msg'];}?>
              </p>
              <div class="text sign-up-text"><label for="forgotflip" class="back">Login</label></div>
            </div>
          </div>
          <!-- Forgot Password Form Ends -->
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

    $(".back").click(function(){
      $("#back").hide();
      $(".messagewrapper").fadeOut();
      $("#forgot").fadeIn();
    })
  </script>
</body>
</html>
<?php
  if($signuperror == 'error'){
    echo '<script>$("#flip").prop("checked", true);</script>';
  }
  if(isset($_SESSION['sentstatus'])){
    if($_SESSION['sentstatus'] == "sent"){
      echo '<script>$("#back").show(); $(".messagewrapper").show(); $("#forgot").hide(); $("#forgotflip").prop("checked", true);</script>';
    }
  }

  if($invalidusername != ''){
    echo '<script>$("#forgotflip").prop("checked", true);</script>';
  }

  if($incorrectpassword != ''){
    echo '<script>$("#adminflip").prop("checked", true);</script>';
  }
?>
