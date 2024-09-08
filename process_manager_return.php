<?php
session_start();
include("db.php.inc.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rental_id = $_POST['rental_id'];
    $pick_up_location = $_POST['pick_up_location']; 
    $car_status = $_POST['car_status'];

    try {
        $stmt = $pdo->prepare("
            UPDATE rentals
            SET return_location = :return_location, rental_status = 'returned'
            WHERE rental_id = :rental_id
        ");
        $stmt->execute([
            'return_location' => $_POST['return_location'],
            'rental_id' => $rental_id
        ]);

        $stmt = $pdo->prepare("
            SELECT car_id FROM rentals WHERE rental_id = :rental_id
        ");
        $stmt->execute(['rental_id' => $rental_id]);
        $car_id = $stmt->fetchColumn();

        $stmt = $pdo->prepare("
            UPDATE cars
            SET status = :car_status
            WHERE car_id = :car_id
        ");
        $stmt->execute([
            'car_status' => $car_status,
            'car_id' => $car_id
        ]);

        header("Location: manager.php");
        exit();
    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
}
?>
