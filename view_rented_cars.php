<?php
session_start();
include("db.php.inc.php"); 

try {
    $stmt = $pdo->prepare("
        SELECT r.rental_id, r.customer_id, r.car_id, r.pick_up_date, r.return_date, r.pick_up_location, r.return_location,
               r.total_amount, r.credit_card_number, r.expiration_date, r.holder_name, r.bank_issued, r.credit_card_type,
               c.model AS car_model, c.make AS car_make, c.type AS car_type, c.fuel_type AS car_fuel_type,
               c.price_per_day AS car_price_per_day
        FROM rentals r
        JOIN cars c ON r.car_id = c.car_id
        WHERE r.customer_id = :customer_id
        ORDER BY r.pick_up_date DESC
    ");
    $stmt->bindParam(':customer_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rented Cars</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .future {
            background-color: #ffe0b2; 
        }
        .current {
            background-color: #b3e5fc; 
        }
        .past {
            background-color: #c8e6c9; 
        }
    </style>
</head>
<body>
    <h1>View Rented Cars</h1>
    <table>
        <tr>
            <th>Rental ID</th>
            <th>Customer ID</th>
            <th>Car Make</th>
            <th>Car Model</th>
            <th>Car Type</th>
            <th>Pick-up Date</th>
            <th>Pick-up Location</th>
            <th>Return Date</th>
            <th>Return Location</th>
            <th>Total Amount</th>
            <th>Rental Status</th>
        </tr>
        <?php foreach ($rentals as $rental): ?>
            <?php
            $today = date('Y-m-d');
            $pick_up_date = date('Y-m-d', strtotime($rental['pick_up_date']));
            $return_date = date('Y-m-d', strtotime($rental['return_date']));
            if ($pick_up_date > $today) {
                $status = 'future';
            } elseif ($return_date < $today) {
                $status = 'past';
            } else {
                $status = 'current';
            }
            ?>
            <tr class="<?php echo $status; ?>">
                <td><?php echo htmlspecialchars($rental['rental_id']); ?></td>
                <td><?php echo htmlspecialchars($rental['customer_id']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_make']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_model']); ?></td>
                <td><?php echo htmlspecialchars($rental['car_type']); ?></td>
                <td><?php echo htmlspecialchars($rental['pick_up_date']); ?></td>
                <td><?php echo htmlspecialchars($rental['pick_up_location']); ?></td>
                <td><?php echo htmlspecialchars($rental['return_date']); ?></td>
                <td><?php echo htmlspecialchars($rental['return_location']); ?></td>
                <td><?php echo htmlspecialchars($rental['total_amount']); ?></td>
                <td><?php echo ucfirst($status); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
