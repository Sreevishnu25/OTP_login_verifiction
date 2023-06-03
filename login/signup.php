<?php
session_start();

include("../config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

function sendemail_verify($name,$email,$verify_token){
    $mail = new PHPMailer(true);

    //$mail->SMTPDebug = 2;
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->isSMTP();  
    $mail->SMTPAuth   = true;  

    $mail->Host       = 'smtp.gmail.com';
    $mail->Username   = 'kelvindoggy69@gmail.com';                     
    $mail->Password   = 'qafbenvakllstlub';

    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;

    $mail->setFrom('kelvindoggy69@gmail.com', $name);
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Email verification from Khashif";

    $email_template = "
    <h2>You have registered with Khashif</h2>
    <h5>Verify your mail ID by using the link given below.</h5>
    <br/><br/>
    <p>".$verify_token."</p>
    ";

    $mail->Body = $email_template;
    $mail->send();
    echo 'Message has been sent';
}

if(isset($_POST['register_btn'])){
    $name = $_POST['name'];
    // echo $name;
    $email = $_POST['email'];
    // echo $email;
    $password = $_POST['password'];
    // echo $password;
    $digits = 4;
    $verify_token = rand(pow(10, $digits-1), pow(10, $digits)-1);
    
    //Email exists or not
    $check_email_query = "SELECT email FROM user WHERE email = '$email' LIMIT 1";
    $check_email_query_run = mysqli_query($conn, $check_email_query);

    if(mysqli_num_rows($check_email_query_run)>0){
        $_SESSION['status'] = "Email ID already Exists";
        echo 1;

    }
    else{
        //Insert user data
        
        $query = "INSERT INTO user(name,email,password,verification_code,email_verified_at) VALUES('$name','$email','$password','$verify_token','2023/04/11')";
        $query_run = mysqli_query($conn, $query);
        if($query){
            echo 123;
        }

        if($query_run){
            sendemail_verify($name,$email,$verify_token);
            $_SESSION['status'] = "Registration sucessfull....Please verify your email address";
            header("Location: verify.html?email=".$email);
            echo 2;
        }

        else{
            $_SESSION['status'] = "Registration failed...";
            echo 3;
        }
    }

}else{
    echo 0;
}
