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

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and store tenant_id
    $tenant_id = sanitize_input($_POST["tenant_id"]);
}

// SQL query to select all tenants
$tenant_query = "SELECT * FROM tenant";

// Execute tenant query
$tenant_result = $conn->query($tenant_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Details</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #289898;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        select {
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #dd3333;
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
    <h2>Tenant Details</h2>
    <table>
        <tr>
            <th>Tenant ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Age</th>
            <th>Date of Birth</th>
            <th>Action</th>
        </tr>
        <?php
        // Output tenant details in table rows
        if ($tenant_result->num_rows > 0) {
            while ($row = $tenant_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["tenant_id"] . "</td>";
                echo "<td>" . $row["first_name"] . "</td>";
                echo "<td>" . $row["last_name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone_number"] . "</td>";
                echo "<td>" . $row["age"] . "</td>";
                echo "<td>" . $row["dob"] . "</td>";
                echo "<td>";
                echo "<button class='delete-button' onclick='deleteTenant(" . $row["tenant_id"] . ")'>Delete</button>";
                echo "<button class='delete-button' onclick='editTenant(" . $row["tenant_id"] . ")'>Edit</button>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No tenants found</td></tr>";
        }
        ?>
    </table>
    <script>
        // JavaScript function to delete a tenant
        function deleteTenant(tenant_id) {
            // Confirm deletion
            if (confirm("Are you sure you want to delete this tenant?")) {
                // Redirect to delete tenant script with tenant_id parameter
                window.location = "delete_tenant.php?tenant_id=" + tenant_id;
            }
        }

        // JavaScript function to edit a tenant
        function editTenant(tenant_id) {
            // Redirect to edit tenant script with tenant_id parameter
            window.location = "edit_tenant.php?tenant_id=" + tenant_id;
        }
    </script>
    <a href="empdashboard.php" class="back-button">Return Home</a>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
