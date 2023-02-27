<?php
include '../dbconnect.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if(isset($_SESSION['saccept']) && $_SESSION['saccept'] == "accept"){
    $receiver = $_SESSION['receiveremail'];
    $name = $_SESSION['receiverusername'];
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'joshuataiwo07@gmail.com';                     //SMTP username
        $mail->Password   = 'pyuuuomgjklxjsqb';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('joshuataiwo07@gmail.com', 'TeeJay Store');
        $mail->addAddress($receiver, $name);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Welcome to TeeJay Store';
        // $mail->msgHTML(file_get_contents('welcome_mail.php'), __DIR__);
        $mail->Body    = "<!DOCTYPE html>
        <html lang='en'>
            <head>
                <title>Registering...</title>
                <style>
                    body{
                        font-family: 'Open Sans', sans-serif;
                    }
                    .pagewrapper{
                        width: 100%;
                        padding: 10px;
                        color: #F28123;
                        background-color: white;
                        box-sizing: border-box;
                    }
                    h3{
                        margin: 10px auto;
                        text-align: center;
                    }
                    h2{
                        margin: 20px auto; 
                        color: #F28123; 
                        font-size: 35px;
                        text-align: center;
                    }
                    a{
                        text-decoration: none;
                        color: #F28123;
                    }
                    a:hover{
                        color: #051922 !important;
                    }
                    .login{
                        font-size: 15px; 
                        font-weight: bold; 
                        color: white;
                        padding: 10px 20px; 
                        background-color: #F28123; 
                        border: 2px solid #F28123;
                        box-sizing: border-box;
                        border-radius: 30px;
                    }
                    .login:hover{
                        background-color: #333;
                        color: #F28123 !important;
                    }
                    footer{
                        width: 100%;
                        background-color: #FAF3E0;
                        padding: 15px;
                        box-sizing: border-box;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='pagewrapper'>
                    <div class='formwrapper'>
                        <h3>Welcome to</h3>
                        <h2>TeeJay<span style='color: #051922;'>Store</span></h2>
                        <h4>Hello $name,</h4>
                        <p>Thank you for joining <span style='font-weight: bold;'>TeeJay<span style='color: #051922;'>Store</span></span>. We are really excited to have you as one of our valued customers.</p>
                        <h4>What is TeeJay<span style='color: #051922;'>Store</span>?</h4>
                        <p>TeeJay<span style='color: #051922;'>Store</span> is a store where you can buy your desired products.</p>
                        <p>Want to know more about TeeJay<span style='color: #051922;'>Store</span>, <a href='https://pictures-Store.000webhostapp.com/contents/about-us.php' style='color: #F28123;'>click me.</a></p><br>
                        <center><a href='https://pictures-Store.000webhostapp.com/contents/imageStore.php' class='login' style='color: white;'>LOGIN TO YOUR ACCOUNT</a></center><br>
                        <h4>Have a question?</h4>
                        <p>You can always contact us via our <a href='mailto:joshuataiwo07@gmail.com' style='color: #F28123;'>email</a> and we would get back to you within 24hrs. We are always happy to help you.</p>
                        <hr>
                        <footer class='footer'>
                            <p>
                                You received this email because you have signed up with <span style='font-weight: bold;'>TeeJay<span style='color: #051922;'>Store</span></span>
                            </p>
                        </footer>
                    </div>
                </div>
            </body>
            </html>";
        $mail->AltBody = 'Welcome to TeeJay Store';

        $mail->send();
        // echo 'Message has been sent';
        header('location: ../login.php');
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header('location: ../login.php');
    }
}