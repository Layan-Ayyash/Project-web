<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
 include("db.php.inc.php"); 
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM customer WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$customer) {
        echo 'Customer not found.';
        exit();
    }


 if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $credit_card_number = $_POST['credit_card_number'];
    $expiration_date_credit = $_POST['expiration_date_credit'];
    $bank = $_POST['bank'];

    try {
        $sql = "UPDATE customer SET name = :name, address = :address, date_of_birth = :date_of_birth, email = :email, telephone = :telephone, credit_card_number = :credit_card_number, expiration_date_credit = :expiration_date_credit, bank = :bank WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'address' => $address,
            'date_of_birth' => $date_of_birth,
            'email' => $email,
            'telephone' => $telephone,
            'credit_card_number' => $credit_card_number,
            'expiration_date_credit' => $expiration_date_credit,
            'bank' => $bank,
            'user_id' => $user_id
        ]);

        echo 'Profile updated successfully.';
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
        <div class="logo"> Layan Car Rental </div>
        <nav class="header-nav">
            <ul>
            <li><a href="about-us.php">About Us</a></li>
            <li><a href="profile.php">Profile</a></li>
                <li><a href="home.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <nav class="side-nav">
            <ul>
                <li><a href="search.php">Search a Car</a></li>
                <li><a href="view_rents.php">View Rents</a></li>
                <li><a href="return_car.php">Return Car</a></li>
            </ul>
        </nav>
        <main>
            <div class="profile-form">
                <h2>View/Update Profile</h2>
                <form method="post" action="">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required><br><br>
                    
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>" required><br><br>
                    
                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($customer['date_of_birth']); ?>" required><br><br>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required><br><br>
                    
                    <label for="telephone">Telephone:</label>
                    <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($customer['telephone']); ?>" required><br><br>
                    
                    <label for="credit_card_number">Credit Card Number:</label>
                    <input type="text" id="credit_card_number" name="credit_card_number" value="<?php echo htmlspecialchars($customer['credit_card_number']); ?>" required><br><br>
                    
                    <label for="expiration_date_credit">Expiration Date (Credit Card):</label>
                    <input type="text" id="expiration_date_credit" name="expiration_date_credit" value="<?php echo htmlspecialchars($customer['expiration_date_credit']); ?>" required><br><br>
                    
                    <label for="bank">Bank:</label>
                    <input type="text" id="bank" name="bank" value="<?php echo htmlspecialchars($customer['bank']); ?>" required><br><br>
                    
                    <button type="submit">Update Profile</button>
                </form>
            </div>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Car Rental Agency. All rights reserved.</p>
        <p>Contact us: layanayyash7@gmail.com | +123 456 7890</p>
    </footer>
</body>
</html>
