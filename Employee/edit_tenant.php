<?php
// Start the session
session_start();

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

// Variable to store tenant_id
$tenant_id = "";

// Check if tenant_id is provided in the URL
if (isset($_GET["tenant_id"])) {
    // Sanitize and store tenant_id
    $tenant_id = sanitize_input($_GET["tenant_id"]);
} else {
    // Redirect to tenant list page if tenant_id is not provided
    header("Location: viewtenant.php");
    exit();
}

// Retrieve tenant details based on tenant_id
$tenant_query = "SELECT * FROM tenant WHERE tenant_id = $tenant_id";
$tenant_result = $conn->query($tenant_query);

// Check if tenant exists
if ($tenant_result->num_rows == 0) {
    // Redirect to tenant list page if tenant does not exist
    header("Location: viewtenant.php");
    exit();
}

// Fetch tenant details
$tenant_row = $tenant_result->fetch_assoc();

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and store updated tenant details
    $first_name = sanitize_input($_POST["first_name"]);
    $last_name = sanitize_input($_POST["last_name"]);
    $email = sanitize_input($_POST["email"]);
    $phone_number = sanitize_input($_POST["phone_number"]);
    $age = sanitize_input($_POST["age"]);
    $dob = sanitize_input($_POST["dob"]);

    // Update tenant details in the database
    $update_query = "UPDATE tenant SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone_number = '$phone_number', age = '$age', dob = '$dob' WHERE tenant_id = $tenant_id";
    if ($conn->query($update_query) === TRUE) {
        // Redirect to tenant list page after successful update
        header("Location: viewtenant.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tenant</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
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

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
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
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Edit Tenant</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?tenant_id=" . $tenant_id); ?>">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $tenant_row["first_name"]; ?>" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $tenant_row["last_name"]; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $tenant_row["email"]; ?>" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?php echo $tenant_row["phone_number"]; ?>" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo $tenant_row["age"]; ?>" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<?php echo $tenant_row["dob"]; ?>" required>

        <input type="submit" value="Update Tenant">
    </form>
    <a href="viewtenant.php" class="back-button">Cancel</a>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
