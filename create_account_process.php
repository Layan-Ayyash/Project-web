<?php
session_start();

if (isset($_POST['Submit'])) {
    if ($_POST['password'] !== $_POST['confirm_password']) {
        echo "Passwords do not match!";
        exit();
    }

    $_SESSION['account_info'] = [
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];

    header("Location: confirm_registration.php");
    exit();
} else {
    header("Location: create_account.php");
    exit();
}
?>
