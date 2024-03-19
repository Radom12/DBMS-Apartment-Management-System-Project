<?php
// Connect to your database (replace placeholders with your actual connection details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apartment_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute a query to fetch statistics (replace with your actual query)
$sql = "SELECT COUNT(*) AS total_employees FROM employees";
$result = $conn->query($sql);

// Fetch and format data (assuming you have a results array)
$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data["totalEmployees"] = $row["total_employees"];
    }
} else {
    // Handle no data found scenario
}

// Close connection
$conn->close();

// Encode data as JSON
$responseData = json_encode($data);

// Return JSON data to client-side (replace with your preferred method)
echo $responseData;
