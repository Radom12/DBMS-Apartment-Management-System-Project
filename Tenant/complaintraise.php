<?php
function sanitize_input($data) {
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raise Complaint</title>
    <style>
        /* Add CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/1.jpg'); /* Replace 'your_background_image.jpg' with your image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding: 20px;
            margin: 0;
        }
        h2 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        label {
            font-weight: bold;
        }
        select, textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
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
        .success-msg {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Raise Complaint</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="tenant_id">Tenant:</label><br>
        <select name="tenant_id" id="tenant_id" required>
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

            // Retrieve and output tenant options
            $tenant_query = "SELECT tenant_id, CONCAT(first_name, ' ', last_name) AS tenant_name FROM tenant";
            $tenant_result = $conn->query($tenant_query);
            if ($tenant_result->num_rows > 0) {
                while ($row = $tenant_result->fetch_assoc()) {
                    echo "<option value='" . $row["tenant_id"] . "'>" . $row["tenant_name"] . "</option>";
                }
            } else {
                echo "<option value=''>No Tenants Found</option>";
            }
            ?>
        </select><br>
        <label for="employee_id">Employee:</label><br>
        <select name="employee_id" id="employee_id" required>
            <?php
            // Retrieve and output employee options
            $employee_query = "SELECT employee_id, first_name FROM employee";
            $employee_result = $conn->query($employee_query);
            if ($employee_result->num_rows > 0) {
                while ($row = $employee_result->fetch_assoc()) {
                    echo "<option value='" . $row["employee_id"] . "'>" . $row["first_name"] . "</option>";
                }
            } else {
                echo "<option value=''>No Employees Found</option>";
            }
            ?>
        </select><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="Submit Complaint">
    </form>

    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Sanitize and get input data
        $tenant_id = sanitize_input($_POST["tenant_id"]);
        $description = sanitize_input($_POST["description"]);
        $employee_id = sanitize_input($_POST["employee_id"]);

        // Prepare SQL statement to insert complaint details
        $stmt = $conn->prepare("INSERT INTO complaint (description, tenant_id, employee_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $description, $tenant_id, $employee_id);

        // Execute the prepared statement
        if ($stmt->execute() === TRUE) {
            echo "<div class='success-msg'>Complaint raised successfully</div>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close prepared statement
        $stmt->close();

        // Close database connection
        $conn->close();
    }
    ?>
    <a href="tenant_dashboard.php" class="back-button">Return Home</a>
</body>
</html>
