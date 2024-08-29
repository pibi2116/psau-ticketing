<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAU - TICKETING MANAGEMENT SYSTEM</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="shortcut icon" href="img/logo.png" type="image/xicon"> 
</head>
<style>
body {
    /* Set the background image */
    background-image: url('img/bg-blurr.png'); /* Path to your image */
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 640px;
    position: relative;
    overflow: hidden;
}
</style>
<body>
    <h1>PSAU - Ticketing Management System</h1>
    <div class="form-container">
        <form action="login/login.php" method="post" class="first-form">
            <div class="logo">
                <img src="img/psau-logo.png" alt="Logo">
            </div>
            <h2>ENTER YOUR CREDENTIALS</h2>
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password" required> 
            <select class="form-select" aria-label="Default select example" name="userType">
                <option value="customer">Customer</option>
                <option value="staff">Staff</option>
                <option value="admin">Admin</option>
            </select>
            
            <button type="submit"><i class="fa-solid fa-right-to-bracket fa-lg"></i> Sign In</button>
            <p class="forgotpass">
                <a href="#" id="forgot-link">Forgot Password?</a>
            </p>
            <hr>
            <button type="button" id="show-third-form"><i class="fa-solid fa-user"></i> Create an Account</button>
        </form>

        <form action="" class="second-form" style="display: none;">
            <div class="logo">
                <img src="img/psau-logo.png" alt="Logo">
            </div>
            <h2>Forgot Password?</h2>
            <h4>Please go to the office and look for an admin for verification!</h4>
            <button type="button" id="back-btn-2f"><i class="fa-solid fa-arrow-left"></i> Back to Sign in</button>
        </form>

        <form action="login/register-account-customer.php" method="post" class="third-form" style="display: none;"> 
            <div class="logo">
                <img src="img/psau-logo.png" alt="Logo">
            </div>
            <h2>PERSONAL DETAILS</h2>
            <input type="text" name="full_name" placeholder="Full Name (Ex: Pedro T. Lacan)" required>
            <input type="email" name="psau_email" placeholder="PSAU Email" required>
            <input type="text" name="prefer_username" placeholder="Prefer Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="button" id="back-btn-3f"><i class="fa-solid fa-arrow-left"></i> Back to Sign in</button>
            <button type="submit" name="submit"><i class="fa-solid fa-download"></i> Submit</button>
        </form>

    </div>


    <script src="javascript/script.js"></script>
</body>
</html>
