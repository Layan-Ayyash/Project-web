<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: customer.php");
    exit();
}

include_once("db.php.inc.php");

if (isset($_POST['sub'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM customer WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: customer.php");
            exit();
        } else {
            $msg = "Invalid username or password";
            header("Location: login4.php?err=1&msg=" . urlencode($msg));
            exit();
        }
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
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body id="body-login">
    <div class="login-page">
        <center>
            <fieldset>
                <legend>Login</legend>
                <form action="login4.php" method="POST">
                    <br><br>
                    Username: <input type="text" required name="username"><br><br>
                    Password: <input type="password" required name="password"><br><br>
                    <p>Don't have an account? <a href="customer_info.php">Create Account</a></p>
                    <input type="submit" value="Login" name="sub">
                    <br>
                    <?php if(isset($_REQUEST["err"])): ?>
                        <p class="error-message"><?php echo htmlspecialchars($_REQUEST["msg"]); ?></p>
                    <?php endif; ?>
                </form>
            </fieldset>
        </center>
    </div>
</body>
</html>
