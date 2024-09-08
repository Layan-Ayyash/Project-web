<?php
session_start();
include("db.php.inc.php"); 

if (!isset($_SESSION['rent_data'])) {
    echo "Rent data is missing.";
    exit();
}

$rent_data = $_SESSION['rent_data'];

$car_id = isset($rent_data['car_id']) ? $rent_data['car_id'] : 'N/A';
$pick_up_date = isset($rent_data['pick_up_date']) ? $rent_data['pick_up_date'] : 'N/A';
$return_date = isset($rent_data['return_date']) ? $rent_data['return_date'] : 'N/A';
$pick_up_location = isset($rent_data['pick_up_location']) ? $rent_data['pick_up_location'] : 'N/A';
$return_location = isset($rent_data['return_location']) ? $rent_data['return_location'] : 'N/A';
$different_return_location = isset($rent_data['different_return_location']) ? $rent_data['different_return_location'] : 'N/A';
$price_per_day = isset($rent_data['price_per_day']) ? $rent_data['price_per_day'] : 0;
$total_amount = $price_per_day * (strtotime($return_date) - strtotime($pick_up_date)) / 86400;

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

try {
    $stmt = $pdo->prepare("SELECT * FROM customer WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        echo "Customer not found.";
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM cars WHERE car_id = :id");
    $stmt->bindParam(':id', $car_id);
    $stmt->execute();
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        echo "Car not found.";
        exit();
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car - Step 2</title>
    
</head>
<body>
    <h1>Rent a Car - Step 2</h1>
    <h2>Invoice</h2>
    <p>Invoice Date: <?php echo date('Y-m-d'); ?></p>

    <h3>Customer Details</h3>
    <p>Customer ID: <?php echo htmlspecialchars($customer['id']); ?></p>
    <p>Name: <?php echo htmlspecialchars($customer['name']); ?></p>
    <p>Address: <?php echo htmlspecialchars($customer['address']); ?></p>
    <p>Telephone: <?php echo htmlspecialchars($customer['telephone']); ?></p>

    <h3>Rental Details</h3>
    <p>Car: <?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></p>
    <p>Type: <?php echo htmlspecialchars($car['type']); ?></p>
    <p>Fuel Type: <?php echo htmlspecialchars($car['fuel_type']); ?></p>
    <p>Pick Up Date: <?php echo htmlspecialchars($pick_up_date); ?></p>
    <p>Return Date: <?php echo htmlspecialchars($return_date); ?></p>
    <p>Pick Up Location: <?php echo htmlspecialchars($pick_up_location); ?></p>
    <p>Return Location: <?php echo htmlspecialchars($return_location); ?></p>
    <p>Total Amount: <?php echo htmlspecialchars($total_amount); ?> USD</p>

    <h3>Payment Information</h3>
    <form action="rent_step3.php" method="POST">
        <p>Credit Card Number: <input type="text" name="credit_card_number" required></p>
        <p>Expiration Date: <input type="text" name="expiration_date" required></p>
        <p> Name: <input type="text" name="holder_name" required></p>
        <p>Bank Issued: <input type="text" name="bank_issued" required></p>
        <p>Credit Card Type: 
            <select name="credit_card_type" required>
                <option value="Visa">Visa</option>
                <option value="MasterCard">MasterCard</option>
            </select>
        </p>
        <p>
            <input type="checkbox" name="accept_terms" required> I accept the contract terms and conditions
        </p>
        <p>Name: <input type="text" name="name" required></p>
        <p>Date: <input type="date" name="date" required></p>
        <p><input type="submit" value="Confirm Rent"></p>
    </form>
</body>
</html>
