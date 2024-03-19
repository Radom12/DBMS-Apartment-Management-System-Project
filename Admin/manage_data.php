<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$employee_query = "SELECT * FROM employee";
$employee_result = $conn->query($employee_query);

$tenant_query = "SELECT * FROM tenant";
$tenant_result = $conn->query($tenant_query);

$owner_query = "SELECT * FROM owner";
$owner_result = $conn->query($owner_query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees, Tenants, and Owners</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2, h3 {
            color: #333;
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        li {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        li:hover {
            background-color: #f2f2f2;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .export-button {
            display: block;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 20px auto;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }
        .export-button:hover {
            background-color: #0056b3;
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
    <h2>Manage Employees, Tenants, and Owners</h2>
    <h3>Employees:</h3>
    <ul>
        <?php
        if ($employee_result->num_rows > 0) {
            while ($row = $employee_result->fetch_assoc()) {
                echo "<li>" . $row["first_name"] ." " . $row["last_name"]. "-" . $row["email"] . " - <a href='delete.php?type=employee&id=" . $row["employee_id"] . "'>Delete</a></li>";
            }
        } else {
            echo "<li>No employees found.</li>";
        }
        ?>
    </ul>
    
    <h3>Tenants:</h3>
    <ul>
        <?php
        if ($tenant_result->num_rows > 0) {
            while ($row = $tenant_result->fetch_assoc()) {
                echo "<li>" . $row["first_name"] . " " . $row["last_name"] . " - " . $row["email"] . " - <a href='delete.php?type=tenant&id=" . $row["tenant_id"] . "'>Delete</a></li>";
            }
        } else {
            echo "<li>No tenants found.</li>";
        }
        ?>
    </ul>
    
    <a class="export-button" href="export.php">Export to Spreadsheet</a>
    <a href="admin_dashboard.php" class="back-button">Return Home</a>
</body>
</html>

