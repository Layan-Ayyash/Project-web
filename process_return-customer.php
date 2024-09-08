<?php
session_start();
include("db.php.inc.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rental_id = $_POST['rental_id'];
    $return_location = $_POST['return_location'];

    try {
        $stmt = $pdo->prepare("
            UPDATE rentals
            SET rental_status = 'returning', pick_up_location = :return_location
            WHERE rental_id = :rental_id
        ");
        $stmt->execute([
            'return_location' => $return_location,
            'rental_id' => $rental_id
        ]);

        header("Location: customer.php");
        exit();
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
}
?>
