<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$tenant_query = "SELECT tenant_id, CONCAT(first_name, ' ', last_name) AS tenant_name FROM tenant";
$tenant_result = $conn->query($tenant_query);

if ($tenant_result) {
    if (isset($_GET["tenant_id"])) {
        $tenant_id = sanitize_input($_GET["tenant_id"]);

        $query = "SELECT ps.parking_slot_id, ps.slot_number
                  FROM parking_slot ps
                  INNER JOIN tenant t ON ps.owner_id = t.owner_id
                  WHERE t.tenant_id = $tenant_id";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2 class='parking-slot-header'>Your Allotted Parking Slot</h2>";
            echo "<div class='parking-slot-details'>";
            echo "<p><strong>Parking Slot ID:</strong> " . $row["parking_slot_id"] . "</p>";
            echo "<p><strong>Slot Number:</strong> " . $row["slot_number"] . "</p>";
            echo "</div>";
        } else {
            echo "<p class='no-slot-message'>You don't have an allotted parking slot.</p>";
        }
    } else {
    }
} else {
    echo "<p class='error-message'>Error fetching tenant names.</p>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Tenant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../images/1.jpg'); /* Set the background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Add a semi-transparent white background */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }
        .parking-slot-header {
            color: #333;
        }
        .parking-slot-details {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .no-slot-message, .select-tenant-message, .error-message {
            color: #ff0000;
            text-align: center; /* Center the text */
        }
        .back-button {
    display: inline-block; /* Change from 'block' to 'inline-block' */
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-left: 570px; /* Adjust margin as needed */
    margin-top: -600px; /* Center the button */
}


        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Tenant</h2>
        <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="tenant_id">Tenant Name:</label>
            <select id="tenant_id" name="tenant_id">
                <option value="">Select Tenant</option>
                <?php
                while ($row = $tenant_result->fetch_assoc()) {
                    echo "<option value='" . $row["tenant_id"] . "'>" . $row["tenant_name"] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Submit">
        </form>
        <?php
        if (!$tenant_result) {
            echo "<p class='error-message'>Error fetching tenant names.</p>";
        } elseif (!isset($_GET["tenant_id"])) {
        }
        ?>
    </div>
    <a href="tenant_dashboard.php" class="back-button">Return Home</a>
</body>
</html>
