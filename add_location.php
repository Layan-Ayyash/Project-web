<?php
session_start();
include("db.php.inc.php"); 

$name = $property_number = $street_name = $city = $postal_code = $country = $telephone_number = "";
$name_err = $address_err = $telephone_number_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a location name.";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
    }

    if (empty(trim($_POST["property_number"])) || empty(trim($_POST["street_name"])) || empty(trim($_POST["city"])) || empty(trim($_POST["postal_code"])) || empty(trim($_POST["country"]))) {
        $address_err = "Please enter a complete address.";
    } else {
        $property_number = htmlspecialchars(trim($_POST["property_number"]));
        $street_name = htmlspecialchars(trim($_POST["street_name"]));
        $city = htmlspecialchars(trim($_POST["city"]));
        $postal_code = htmlspecialchars(trim($_POST["postal_code"]));
        $country = htmlspecialchars(trim($_POST["country"]));
    }

    if (empty(trim($_POST["telephone_number"]))) {
        $telephone_number_err = "Please enter a telephone number.";
    } elseif (!preg_match("/^[0-9]{10,}$/", trim($_POST["telephone_number"]))) {
        $telephone_number_err = "Telephone number must be at least 10 digits.";
    } else {
        $telephone_number = htmlspecialchars(trim($_POST["telephone_number"]));
    }

    if (empty($name_err) && empty($address_err) && empty($telephone_number_err)) {
        $sql = "INSERT INTO locations (name, property_number, street_name, city, postal_code, country, telephone_number) 
                VALUES (:name, :property_number, :street_name, :city, :postal_code, :country, :telephone_number)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':property_number', $property_number);
            $stmt->bindParam(':street_name', $street_name);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':postal_code', $postal_code);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':telephone_number', $telephone_number);

            if ($stmt->execute()) {
                header("Location: manager.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Location</title>
    <link rel="stylesheet" href="styles.css">
 
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
        <main>
            <h1>Add New Location</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="name">Location Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                    <span class="error"><?php echo $name_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="property_number">Property Number:</label>
                    <input type="text" id="property_number" name="property_number" value="<?php echo htmlspecialchars($property_number); ?>">
                    <span class="error"><?php echo $address_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="street_name">Street Name:</label>
                    <input type="text" id="street_name" name="street_name" value="<?php echo htmlspecialchars($street_name); ?>">
                    <span class="error"><?php echo $address_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>">
                    <span class="error"><?php echo $address_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="postal_code">Postal Code:</label>
                    <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($postal_code); ?>">
                    <span class="error"><?php echo $address_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($country); ?>">
                    <span class="error"><?php echo $address_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="telephone_number">Telephone Number:</label>
                    <input type="text" id="telephone_number" name="telephone_number" value="<?php echo htmlspecialchars($telephone_number); ?>">
                    <span class="error"><?php echo $telephone_number_err; ?></span>
                </div>
                <input type="submit" value="Add Location">
            </form>
        </main>
    </div>
    <footer>
        <div class="logo-small">Car Rental Agency</div>
        <p>&copy; 2024 Car Rental Agency. All rights reserved. Contact us: layanayyash7@gmail.com | +123 456 7890</p>
    </footer>
</body>
</html>
