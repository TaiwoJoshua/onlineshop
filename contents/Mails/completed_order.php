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

if(isset($_SESSION['newcomplete'])){
    $tickets = $_SESSION['newcomplete'];
    $ticket = $name = $receiver = "";
    for($i = 0; $i < count($tickets); $i++){
        $ticket = $tickets[$i];

        $get = $conn->query("SELECT * FROM `tickets` WHERE `ticket`='$ticket'");
        if($get->num_rows > 0){
            while($row = $get->fetch_assoc()){
                $name = $row['username']; 
                $receiver = $row['email'];
            }
        }

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
            $mail->Subject = 'Reset Password';
            $mail->Body    = "<html lang='en'>
            <head>
                <title>Token Request</title>
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
                    h2{
                        text-align: center;
                    }
                    a{
                        text-decoration: none;
                        color: #F28123;
                    }
                    a:hover{
                        color: #012738 !important;
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
                        <h2>TeeJay<span style='color: #012738;'>Store</span></h2>
                        <p>Hello $name,</p>
                        <p>Your order $ticket has just been completed.</p>
                        <p>Thank you for choosing TeeJay<span>Store</span>.</p>
                        <footer class='footer'>
                            <p>
                                You received this email because you are signed up with <span style='font-weight: bold;'>TeeJay<span style='color: #012738;'>Store</span></span>
                            </p>
                        </footer>
                    </div>
                </div>
            </body>
            </html>";
            $mail->AltBody = 'HTML is not Supported';

            $mail->send();
            // echo 'Message has been sent';
            header('location: ../ticket.php');
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header('location: ../ticket.php');
        }
    }
}