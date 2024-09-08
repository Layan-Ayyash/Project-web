<?php
include("db.php.inc.php"); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (empty($_POST['plate_number'])) {
            throw new Exception('errorً');
        }

        $check_sql = "SELECT COUNT(*) FROM cars WHERE plate_number = :plate_number";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->bindValue(':plate_number', $_POST['plate_number']);
        $check_stmt->execute();
        $count = $check_stmt->fetchColumn();

        if ($count > 0) {
            throw new Exception('plate number already exist, try another plate number');
        }

        $sql = "INSERT INTO cars (model, make, type, registration_year, description, price_per_day, capacity_people, capacity_suitcases, colors, fuel_type, avg_petrol_consumption, horsepower, length, width, plate_number, conditions, image1, image2, image3)
                VALUES (:model, :make, :type, :registration_year, :description, :price_per_day, :capacity_people, :capacity_suitcases, :colors, :fuel_type, :avg_petrol_consumption, :horsepower, :length, :width, :plate_number, :conditions, '', '', '')";

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':model', $_POST['model']);
        $stmt->bindValue(':make', $_POST['make']);
        $stmt->bindValue(':type', $_POST['type']);
        $stmt->bindValue(':registration_year', $_POST['registration_year']);
        $stmt->bindValue(':description', $_POST['description']);
        $stmt->bindValue(':price_per_day', $_POST['price_per_day']);
        $stmt->bindValue(':capacity_people', $_POST['capacity_people']);
        $stmt->bindValue(':capacity_suitcases', $_POST['capacity_suitcases']);
        $stmt->bindValue(':colors', $_POST['colors']);
        $stmt->bindValue(':fuel_type', $_POST['fuel_type']);
        $stmt->bindValue(':avg_petrol_consumption', $_POST['avg_petrol_consumption']);
        $stmt->bindValue(':horsepower', $_POST['horsepower']);
        $stmt->bindValue(':length', $_POST['length']);
        $stmt->bindValue(':width', $_POST['width']);
        $stmt->bindValue(':plate_number', $_POST['plate_number']);
        $stmt->bindValue(':conditions', $_POST['conditions']);

        if ($stmt->execute()) {
            $car_id = $pdo->lastInsertId();

            $upload_success = true; 
            $image_paths = ['', '', '']; 

            for ($i = 0; $i < count($_FILES['photos']['name']); $i++) {
                $target_file = $_FILES['photos']['tmp_name'][$i];
                $imageFileType = strtolower(pathinfo($_FILES['photos']['name'][$i], PATHINFO_EXTENSION));

                if ($imageFileType !== 'jpg') {
                    $upload_success = false;
                    throw new Exception('only JPG.');
                }

                $image_path = "carsImages/car" . $car_id . "img" . ($i + 1) . ".jpg";
                if (move_uploaded_file($target_file, $image_path)) {
                    $image_paths[$i] = $image_path;
                } else {
                    $upload_success = false;
                    throw new Exception('error uplode photo');
                }
            }

            if ($upload_success) {
                $sql_update = "UPDATE cars SET image1 = :image1, image2 = :image2, image3 = :image3 WHERE plate_number = :plate_number";
                $stmt_update = $pdo->prepare($sql_update);
                $stmt_update->bindValue(':image1', $image_paths[0]);
                $stmt_update->bindValue(':image2', $image_paths[1]);
                $stmt_update->bindValue(':image3', $image_paths[2]);
                $stmt_update->bindValue(':plate_number', $_POST['plate_number']);

                if ($stmt_update->execute()) {
                    echo "add sucessfully" . $car_id;
                } else {
                    throw new Exception();
                }
            }
        } else {
            throw new Exception();
        }
    } catch (PDOException $e) {
        echo "PDO Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
