<?php
include("db.php.inc.php"); 

$car_id = null;

if (isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];
} else {
    die("Error: car_id not provided.");
}

$sql = "SELECT cars.car_id, cars.type, cars.model, cars.description, cars.image1, cars.fuel_type, cars.conditions, rentals.pick_up_location
        FROM cars
        LEFT JOIN rentals ON cars.car_id = rentals.car_id
        WHERE cars.car_id = :car_id";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':car_id', $car_id);
    $stmt->execute();
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        die("Error: Car not found.");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $new_pick_up_location = $_POST['pick_up_location'];
    $new_conditions = $_POST['conditions'];

    $update_sql = "UPDATE cars SET conditions = :conditions WHERE car_id = :car_id";
    $update_rentals_sql = "UPDATE rentals SET pick_up_location = :pick_up_location WHERE car_id = :car_id";

    try {
        $stmt = $pdo->prepare($update_sql);
        $stmt->bindParam(':conditions', $new_conditions);
        $stmt->bindParam(':car_id', $car_id);
        $stmt->execute();

        $stmt = $pdo->prepare($update_rentals_sql);
        $stmt->bindParam(':pick_up_location', $new_pick_up_location);
        $stmt->bindParam(':car_id', $car_id);
        $stmt->execute();

        header("Location: return_cars.php");
        exit;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Layan Car Rental </div>
        <nav class="header-nav">
            <ul>
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="profileManager.php">Profile</a></li>
                <li><a href="home.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <main>
            <h1>Update Car Details</h1>
            <form method="POST">
                <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['car_id']); ?>">

                <label for="type">Type:</label>
                <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($car['type']); ?>" disabled>

                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" disabled>

                <label for="description">Description:</label>
                <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($car['description']); ?>" disabled>

                <label for="fuel_type">Fuel Type:</label>
                <input type="text" id="fuel_type" name="fuel_type" value="<?php echo htmlspecialchars($car['fuel_type']); ?>" disabled>

                <label for="pick_up_location">Pick Up Location:</label>
                <input type="text" id="pick_up_location" name="pick_up_location" value="<?php echo htmlspecialchars($car['pick_up_location']); ?>">

                <label for="conditions">Status:</label>
                <select id="conditions" name="conditions">
                    <option value="available" <?php if ($car['conditions'] == 'available') echo 'selected'; ?>>Available</option>
                    <option value="damaged" <?php if ($car['conditions'] == 'damaged') echo 'selected'; ?>>Damaged</option>
                    <option value="repair" <?php if ($car['conditions'] == 'repair') echo 'selected'; ?>>Repair</option>
                </select>

                <input type="submit" name="update" value="Update">
            </form>
        </main>
    </div>

    <footer>
        <div class="logo-small">Car Rental Agency</div>
        <p>&copy; 2024 Car Rental Agency. All rights reserved. Contact us: layanayyash7@gmail.com | +123 456 7890</p>
    </footer>
</body>
</html>
