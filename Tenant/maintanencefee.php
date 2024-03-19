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

// Fetch tenants from the database
$tenant_query = "SELECT tenant_id, CONCAT(first_name, ' ', last_name) AS tenant_name FROM tenant";
$tenant_result = $conn->query($tenant_query);

// Fetch services from the database
$service_query = "SELECT service_id, service_name, fee_amount FROM services";
$service_result = $conn->query($service_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Maintenance Fee</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/1.jpg'); /* Replace 'your_background_image.jpg' with your image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"], .back-button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-button {
            background-color: #008CBA;
            color: white;
            border: none;
        }

        .back-button:hover {
            background-color: #0073e6;
        }
    </style>
</head>
</head>
<body>
    <h2>Pay Maintenance Fee</h2>
    <form method="post" action="submit_maintenance_fee.php">
        <label for="tenant_id">Tenant Name:</label><br>
        <select id="tenant_id" name="tenant_id">
            <?php
            if ($tenant_result->num_rows > 0) {
                while ($row = $tenant_result->fetch_assoc()) {
                    echo "<option value='" . $row["tenant_id"] . "'>" . $row["tenant_name"] . "</option>";
                }
            }
            ?>
        </select><br>

        <label for="service_id">Service:</label><br>
        <select id="service_id" name="service_id">
            <?php
            if ($service_result->num_rows > 0) {
                while ($row = $service_result->fetch_assoc()) {
                    echo "<option value='" . $row["service_id"] . "'>" . $row["service_name"] . " (₹" . $row["fee_amount"] . ")</option>";
                }
            }
            ?>
        </select><br>

        <label for="amount_paid">Amount Paid:</label><br>
        <input type="number" id="amount_paid" name="amount_paid" step="0.01" min="0" required><br><br>
        <input type="submit" value="Pay Fee">
    </form>
    <a href="tenant_dashboard.php" class="back-button">Return Home</a>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>