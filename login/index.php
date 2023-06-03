<?php
include("../config.php");
if (isset($_POST["login"]))
{
    $email = $_POST["email"];
    $password = $_POST["password"];

    // connect with database
    // $conn = mysqli_connect("localhost:8889", "root", "", "user");

    // check if credentials are okay, and email is verified
    $sql = "SELECT * FROM user WHERE email = '" . $email . "' AND password = '" . $password . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0)
    {
        die("Email and/or password not found.");
    }

    $user = mysqli_fetch_object($result);

    if ($user->email_verified_at == null)
    {
        die("Please verify your email <a href='email-verification.php?email=" . $email . "'>from here</a>");
    }

    echo "<p>Your login logic here</p>";
    header('Location: ../responsive-admin-dashboard/dash.html');
}
?>
