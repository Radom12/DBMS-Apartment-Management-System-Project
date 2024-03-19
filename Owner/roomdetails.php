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

// Query to get the total number of flats
$query_total_flats = "SELECT SUM(total_flats) AS total_flats FROM room";

// Execute query
$result_total_flats = $conn->query($query_total_flats);

// Check if the query was successful
if ($result_total_flats) {
    $row_total_flats = $result_total_flats->fetch_assoc();
    $total_flats = $row_total_flats['total_flats'];
} else {
    $total_flats = 0; // Default value if query fails
}

// Query to get the number of allotted flats
$query_allotted_flats = "SELECT COUNT(*) AS allotted_flats FROM room WHERE owner_id IS NOT NULL";

// Execute query
$result_allotted_flats = $conn->query($query_allotted_flats);

// Check if the query was successful
if ($result_allotted_flats) {
    $row_allotted_flats = $result_allotted_flats->fetch_assoc();
    $allotted_flats = $row_allotted_flats['allotted_flats'];
} else {
    $allotted_flats = 0; // Default value if query fails
}

// Calculate the number of available flats
$available_flats = $total_flats - $allotted_flats;

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
            margin-bottom: 10px;
        }
        .total-flats {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
        }
        .allotted-flats {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
        }
        .available-flats {
            background-color: #e8f8f5;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Room Details</h2>
        <p class="total-flats">Total Flats: <?php echo $total_flats; ?></p>
        <p class="allotted-flats">Allotted Flats: <?php echo $allotted_flats; ?></p>
        <p class="available-flats">Available Flats: <?php echo $available_flats; ?></p>
    </div>
</body>
</html>
