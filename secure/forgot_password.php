<?php

include("header.php");
include("func.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="style2.css">


    
  </head>
  <style type="text/css">
    #inputbtn:hover{cursor:pointer;}
    .card{
    background: #f8f9fa;
    border-top-left-radius: 5% 5%;
    border-bottom-left-radius: 5% 5%;
    border-top-right-radius: 5% 5%;
    border-bottom-right-radius: 5% 5%;
}

  </style>
  <body style="background: -webkit-linear-gradient(left, #3931af, #00c6ff); background-size: cover;">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav" >
    <div class="container">

      <a class="navbar-brand js-scroll-trigger" href="index.php" style="margin-top: 10px;margin-left:-65px;font-family: 'IBM Plex Sans', sans-serif;"><h4><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp GLOBAL HOSPITALS</h4></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item" style="margin-right: 40px;">
            <a class="nav-link js-scroll-trigger" href="index.php" style="color: white;font-family: 'IBM Plex Sans', sans-serif;"><h6>HOME</h6></a>
          </li>
  
          <li class="nav-item" style="margin-right: 40px;">
            <a class="nav-link js-scroll-trigger" href="services.html" style="color: white;font-family: 'IBM Plex Sans', sans-serif;"><h6>ABOUT US</h6></a>
          </li>

          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="contact.html" style="color: white;font-family: 'IBM Plex Sans', sans-serif;"><h6>CONTACT</h6></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<div class="container-fluid" style="margin-top:60px;margin-bottom:60px;color:#34495E;">
      <div class="row">

        

         <div class="col-md-7" style="padding-left: 180px; ">
                 <div style="-webkit-animation: mover 2s infinite alternate;
    animation: mover 1s infinite alternate;">
          <img src="images/ambulance1.png" alt="" style="width: 20%;padding-left: 40px;margin-top: 150px;margin-left: 45px;margin-bottom:15px">
      </div>

      <div style="color: white;">
            <h4 style="font-family: 'IBM Plex Sans', sans-serif;"> We are here for you!</h4>
          </div>

         </div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the form submission
    $email = $_POST['email'];

    // Validate the email address (you can add more validation if needed)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }

    // Generate a random password reset token
    $token = bin2hex(random_bytes(32));

    // TODO: Implement code to save the token and email in the database for the user

    // Placeholder code to save the token and email in the database
    $dbhost = 'localhost'; // replace with your database host
    $dbuser = 'root'; // replace with your database username
    $dbpass = ''; // replace with your database password
    $dbname = 'myhmsdb'; // replace with your database name
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    

    // check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the SQL statement to insert the token and email into the database
    $sql = "CREATE TABLE password_reset";
    $sql = "INSERT INTO password_reset (email, token) VALUES ('$email', '$token')";
    if (mysqli_query($conn, $sql)) {
        echo "Password reset token saved in the database.";
    } else {
        echo "Error saving password reset token: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);

    // Send the password reset email to the user
    $reset_link = "http://127.0.0.1/hos/reset_password.php?token=$token"; // Replace with your actual reset password link
    $subject = "Password Reset";
    $message = "Hello,\n\nPlease click on the following link to reset your password:\n\n$reset_link";
    $headers = "From: Your Website <noreply@example.com>";

    if (mail($email, $subject, $message, $headers)) {
        echo "Password reset email sent. Please check your email.";
    } else {
        echo "Failed to send the password reset email. Please try again.";
    }
}
?>
<form class="form-group" method="POST" action="">
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8 offset-md-3">
                <h3 class="text-center">Forgot Password</h3>
                <div class="row mt-4">
                    <div class="col-md-8"><label>Email-ID:</label></div>
                    <div class="col-md-12"><input type="text" name="email" class="form-control" placeholder="Enter email ID" required/></div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

