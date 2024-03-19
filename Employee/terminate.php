<?php
// Start the session
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

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Login functionality
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = sanitize_input($_POST["user_type"]);
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);

    // Check user type and validate credentials accordingly
    switch ($user_type) {
        case 'admin':
            $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
            break;
        case 'owner':
            $query = "SELECT * FROM owner WHERE username='$username' AND password='$password'";
            break;
        case 'tenant':
            $query = "SELECT * FROM tenant WHERE username='$username' AND password='$password'";
            break;
        case 'employee':
            $query = "SELECT * FROM employee WHERE username='$username' AND password='$password'";
            break;
        default:
            echo "Invalid user type";
            exit;
    }

    // Execute query
    $result = $conn->query($query);

    // Check if user exists
    if ($result->num_rows == 1) {
        // Authentication successful, set session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["user_type"] = $user_type;
        $_SESSION["username"] = $username;
        // Redirect to dashboard or desired page
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Invalid username or password";
    }
}

// Logout functionality
if (isset($_GET["logout"]) && $_GET["logout"] == true) {
    // Unset all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Close database connection
$conn->close();
?>
