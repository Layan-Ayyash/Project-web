<?php
session_start();

if (isset($_POST['Submit'])) {
    $_SESSION['customer_info'] = [
        'name' => $_POST['name'],
        'address' => $_POST['address'],
        'date_of_birth' => $_POST['date_of_birth'],
        'id_number' => $_POST['id_number'],
        'email' => $_POST['email'],
        'telephone' => $_POST['telephone'],
        'credit_card_number' => $_POST['credit_card_number'],
        'expiration_date_credit' => $_POST['expiration_date_credit'],
        'bank' => $_POST['bank']
    ];

    header("Location: create_account.php");
    exit();
} else {
    header("Location: customer_info.php");
    exit();
}
