<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - Step 1</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="registration-form">
        <h2>Step 1: Customer Information</h2>
        <form method="post" action="customer_info_process.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required><br><br>
            
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter your address" required><br><br>
            
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required><br><br>
            
            <label for="id_number">ID Number:</label>
            <input type="text" id="id_number" name="id_number" placeholder="Enter your ID number" required><br><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required><br><br>
            
            <label for="telephone">Telephone:</label>
            <input type="tel" id="telephone" name="telephone" placeholder="Enter your telephone number" required><br><br>
            
            <label for="credit_card_number">Credit Card Number:</label>
            <input type="text" id="credit_card_number" name="credit_card_number" placeholder="Enter your credit card number" required><br><br>
            
            <label for="expiration_date_credit">Expiration Date (Credit Card):</label>
            <input type="text" id="expiration_date_credit" name="expiration_date_credit" placeholder="MM/YYYY" required><br><br>
            
            <label for="bank">Bank:</label>
            <input type="text" id="bank" name="bank" placeholder="Enter your bank name" required><br><br>
            
            <button type="submit" name="Submit">Next</button>
        </form>
    </div>
</body>
</html>
