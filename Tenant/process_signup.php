<?php
// Start session
session_start();

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

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $phone = sanitize_input($_POST["phone"]);
    $age = sanitize_input($_POST["age"]);
    $dob = sanitize_input($_POST["dob"]);
    $building_name = sanitize_input($_POST["building_name"]);
    $owner_name = sanitize_input($_POST["owner_name"]);
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);

    // Get owner ID based on owner name
    $owner_query = "SELECT owner_id FROM owner WHERE CONCAT(first_name, ' ', last_name) = '$owner_name'";
    $owner_result = $conn->query($owner_query);

    if ($owner_result->num_rows > 0) {
        $owner_row = $owner_result->fetch_assoc();
        $owner_id = $owner_row['owner_id'];

        // Insert user data into tenant table
        $insert_query = "INSERT INTO tenant (first_name, last_name, email, phone_number, age, dob, owner_id, username, password) 
                         VALUES ('$name', '', '$email', '$phone', '$age', '$dob', '$owner_id', '$username', '$password')";

        if ($conn->query($insert_query) === TRUE) {
            echo "New record created successfully";
            // Redirect to login page
            header("Location: tenant_login.php");
            exit();
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    } else {
        echo "Owner not found";
    }
}

// Close connection
$conn->close();
?>
