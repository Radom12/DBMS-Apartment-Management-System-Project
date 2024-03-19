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

// Initialize success message variable
$success_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get input data
    $first_name = sanitize_input($_POST["first_name"]);
    $last_name = sanitize_input($_POST["last_name"]);
    $email = sanitize_input($_POST["email"]);
    $phone_number = sanitize_input($_POST["phone_number"]);
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);
    
    // Prepare SQL statement to insert employee details
    $stmt = $conn->prepare("INSERT INTO employee (first_name, last_name, email, phone_number, username, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone_number, $username, $password);
    
    // Execute the prepared statement
    if ($stmt->execute() === TRUE) {
        $success_message = "Employee created successfully";
        
        // Redirect to viewempl.php after successful creation
        header("Location: ../owner/viewempl.php");
        exit(); // Ensure script execution stops after redirection
    } else {
        echo "Error: " . $stmt->error;
    }
    
    
    // Close prepared statement
    $stmt->close();
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:  #289898;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Added for positioning the success message */
        }
        .success-message {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 8px 8px 0 0;
            text-align: center;
            display: <?php echo ($success_message != "") ? "block" : "none"; ?>; /* Show only if success message exists */
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 20px;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-message"><?php echo $success_message; ?></div> <!-- Success message area -->
        <h2>Create Employee</h2>
        <form method="post" action="createemployee.php">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Create Employee">
        </form>
    </div>
    <a href="../admin/admin_dashboard.php" class="back-button">Return Home</a>
</body>
</html>
