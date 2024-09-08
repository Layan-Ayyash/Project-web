<?php
include("db.php.inc.php"); 


    $car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 0;
    $sql = "SELECT * FROM cars WHERE car_id = :car_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['car_id' => $car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <header>
        <div class="logo">Car Rental Agency</div>
        <nav class="header-nav">
            <ul>
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="home.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <nav class="side-nav">
            <ul>
                <li><a href="search.php">Search a Car</a></li>
                <li><a href="view_rented_cars.php">View Rents</a></li>
                <li><a href="return_car.php">Return Car</a></li>

            </ul>
        </nav>
        <main>
            <div class="car-details">
                <?php if ($car): ?>
                    <h2><?php echo htmlspecialchars($car['make']) . ' ' . htmlspecialchars($car['model']); ?></h2>
                    <img src="<?php echo htmlspecialchars($car['image1']); ?>" alt="<?php echo htmlspecialchars($car['make']); ?>">
                    <p><strong>Type:</strong> <?php echo htmlspecialchars($car['type']); ?></p>
                    <p><strong>Price Per Day:</strong> <?php echo htmlspecialchars($car['price_per_day']); ?></p>
                    <p><strong>Fuel Type:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($car['description']); ?></p>
                    <button onclick="window.location.href='rent_step1.php?car_id=<?php echo $car['car_id']; ?>'">Rent this Car</button>
                <?php else: ?>
                    <p>Car not found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
    <footer>
        <p>&copy; 2023 Car Rental Agency. All rights reserved.</p>
    </footer>
</body>
</html>
