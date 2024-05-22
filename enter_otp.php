<?php
session_start();

// Check if the user is already logged in or OTP session exists
if(isset($_SESSION['user_id']) || !isset($_SESSION['otp'])){
    // Redirect to home page or appropriate location
    header('location: home.php');
    exit();
}

// Check if the form is submitted to verify OTP
if(isset($_POST['verify_otp'])){
    // Retrieve OTP entered by the user
    $entered_otp = $_POST['otp'];
    
    // Verify entered OTP with the stored OTP
    if($entered_otp == $_SESSION['otp']){
        // Correct OTP, redirect to reset password page
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
   <title>Enter OTP</title>

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
      <h3>Enter OTP</h3>
      <input type="text" name="otp" class="box" placeholder="Enter OTP" required>
      <input type="submit" value="Verify OTP" class="btn" name="verify_otp">
   </form>
</section>

</body>
</html>
