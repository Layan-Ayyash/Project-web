<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header('Location: login4.php');
    exit();
}

$customer_id = $_SESSION['user_id'];
$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 0;

include("db.php.inc.php"); 

$sql = "SELECT * FROM cars WHERE car_id = :car_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['car_id' => $car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    die("Car not found.");
}

$pick_up_date = date('Y-m-d');
$return_date = date('Y-m-d', strtotime('+3 days'));
$pick_up_location = 'Birzeit';
$return_location = $pick_up_location;

$sql_locations = "SELECT * FROM locations";
$stmt_locations = $pdo->query($sql_locations);
$locations = $stmt_locations->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['rent_data'] = [
    'car_id' => $car_id,
    'price_per_day' => $car['price_per_day'], 
    'pick_up_date' => $pick_up_date,
    'return_date' => $return_date,
    'pick_up_location' => $pick_up_location,
    'return_location' => $return_location
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rent a Car - Step 1</title>
</head>
<body>
    <h1>Rent a Car - Step 1</h1>
    <form action="rent_step2.php" method="post">
        <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car_id); ?>">
        <p>Car: <?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></p>
        <p>Description: <?php echo htmlspecialchars($car['description']); ?></p>
        <p>Price per day: <?php echo htmlspecialchars($car['price_per_day']); ?> USD</p>
        <p>Pick Up Date: <input type="date" name="pick_up_date" value="<?php echo htmlspecialchars($pick_up_date); ?>"></p>
        <p>Return Date: <input type="date" name="return_date" value="<?php echo htmlspecialchars($return_date); ?>"></p>
        <p>Pick Up Location: <input type="text" name="pick_up_location" value="<?php echo htmlspecialchars($pick_up_location); ?>"></p>
        <p>Return Location: 
            <select name="return_location">
                <option value="Birzeit">Birzeit</option>
                <option value="Ramallah">Ramallah</option>
                <option value="Jerusalem">Jerusalem</option>
                <?php foreach ($locations as $location): ?>
                    <option value="<?php echo htmlspecialchars($location['name']); ?>"><?php echo htmlspecialchars($location['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>Special Requirements:</p>
        <p><input type="checkbox" name="baby_seat" value="10"> Baby Seat (+$10)</p>
        <p><input type="checkbox" name="insurance" value="20"> Insurance (+$20)</p>
        <p><input type="checkbox" name="different_return_location" value="30"> Return to a different location (+$30)</p>
        <p><button type="submit">Next</button></p>
    </form>
</body>
</html>
