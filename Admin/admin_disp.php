<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_management";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
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
    <title>Tenant and Owner Details</title>
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
            margin-top: 20px;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
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
        </tr>
        <?php
        while($row = $tenant_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["tenant_id"]."</td>";
            echo "<td>".$row["first_name"]."</td>";
            echo "<td>".$row["last_name"]."</td>";
            echo "<td>".$row["email"]."</td>";
            echo "<td>".$row["phone_number"]."</td>";
            echo "<td>".$row["age"]."</td>";
            echo "<td>".$row["dob"]."</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h2>Owner Details</h2>
    <table>
        <tr>
            <th>Owner ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone Number</th>
        </tr>
        <?php
        while($row = $owner_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["owner_id"]."</td>";
            echo "<td>".$row["first_name"]."</td>";
            echo "<td>".$row["last_name"]."</td>";
            echo "<td>".$row["email"]."</td>";
            echo "<td>".$row["phone_number"]."</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <a href="admin_dashboard.php" class="back-button">Return Home</a>
</body>
</html>

