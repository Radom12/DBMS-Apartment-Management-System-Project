<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $tenant_id = $_POST['tenant'];
    $service_id = $_POST['service'];
    $time = $_POST['time'];

    // Prepare and execute SQL statement to insert service request
    $insert_query = "INSERT INTO service_requests (tenant_id, service_id, requested_time) VALUES ('$tenant_id', '$service_id', '$time')";

    if ($conn->query($insert_query) === TRUE) {
        // Redirect back to the service request page
        header("Location: requestservice.php");
        exit();
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}

// Fetch tenants from the database
$tenant_query = "SELECT tenant_id, CONCAT(first_name, ' ', last_name) AS tenant_name FROM tenant";
$tenant_result = $conn->query($tenant_query);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9); /* Add semi-transparent white background */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        label {
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"], .return-button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        input[type="submit"]:hover, .return-button:hover {
            background-color: #45a049;
        }
        .button-container {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Request Service</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="tenant">Select Tenant:</label>
            <select name="tenant" id="tenant">
                <?php
                if ($tenant_result->num_rows > 0) {
                    while ($row = $tenant_result->fetch_assoc()) {
                        echo "<option value='" . $row["tenant_id"] . "'>" . $row["tenant_name"] . "</option>";
                    }
                }
                ?>
            </select>
            <label for="service">Select Service:</label>
            <select name="service" id="service">
                <option value="1">Plumbing Repair</option>
                <option value="2">Electrical Maintenance</option>
                <option value="3">HVAC Service</option>
                <option value="4">Pest Control</option>
                <option value="5">Appliance Repair</option>
            </select>
            <label for="time">Select Requested Time Range:</label>
            <select name="time" id="time">
                <option value="14:00 - 15:00">14:00 - 15:00</option>
                <option value="15:00 - 16:00">15:00 - 16:00</option>
                <option value="16:00 - 17:00">16:00 - 17:00</option>
                <!-- Add more options as needed -->
            </select>
            <input type="submit" value="Submit Request">
        </form>
    </div>
</body>
</html>
