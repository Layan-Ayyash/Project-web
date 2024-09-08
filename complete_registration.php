<?php
session_start();
include("db.php.inc.php"); 

if (isset($_POST['Submit'])) {
    if (!isset($_SESSION['customer_info']) || !isset($_SESSION['account_info'])) {
        header("Location: customer_info.php");
        exit();
    }

    $customer_info = $_SESSION['customer_info'];
    $account_info = $_SESSION['account_info'];

    $id = rand(1000000, 9999999);  
    $name = $customer_info['name'];
    $address = $customer_info['address'];
    $date_of_birth = $customer_info['date_of_birth'];
    $email = $customer_info['email'];
    $telephone = $customer_info['telephone'];
    $credit_card_number = $customer_info['credit_card_number'];
    $expiration_date_credit = DateTime::createFromFormat('d-m-Y', $customer_info['expiration_date_credit'])->format('Y-m-d');
    $bank = $customer_info['bank'];
    $username = $account_info['username'];
    $password = $account_info['password'];

    try {
        $stmt = $pdo->prepare("INSERT INTO customer 
            (id, name, address, date_of_birth, email, telephone, credit_card_number, expiration_date_credit, bank, username, password) 
            VALUES 
            (:id, :name, :address, :date_of_birth, :email, :telephone, :credit_card_number, :expiration_date_credit, :bank, :username, :password)");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':credit_card_number', $credit_card_number);
        $stmt->bindParam(':expiration_date_credit', $expiration_date_credit);
        $stmt->bindParam(':bank', $bank);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            echo 'Data added successfully.';
            echo '<br>Your customer ID is: ' . $id;
            echo '<br><a href="login4.php">Login</a>';
            session_unset();
            session_destroy();
        } else {
            echo 'Error: Could not execute the query.';
        }
    } catch (PDOException $e) {
        echo '<font color="red">Error: ' . $e->getMessage() . '</font>';
    }
} else {
    header("Location: customer_info.php");
    exit();
}
?>
