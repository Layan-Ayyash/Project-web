<?php
session_start();
if (!isset($_SESSION['customer_info']) || !isset($_SESSION['account_info'])) {
    header("Location: customer_info.php");
    exit();
}

$customer_info = $_SESSION['customer_info'];
$account_info = $_SESSION['account_info'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - Step 3</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="registration-form">
        <h2>Step 3: Confirm Registration</h2>
        <form method="post" action="complete_registration.php">
            <fieldset>
                <legend>Customer Information</legend>
                <p>Name: <?php echo htmlspecialchars($customer_info['name']); ?></p>
                <p>Address: <?php echo htmlspecialchars($customer_info['address']); ?></p>
                <p>Date of Birth: <?php echo htmlspecialchars($customer_info['date_of_birth']); ?></p>
                <p>ID Number: <?php echo htmlspecialchars($customer_info['id_number']); ?></p>
                <p>Email: <?php echo htmlspecialchars($customer_info['email']); ?></p>
                <p>Telephone: <?php echo htmlspecialchars($customer_info['telephone']); ?></p>
                <p>Credit Card Number: <?php echo htmlspecialchars($customer_info['credit_card_number']); ?></p>
                <p>Expiration Date (Credit Card): <?php echo htmlspecialchars($customer_info['expiration_date_credit']); ?></p>
                <p>Bank: <?php echo htmlspecialchars($customer_info['bank']); ?></p>
            </fieldset>
            
            <fieldset>
                <legend>Account Information</legend>
                <p>Username: <?php echo htmlspecialchars($account_info['username']); ?></p>
            </fieldset>
            
            <button type="submit" name="Submit">Confirm</button>
        </form>
    </div>
</body>
</html>
