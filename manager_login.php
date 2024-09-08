<?php
session_start();
include("db.php.inc.php"); 

if(isset($_POST['sub'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM manager WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result) {
        $_SESSION["login2.php"] = "1";
        header("Location: manager.php");
        exit();
    } else {
        $msg = "Invalid username or password";
        header("Location: manager_login.php?err=1&msg=" . urlencode($msg));
        exit();
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
                <form action="manager_login.php" method="POST">
                    <br><br>
                    Username: <input type="text" required name="username"><br><br>
                    Password: <input type="password" required name="password"><br><br>
                    <input type="submit" value="Login" name="sub">
                    <br>
                    <?php if(isset($_REQUEST["err"]) && isset($_REQUEST["msg"])): ?>
                        <p class="error-message"><?php echo htmlspecialchars($_REQUEST["msg"]); ?></p>
                    <?php endif; ?>
                </form>
            </fieldset>
        </center>
    </div>
</body>
</html>
