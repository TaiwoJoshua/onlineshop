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


if(isset($_POST['submit']) && isset($_POST['acceptc']) && $_POST['acceptc'] == "acceptc"){
    $name = $_SESSION['cname'] = $_POST['cname'];
    $receiver = $_SESSION['cemail'] = $_POST['cemail'];
    $phone = $_SESSION['cphone'] = $_POST['cphone'];
    $subject = $_SESSION['csubject'] = $_POST['csubject'];
    $message = $_SESSION['cmessage'] = $_POST['cmessage'];

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
        $mail->setFrom($receiver, $name);
        $mail->addAddress('olamilekanjoshua07@gmail.com', 'TeeJayStore');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo($receiver, $name);
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "<html lang='en'>
        <head>
            <title>Contact Form</title>
            <style>
                *{
                    padding: 0;
                    margin-top: 20px;
                    box-sizing: border-box;
                    font-family: 'Open Sans', sans-serif;
                }
                .pagewrapper{
                    width: 100%;
                    padding: 10px;
                    color: #F28123;
                    background-color: white;
                }
                .formwrapper{
                    border: 1px solid #051922;
                    padding: 10px;
                    border-radius: 15px;
                }
                h2{
                    margin: 20px auto; 
                    color: #F28123; 
                    font-size: 35px;
                    text-align: center;
                }
                span{
                    color: #051922 !important;
                }
            </style>
        </head>
        <body>
            <div class='pagewrapper'>
                <div class='formwrapper'>
                    <h2>TeeJay<span>Store</span></h2>
                    <h4>Message from TeeJay Store Contact Form</h4>
                    <p>Name: <span>$name</span></p>
                    <p>E-Mail: <span>$receiver</span></p>
                    <p>Phone Number: <span>$phone</span></p>
                    <p>Message: <span>$message</span></p>
                </div>
            </div>
        </body>
        </html>";
        $mail->AltBody = "Message from TeeJayStore Contact Form. Name: $name. E-Mail: $receiver. Phone Number: $phone. Subject: $subject. Message: $message";

        $mail->send();
        // echo 'Message has been sent';
        $_SESSION['contactform'] = "successful";
        $_SESSION['cempty'] = "cempty";
        header('location: ../contact.php');
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $_SESSION['contactform'] = "failed";
        header('location: ../contact.php');
    }
}