<?php
// forgot_password.php

// Include necessary files and initialize session if needed
@include 'config.php';
session_start();

// Function to generate 5-digit OTP
function generateOTP() {
    return rand(10000, 99999);
}

// Check if the form is submitted to send OTP
if(isset($_POST['send_otp'])){
    // Retrieve the user's email address from the form
    $email = $_POST['email'];
    
    // Generate OTP
    $otp = generateOTP();
    
    // Store OTP and email address in session
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    
    // Compose email content
    $subject = 'Password Reset OTP';
    $message = 'Your OTP for password reset is: ' . $otp;
    
    // Send email
    // Replace 'your_email@example.com' with your email address
    mail($email, $subject, $message);
    
    // Redirect to enter OTP page
    header('location: enter_otp.php');
    exit();
}

// Check if the form is submitted to verify OTP and reset password
if(isset($_POST['verify_otp'])){
    // Retrieve OTP entered by the user
    $entered_otp = $_POST['otp'];
    
    // Verify entered OTP with the stored OTP
    if(isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']){
        // Correct OTP, allow password reset
        // Redirect to password reset page
        header('location: reset_password.php');
        exit();
    } else {
        // Incorrect OTP, display error message
        $error_message = "Incorrect OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forgot Password</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body>

<?php
// Display error message if OTP verification fails
if(isset($error_message)){
   echo '<div class="message"><span>'.$error_message.'</span></div>';
}
?>

<section class="form-container">
   <form action="" method="POST">
      <h3>Forgot Password</h3>
      <input type="email" name="email" class="box" placeholder="Enter your email" required>
      <input type="submit" value="Send OTP" class="btn" name="send_otp">
   </form>
</section>

</body>
</html>
 