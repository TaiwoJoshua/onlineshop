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


if(isset($_POST['checkout']) && isset($_POST['accept']) && $_POST['accept'] == "accept"){
    $address = $message = "";
    $username = $_SESSION['username'];
    $cname = $_SESSION['cname'] = $_POST['cname'];
    $receiver = $_SESSION['cemail'] = $_POST['cemail'];
    $phone = $_POST['cphone'];
    $address = $_POST['caddress'];
    $message = $_POST['cmessage'];
    $name = $price = $quantity = $total = array();
    $DateTime = date('Y-m-d H:i:s');
    $ticket = "";

    //Gets the User's Products from Cart
    $get = $conn->query("SELECT * FROM `$username`");
    if($get->num_rows > 0){
        $i = 0;
        while($row = $get->fetch_assoc()){
            $name[$i] = $row['name'];
            $price[$i] = $row['price'];
            $quantity[$i] = $row['quantity'];
            $total[$i] = $row['total'];
            $i++;
        }

        $ticket = $_SESSION['ticket'] = date('Ym').rand(1000, 9999);
        $checkticket = $conn->query("SELECT * FROM `tickets` WHERE `ticket` = $ticket");
        while($checkticket->num_rows > 0){
            $ticket = $_SESSION['ticket'] = date('Ym').rand(1000, 9999);
            $newcheckticket = $conn->query("SELECT * FROM `tickets` WHERE `ticket` = $ticket");
            if($newcheckticket->num_rows > 0){

            }else{
                break;
            }
        }
        echo $ticket;
        
        $aname = implode(",", $name);
        $aprice = implode(",", $price);
        $aquantity = implode(",", $quantity);
        $conn->query("INSERT INTO `tickets`(`username`, `email`, `ticket`, `products`, `quantity`, `price`, `time`) VALUES('$username', '$receiver', $ticket, '$aname', '$aquantity', '$aprice', '$DateTime')");
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
        $mail->setFrom($receiver, $cname);
        $mail->addAddress('olamilekanjoshua07@gmail.com', 'TeeJayStore');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo($receiver, $cname);
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
            </style>
        </head>
        <body>
            <div class='pagewrapper'>
                <div class='formwrapper'>
                    <h2>TeeJay<span>Store</span></h2>
                    <h4>$cname Checkout</h4>
                    <p>Name: <span>$cname</span></p>
                    <p>E-Mail: <span>$receiver</span></p>
                    <p>Phone Number: <span>$phone</span></p>
                    <p>Address: <span>$address</span></p>
                    <p>Message: <span>$message</span></p>
                    <p>Ticket: <span>$ticket</span></p>
                </div>
            </div>
        </body>
        </html>";
        $mail->AltBody = "$cname Checkout Form. Name: $cname. E-Mail: $receiver. Phone Number: $phone. Message: $message. Ticket: $ticket";
        
        $mail->send();
        // echo 'Message has been sent';
        $_SESSION['customermail'] = "proceed";
        header('location: ./customer_checkout_mail.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header('location: ./customer_checkout_mail.php');
    }
}