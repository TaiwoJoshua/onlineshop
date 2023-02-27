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


if(isset($_SESSION['customermail']) && $_SESSION['customermail'] == "proceed"){
    $cname = $_SESSION['cname'];
    $receiver = $_SESSION['cemail'];
    $ticket = $_SESSION['ticket'];

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
        $mail->setFrom("joshuataiwo07@gmail.com", "TeeJayStore");
        $mail->addAddress($receiver, $cname);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo("joshuataiwo07@gmail.com", "TeeJayStore");
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $cname. " Checkout";
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
                a{
                    text-decoration: none;
                    color: #051922;
                }
                a:hover{
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='pagewrapper'>
                <div class='formwrapper'>
                    <h2>TeeJay<span>Store</span></h2>
                    <h4>Hello $cname,</h4>
                    <p>You have successfully placed an order with TeeJay<span>Store</span>.</p>
                    <p>Your ticket number for this order is $ticket.</p>
                    <p>You can check back <a href='ticket.php'>here</a> to monitor the status of your order.</p>
                    <p>Thank you.</p>
                </div>
            </div>
        </body>
        </html>";
        $mail->AltBody = "$cname Checkout Form. Order placed successfully. Ticket number of order: $ticket";
        
        $mail->send();
        // echo 'Message has been sent';
        $_SESSION['checkoutstatus'] = "successful";
        header('location: ../../index.php');
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header('location: ../../index.php');
    }
}