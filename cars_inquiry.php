<?php

include("db.php.inc.php"); 

$pick_up_location = "";
$return_date = "";
$return_location = "";
$in_repair = false;
$damaged = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pick_up_location = $_POST['pick_up_location'] ?? "";
    $return_date = $_POST['return_date'] ?? "";
    $return_location = $_POST['return_location'] ?? "";
    $in_repair = isset($_POST['in_repair']);
    $damaged = isset($_POST['damaged']);
}
$sql = "SELECT cars.car_id, cars.type, cars.model, cars.description, cars.image1, cars.fuel_type, cars.conditions 
        FROM cars 
        LEFT JOIN rentals ON cars.car_id = rentals.car_id 
        WHERE 1=1";

if (!empty($pick_up_location)) {
    $sql .= " AND rentals.pick_up_location = :pick_up_location";
}

if (!empty($return_date)) {
    $sql .= " AND rentals.return_date = :return_date";
}

if (!empty($return_location)) {
    $sql .= " AND rentals.return_location = :return_location";
}

if ($in_repair) {
    $sql .= " AND cars.conditions = 'repair'";
}

if ($damaged) {
    $sql .= " AND cars.conditions = 'damaged'";
}

try {
    $stmt = $pdo->prepare($sql);
    
    if (!empty($pick_up_location)) {
        $stmt->bindParam(':pick_up_location', $pick_up_location);
    }
    if (!empty($return_date)) {
        $stmt->bindParam(':return_date', $return_date);
    }
    if (!empty($return_location)) {
        $stmt->bindParam(':return_location', $return_location);
    }

    $stmt->execute();
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Inquiry</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Car Rental Agency</div>
        <nav class="header-nav">
            <ul>
                <li><a href="about-us-manager.php">About Us</a></li>
                <li><a href="profileManager.php">Profile</a></li>
                <li><a href="home.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <nav class="side-nav">
            <ul>
                <li><a href="add.php">Add a Car</a></li>
                <li><a href="return_cars2.php">Return Cars</a></li>
                <li><a href="cars_inquiry.php">Cars Inquiry</a></li>
                <li><a href="add_location.php">Add a New Location</a></li>
            </ul>
        </nav>

        <main>
            <h1>Cars Inquiry</h1>

            <form method="POST">
                <label for="pickup_location">Pickup Location:</label>
                <input type="text" id="pickup_location" name="pickup_location" value="<?php echo htmlspecialchars($pick_up_location); ?>">

                <label for="return_date">Return Date:</label>
                <input type="date" id="return_date" name="return_date" value="<?php echo htmlspecialchars($return_date); ?>">

                <label for="return_location">Return Location:</label>
                <input type="text" id="return_location" name="return_location" value="<?php echo htmlspecialchars($return_location); ?>">

                <label for="in_repair">In Repair:</label>
                <input type="checkbox" id="in_repair" name="in_repair" <?php if ($in_repair) echo 'checked'; ?>>

                <label for="damaged">Damaged:</label>
                <input type="checkbox" id="damaged" name="damaged" <?php if ($damaged) echo 'checked'; ?>>

                <input type="submit" value="Search">
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Car ID</th>
                        <th>Type</th>
                        <th>Model</th>
                        <th>Description</th>
                        <th>Photo</th>
                        <th>Fuel Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
    <?php foreach ($cars as $car): ?>
        <tr>
            <td><?php echo htmlspecialchars($car['car_id']); ?></td>
            <td><?php echo htmlspecialchars($car['type']); ?></td>
            <td><?php echo htmlspecialchars($car['model']); ?></td>
            <td><?php echo htmlspecialchars($car['description']); ?></td>
            <td>
                <?php if (!empty($car['image1'])): ?>
                    <img src="<?php echo htmlspecialchars($car['image1']); ?>" alt="Car Image" style="width: 100px;">
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($car['fuel_type']); ?></td>
            <td><?php echo htmlspecialchars($car['conditions']); ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>

            </table>
        </main>
    </div>

    <footer>
        <div class="logo-small">Car Rental Agency</div>
        <p>&copy; 2024 Car Rental Agency. All rights reserved. Contact us: layanayyash7@gmail.com | +123 456 7890</p>
    </footer>
</body>
</html>
