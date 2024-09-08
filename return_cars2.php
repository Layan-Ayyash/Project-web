<?php
session_start();
include("db.php.inc.php"); 

try {
    $stmt = $pdo->prepare("
        SELECT r.rental_id, r.customer_id, r.car_id, r.pick_up_date, r.return_date, r.pick_up_location, r.return_location,
               c.make AS car_make, c.model AS car_model, c.type AS car_type,
               u.name AS customer_name
        FROM rentals r
        JOIN cars c ON r.car_id = c.car_id
        JOIN customer u ON r.customer_id = u.id
        WHERE r.rental_status = 'returning'
        ORDER BY r.pick_up_date DESC
    ");
    $stmt->execute();
    $returning_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC); 
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Return Process</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Manager Return Process</h1>
    <table>
        <tr>
            <th>Car Reference Number</th>
            <th>Car Make</th>
            <th>Car Type</th>
            <th>Car Model</th>
            <th>Pick-up Date</th>
            <th>Return Date</th>
            <th>Pick-up Location</th>
            <th>Return Location</th>
            <th>Customer Name</th>
            <th>Action</th>
        </tr>
        <?php foreach ($returning_rentals as $rental): ?>
            <tr>
                <td><?php echo htmlspecialchars($rental['rental_id']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_make']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_type']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_model']); ?></td>
                <td><?php echo htmlspecialchars($rental['pick_up_date']); ?></td>
                <td><?php echo htmlspecialchars($rental['return_date']); ?></td>
                <td><?php echo htmlspecialchars($rental['pick_up_location']); ?></td>
                <td><?php echo htmlspecialchars($rental['return_location']); ?></td>
                <td><?php echo htmlspecialchars($rental['customer_name']); ?></td>
                <td>
                    <form action="process_manager_return.php" method="POST">
                        <input type="hidden" name="rental_id" value="<?php echo $rental['rental_id']; ?>">
                        <input type="text" name="pick_up_location" value="<?php echo htmlspecialchars($rental['pick_up_location']); ?>" disabled><br><br>
                        <label for="car_status">Car Status:</label>
                        <select name="car_status">
                            <option value="available">Available</option>
                            <option value="damaged">Damaged</option>
                            <option value="repair">Repair</option>
                        </select><br><br>
                        <button type="submit" class="return-button">Complete Return</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
