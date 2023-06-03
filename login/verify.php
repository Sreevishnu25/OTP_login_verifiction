<?php
 include("../config.php");
    if (isset($_POST["verify_email"]))
    {
        $email = $_POST["email"];
        $verify_token = $_POST["verification_code"];
 
        // connect with database
        // $conn = mysqli_connect("localhost:8889", "root", "", "user");
 
        // mark email as verified
        $sql = "UPDATE user SET email_verified_at = NOW() WHERE email = '" . $email . "' AND verify_token = '" . $verification_code . "'";
        $result  = mysqli_query($conn, $sql);
 
        if (mysqli_affected_rows($conn) == 0)
        {
            die("Verification code failed.");
        }
 
        echo "<p>You can login now.</p>";
        header("Location: index.html");
    }
 
?>