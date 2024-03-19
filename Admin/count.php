<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$owner_query = "SELECT COUNT(*) AS total_owners FROM owner";

$owner_result = $conn->query($owner_query);

$tenant_query = "SELECT COUNT(*) AS total_tenants FROM tenant";

$tenant_result = $conn->query($tenant_query);

$employee_query = "SELECT COUNT(*) AS total_employees FROM employee";

$employee_result = $conn->query($employee_query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Totals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 50%;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
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
    <h2>Total Number of Managers, Tenants, and Employees</h2>
    <table>
        <tr>
            <th>Total Managers</th>
            <th>Total Tenants</th>
            <th>Total Employees</th>
        </tr>
        <tr>
            <?php
            if ($owner_result->num_rows > 0) {
                $row = $owner_result->fetch_assoc();
                echo "<td>".$row["total_owners"]."</td>";
            } else {
                echo "<td>0</td>";
            }

            if ($tenant_result->num_rows > 0) {
                $row = $tenant_result->fetch_assoc();
                echo "<td>".$row["total_tenants"]."</td>";
            } else {
                echo "<td>0</td>";
            }

            if ($employee_result->num_rows > 0) {
                $row = $employee_result->fetch_assoc();
                echo "<td>".$row["total_employees"]."</td>";
            } else {
                echo "<td>0</td>";
            }
            ?>
        </tr>
    </table>
    <a href="admin_dashboard.php" class="back-button">Return Home</a>
</body>
</html>
