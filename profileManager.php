<?php
session_start();

include("db.php.inc.php"); 


    $sql = "SELECT * FROM manager WHERE id = :manager_id";
    $stmt = $pdo->prepare($sql);
    $manager = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $sql = "UPDATE manager SET name = :name, address = :address, email = :email, telephone = :telephone, password = :password WHERE id = :manager_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'address' => $address,
            'email' => $email,
            'telephone' => $telephone,
            'password' => $password,
        ]);

        echo 'Profile updated successfully.';
        
        $manager['name'] = $name;
        $manager['address'] = $address;
        $manager['email'] = $email;
        $manager['telephone'] = $telephone;
        
    } catch (PDOException $e) {
        echo 'Update failed: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View/Update Profile</title>
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
        <nav class="side-nav">
            <ul>
                <li><a href="add.php">Add a Car</a></li>
                <li><a href="return_cars2.php">Return Cars</a></li>
                <li><a href="cars_inquiry.php">Cars Inquiry</a></li>
                <li><a href="add_location.php">Add a New Location</a></li>
            </ul>
        </nav>
        <main>
            <div class="profile-form">
                <h2>View/Update Profile</h2>
                <form method="post" action="">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($manager['name']) ? htmlspecialchars($manager['name']) : ''; ?>" required><br><br>
                    
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo isset($manager['address']) ? htmlspecialchars($manager['address']) : ''; ?>" required><br><br>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($manager['email']) ? htmlspecialchars($manager['email']) : ''; ?>" required><br><br>
                    
                    <label for="telephone">Telephone:</label>
                    <input type="tel" id="telephone" name="telephone" value="<?php echo isset($manager['telephone']) ? htmlspecialchars($manager['telephone']) : ''; ?>" required><br><br>
                    
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br><br>
                    
                    <button type="submit">Update Profile</button>
                </form>
            </div>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Car Rental Agency. All rights reserved.</p>
        <p>Contact us: layanayyash7@gmail.com| +123 456 7890</p>
    </footer>
</body>
</html>
