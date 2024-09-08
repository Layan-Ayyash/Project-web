<?php
session_start();
include("db.php.inc.php"); 

try {
    $stmt = $pdo->prepare("
        SELECT r.rental_id, r.car_id, r.pick_up_date, r.return_date, r.pick_up_location, r.return_location,
               c.make AS car_make, c.model AS car_model, c.type AS car_type
        FROM rentals r
        JOIN cars c ON r.car_id = c.car_id
        WHERE r.customer_id = :customer_id
        AND r.rental_status = 'picked_up'
        ORDER BY r.pick_up_date DESC
    ");
    $stmt->bindParam(':customer_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $active_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return a Car</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Return a Car</h1>
    <table>
        <tr>
            <th>Car Reference Number</th>
            <th>Car Make</th>
            <th>Car Type</th>
            <th>Car Model</th>
            <th>Pick-up Date</th>
            <th>Return Date</th>
            <th>Return Location</th>
            <th>Action</th>
        </tr>
        <?php foreach ($active_rentals as $rental): ?>
            <tr>
                <td><?php echo htmlspecialchars($rental['rental_id']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_make']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_type']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_model']); ?></td>
                <td><?php echo htmlspecialchars($rental['pick_up_date']); ?></td>
                <td><?php echo htmlspecialchars($rental['return_date']); ?></td>
                <td><?php echo htmlspecialchars($rental['return_location']); ?></td>
                <td>
                    <form action="process_return-customer.php" method="POST">
                        <input type="hidden" name="rental_id" value="<?php echo $rental['rental_id']; ?>">
                        <input type="hidden" name="return_location" value="<?php echo $rental['return_location']; ?>">
                        <button type="submit" class="return-button">Return Car</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
