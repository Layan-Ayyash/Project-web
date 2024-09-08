<?php
include("db.php.inc.php"); 

$rent_from = isset($_GET['rent_from']) ? $_GET['rent_from'] : date('Y-m-d');
$rent_to = isset($_GET['rent_to']) ? $_GET['rent_to'] : date('Y-m-d', strtotime('+3 days'));
$car_type = isset($_GET['car_type']) ? $_GET['car_type'] : 'Sedan';
$pickup_location = isset($_GET['pickup_location']) ? $_GET['pickup_location'] : 'Birzeit';
$price_min = isset($_GET['price_min']) ? $_GET['price_min'] : 200;
$price_max = isset($_GET['price_max']) ? $_GET['price_max'] : 1000;

$sql = "SELECT car_id, model, make, type, price_per_day, fuel_type, image1
        FROM cars 
        WHERE type = :car_type 
        AND price_per_day BETWEEN :price_min AND :price_max";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'car_type' => $car_type,
    'price_min' => $price_min,
    'price_max' => $price_max
]);

$checked_cars = isset($_POST['checked_cars']) ? $_POST['checked_cars'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Search</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Layan Car Rental</div>
        <nav class="header-nav">
            <ul>
                <li><a href="about-us-home.php">About Us</a></li>
                <li><a href="login1.php">Login</a></li>
                <li><a href="home.php">Home</a></li>
            </ul>
        </nav>
    </header>
  
    <main>
        <h1>Car Search</h1>
        <form method="GET" action="search.php">
            <label for="rent_from">Rent From:</label>
            <input type="date" id="rent_from" name="rent_from" value="<?php echo htmlspecialchars($rent_from); ?>">
            <label for="rent_to">Rent To:</label>
            <input type="date" id="rent_to" name="rent_to" value="<?php echo htmlspecialchars($rent_to); ?>"><br><br>

            <label for="car_type">Car Type:</label>
            <select id="car_type" name="car_type">
                <option value="Sedan" <?php echo ($car_type === 'Sedan') ? 'selected' : ''; ?>>Sedan</option>
                <option value="SUV" <?php echo ($car_type === 'SUV') ? 'selected' : ''; ?>>SUV</option>
                <option value="Van" <?php echo ($car_type === 'Van') ? 'selected' : ''; ?>>Van</option>
                <option value="Mini-Van" <?php echo ($car_type === 'Mini-Van') ? 'selected' : ''; ?>>Mini-Van</option>
                <option value="State" <?php echo ($car_type === 'State') ? 'selected' : ''; ?>>State</option>
                <option value="Seat" <?php echo ($car_type === 'Seat') ? 'selected' : ''; ?>>Seat</option>
            </select><br><br>

            <label for="pickup_location">Pick-up Location:</label>
            <input type="text" id="pickup_location" name="pickup_location" value="Birzeit" readonly><br><br>

            <label for="price_min">Price Min:</label>
            <input type="number" id="price_min" name="price_min" value="<?php echo htmlspecialchars($price_min); ?>" placeholder="200">
            <label for="price_max">Price Max:</label>
            <input type="number" id="price_max" name="price_max" value="<?php echo htmlspecialchars($price_max); ?>" placeholder="1000"><br><br>

            <button type="submit" class="btn">Search</button>
        </form>

        <form method="POST" action="">
            <table>
                <thead>
                    <tr>
                        <th><button type="submit">Show Checked</button></th>
                        <th>Price Per Day</th>
                        <th>Car Type</th>
                        <th>Fuel Type</th>
                        <th>Car Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="carTable">
                    <?php
                    while ($car = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if (!empty($checked_cars) && !in_array($car['car_id'], $checked_cars)) {
                            continue;
                        }
                        echo '<tr>';
                        echo '<td><input type="checkbox" name="checked_cars[]" value="' . $car['car_id'] . '"></td>';
                        echo '<td>' . htmlspecialchars($car['price_per_day']) . '</td>';
                        echo '<td>' . htmlspecialchars($car['type']) . '</td>';
                        echo '<td class="' . strtolower($car['fuel_type']) . '">' . htmlspecialchars($car['fuel_type']) . '</td>';
                        echo '<td class="car-images">';
                        echo '<img src="' . htmlspecialchars($car['image1']) . '" alt="' . htmlspecialchars($car['type']) . '" width="100">';
                        echo '</td>';
                        echo '<td><a href="car_details.php?car_id=' . $car['car_id'] . '" class="btn">Rent</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </main>

    <footer>
        <p>&copy; 2023 Layan Car Rental. All rights reserved.</p>
    </footer>
</body>
</html>
