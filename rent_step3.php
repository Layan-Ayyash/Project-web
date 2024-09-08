<?php
session_start();
include("db.php.inc.php"); 

if (!isset($_SESSION['rent_data'])) {
    echo "Rent data is missing.";
    exit();
}

$rent_data = $_SESSION['rent_data'];

$credit_card_number = isset($_POST['credit_card_number']) ? $_POST['credit_card_number'] : '';
$expiration_date = isset($_POST['expiration_date']) ? $_POST['expiration_date'] : '';
$holder_name = isset($_POST['holder_name']) ? $_POST['holder_name'] : '';
$bank_issued = isset($_POST['bank_issued']) ? $_POST['bank_issued'] : '';
$credit_card_type = isset($_POST['credit_card_type']) ? $_POST['credit_card_type'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';

if (empty($credit_card_number) || empty($expiration_date) || empty($holder_name) || empty($bank_issued) || empty($credit_card_type) || empty($name) || empty($date)) {
    echo "All fields are required.";
    exit();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$car_id = isset($rent_data['car_id']) ? $rent_data['car_id'] : 'N/A';
$pick_up_date = isset($rent_data['pick_up_date']) ? $rent_data['pick_up_date'] : 'N/A';
$return_date = isset($rent_data['return_date']) ? $rent_data['return_date'] : 'N/A';
$pick_up_location = isset($rent_data['pick_up_location']) ? $rent_data['pick_up_location'] : 'N/A';
$return_location = isset($rent_data['return_location']) ? $rent_data['return_location'] : 'N/A';
$different_return_location = isset($rent_data['different_return_location']) ? $rent_data['different_return_location'] : 'N/A';
$price_per_day = isset($rent_data['price_per_day']) ? $rent_data['price_per_day'] : 0;
$total_amount = $price_per_day * (strtotime($return_date) - strtotime($pick_up_date)) / 86400;

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

    $invoice_id = generateInvoiceID();

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO rentals (customer_id, car_id, pick_up_date, return_date, pick_up_location, return_location, total_amount, credit_card_number, expiration_date, holder_name, bank_issued, credit_card_type, invoice_id)
        VALUES (:customer_id, :car_id, :pick_up_date, :return_date, :pick_up_location, :return_location, :total_amount, :credit_card_number, :expiration_date, :holder_name, :bank_issued, :credit_card_type, :invoice_id)
    ");
    $stmt->execute([
        ':customer_id' => $user_id,
        ':car_id' => $car_id,
        ':pick_up_date' => $pick_up_date,
        ':return_date' => $return_date,
        ':pick_up_location' => $pick_up_location,
        ':return_location' => $return_location,
        ':total_amount' => $total_amount,
        ':credit_card_number' => $credit_card_number,
        ':expiration_date' => $expiration_date,
        ':holder_name' => $holder_name,
        ':bank_issued' => $bank_issued,
        ':credit_card_type' => $credit_card_type,
        ':invoice_id' => $invoice_id
    ]);

    $stmt = $pdo->prepare("
        UPDATE cars
        SET status = 'returning'
        WHERE car_id = :car_id
    ");
    $stmt->execute([
        ':car_id' => $car_id
    ]);

    $pdo->commit();

    unset($_SESSION['rent_data']);

    echo "<h2>Thank you for your rental!</h2>";
    echo "<p>Your rental has been successfully processed.</p>";
    echo "<p>Car rented: " . htmlspecialchars($car['make'] . ' ' . $car['model']) . "</p>";
    echo "<p>Invoice ID: " . htmlspecialchars($invoice_id) . "</p>";

} catch (PDOException $e) {
    $pdo->rollBack();
    die("Connection failed: " . $e->getMessage());
}

function generateInvoiceID() {
    return mt_rand(1000000000, 9999999999);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car - Confirmation</title>
   
</head>
<body>
    <h1>Rent a Car - Confirmation</h1>
    <h2>Thank you for your rental!</h2>
    <p>Your rental has been successfully processed. Here are the details:</p>

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
    <p>Credit Card Number: <?php echo htmlspecialchars($credit_card_number); ?></p>
    <p>Expiration Date: <?php echo htmlspecialchars($expiration_date); ?></p>
    <p>Holder Name: <?php echo htmlspecialchars($holder_name); ?></p>
    <p>Bank Issued: <?php echo htmlspecialchars($bank_issued); ?></p>
    <p>Credit Card Type: <?php echo htmlspecialchars($credit_card_type); ?></p>

    <h3>Terms and Conditions</h3>
    <p>I accept the contract terms and conditions.</p>
    <p>Name: <?php echo htmlspecialchars($name); ?></p>
    <p>Date: <?php echo htmlspecialchars($date); ?></p>

    <p><a href="customer.php">Return to Home</a></p>
</body>
</html>
