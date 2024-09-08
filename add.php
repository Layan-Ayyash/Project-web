<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add A Car</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <header>
        <h1>Add A Car</h1>
    </header>
    <main>
        <form action="add-database.php" method="POST" enctype="multipart/form-data">
            <label for="model">Car Model:</label><br>
            <input type="text" id="model" name="model" required><br><br>
            
            <label for="make">Car Make:</label><br>
            <select id="make" name="make" required>
                <option value="BMW">BMW</option>
                <option value="VW">VW</option>
                <option value="Volvo">Volvo</option>
                <option value="Mercedes">Mercedes</option>
                <option value="Seat">Seat</option>
                <option value="Ford">Ford</option>
                <option value="Honda">Honda</option>
                <option value="Tesla ">Tesla </option>
                <option value="Audi  ">Audi </option>
                <option value="Lexus   ">Lexus  </option>
            </select><br><br>
            
            <label for="type">Car Type:</label><br>
            <select id="type" name="type" required>
                <option value="Van">Van</option>
                <option value="Mini-Van">Mini-Van</option>
                <option value="State">State</option>
                <option value="Sedan">Sedan</option>
                <option value="SUV">SUV</option>
                <option value="Seat">Hatchback</option>


            </select><br><br>
            
            <label for="registration_year">Registration Year:</label><br>
            <input type="number" id="registration_year" name="registration_year" required><br><br>
            
            <label for="description">Brief Description:</label><br>
            <textarea id="description" name="description" rows="4" required></textarea><br><br>
            
            <label for="price_per_day">Price per Day:</label><br>
            <input type="number" id="price_per_day" name="price_per_day" required><br><br>
            
            <label for="capacity_people">Capacity (People):</label><br>
            <input type="number" id="capacity_people" name="capacity_people" required><br><br>
            
            <label for="capacity_suitcases">Capacity (Suitcases):</label><br>
            <input type="number" id="capacity_suitcases" name="capacity_suitcases" required><br><br>
            
            <label for="colors">Colors:</label><br>
            <input type="text" id="colors" name="colors" required><br><br>
            
            <label for="fuel_type">Fuel Type:</label><br>
            <select id="fuel_type" name="fuel_type" required>
                <option value="Petrol">Petrol</option>
                <option value="Diesel">Diesel</option>
                <option value="Electric">Electric</option>
                <option value="Hybrid">Hybrid</option>
            </select><br><br>
            
            <label for="avg_petrol_consumption">Average Petrol Consumption per 100 km:</label><br>
            <input type="number" id="avg_petrol_consumption" name="avg_petrol_consumption" required><br><br>
            
            <label for="horsepower">Horsepower:</label><br>
            <input type="number" id="horsepower" name="horsepower" required><br><br>
            
            <label for="length">Length:</label><br>
            <input type="number" id="length" name="length" required><br><br>
            
            <label for="width">Width:</label><br>
            <input type="number" id="width" name="width" required><br><br>
            
            <label for="photos">Photos (at least 3):</label><br>
            <input type="file" id="photos" name="photos[]" accept="image/jpeg, image/png" multiple required><br><br>
            
            <label for="plate_number">Plate Number:</label><br>
            <input type="text" id="plate_number" name="plate_number" required><br><br>
            
            <label for="conditions">Conditions or Restrictions:</label><br>
            <textarea id="conditions" name="conditions" rows="4"></textarea><br><br>
            
            <button type="submit">Add Car</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Car Rental Agency. All rights reserved.</p>
        <p>Contact us: contact@carrentalagency.com | +123 456 7890</p>
    </footer>
</body>
</html>
