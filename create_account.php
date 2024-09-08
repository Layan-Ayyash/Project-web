<?php
session_start();
if (!isset($_SESSION['customer_info'])) {
    header("Location: customer_info.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - Step 2</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="registration-form">
        <h2>Step 2: Create E-Account</h2>
        <form method="post" action="create_account_process.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required><br><br>
            
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required><br><br>
            
            <button type="submit" name="Submit">Next</button>
        </form>
    </div>
</body>
</html>
