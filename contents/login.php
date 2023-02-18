<?php
  include './dbconnect.php';

  $username = $email = $empty = $mismatch = $takenemail = $takenusername = $emailpwordmismatch = $incorrectpassword = $lemail = '';

  if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    if($password != $confirmPassword){
      $mismatch = "Password Mismatched";
    }else{
      $echeck = $conn->query("SELECT * FROM `customers` WHERE `email`='$email'");
      $ucheck = $conn->query("SELECT * FROM `customers` WHERE `username`='$username'");
      if($echeck->num_rows > 0){
        $takenemail = "email already in use";
      }elseif($ucheck->num_rows > 0){
        $takenusername = "username already in use";
      }else{
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $conn->query("INSERT INTO `customers`(`username`, `email`, `password`) VALUES('$username', '$email', '$password')");
        $empty = 'empty';
      }
    }
  }

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
        $_SESSION['admin'] = 'false';
        if($_SESSION['checkout'] == 1){
          $_SESSION['checkout'] = 0;
          header("location: ./checkout.php");
        }else if($_SESSION['cart'] == 1){
          $_SESSION['cart'] = 0;
          header("location: ./cart.php");
        }else if($_SESSION['shop'] == 1){
          $_SESSION['shop'] = 0;
          header("location: ./shop.php");
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

  if(isset($_POST['asubmit'])){
    $apassword = $_POST['apassword'];
    $acheck = $conn->query("SELECT * FROM `admin`");
    if($acheck->num_rows > 0){
      while($row = $acheck->fetch_assoc()){
        $hpassword = $row['password'];
      }
      if(password_verify($apassword, $hpassword)){
        $_SESSION['admin'] = "admin";
        $empty = 'empty';
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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>

	<!--PreLoader-->
  <div class="loader">
    <div class="loader-inner">
      <div class="circle"></div>
    </div>
  </div>
  <!--PreLoader Ends-->

  <div class="container">
    <input type="checkbox" id="flip">
    <input type="checkbox" id="adminflip">
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
          <div class="login-form">
            <div class="title">Login</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-envelope"></i>
                  <input type="text" name="lemail" placeholder="E-Mail/Username here..." value="<?php if($empty == 'empty'){}else{echo $lemail;} ?>" required>
                </div>
                <div class="input-box">
                  <i class="fas fa-eye-slash" id="eye1"></i>
                  <input type="password" name="lpassword" id="pass1" placeholder="Password here..." required>
                </div>
                <p class="red"><?php if($empty == 'empty'){}else{echo $emailpwordmismatch;} ?></p>
                <div class="text"><a href="#">Forgot password?</a></div>
                <div class="button input-box">
                  <input type="submit" value=" Submit" name="lsubmit">
                </div>
                <div class="text sign-up-text">Don't have an account? <label for="flip">SignUp</label></div>
                <div class="text sign-up-text"><label for="adminflip">Admin Login</label></div>
              </div>
            </form>
          </div>
          <div class="login-form adminform">
            <div class="title">Admin Login</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-eye-slash" id="eye2"></i>
                  <input type="password" name="apassword" id="pass2" placeholder="Password here..." required>
                </div>
                <p class="red"><?php if($empty == 'empty'){}else{echo $incorrectpassword;} ?></p>
                <div class="button input-box">
                  <input type="submit" value=" Submit" name="asubmit">
                </div>
                <div class="text sign-up-text"><label for="adminflip">Customer Login</label></div>
              </div>
            </form>
          </div>
          <div class="signup-form">
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
                  <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="password" id="pass3" placeholder="Password here..." required>
                </div>
                <div class="input-box">
                  <i class="fas fa-eye-slash" id="eye4"></i>
                  <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="confirmPassword" id="pass4" placeholder="Confirm password..." required>
                  <span class="tooltip" data-tooltip="At least 6 characters, 1 upper case, 1 lowercase, 1 number and a special character">?</span>
                </div>
                <p class="red"><?php if($empty == 'empty'){}else{echo $mismatch;} ?></p>
                <div class="button input-box">
                  <input type="submit" value=" Submit" name="submit">
                </div>
                <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
  <script src="../assets/js/jquery-1.11.3.min.js"></script>
  <script src="../assets/js/login.js"></script>
  <script>
    setTimeout(function(){
      $(".loader").fadeOut();
    }, 1000);
  </script>
</body>
</html>
