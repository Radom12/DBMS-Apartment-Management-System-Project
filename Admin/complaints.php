<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$complaint_query = "SELECT c.complaint_id, c.description, t.first_name AS tenant_first_name, t.last_name AS tenant_last_name, o.first_name AS owner_first_name, o.last_name AS owner_last_name, e.first_name AS employee_first_name, e.last_name AS employee_last_name
                    FROM complaint c
                    LEFT JOIN tenant t ON c.tenant_id = t.tenant_id
                    LEFT JOIN owner o ON c.owner_id = o.owner_id
                    LEFT JOIN employee e ON c.employee_id = e.employee_id";

$complaint_result = $conn->query($complaint_query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/1.jpg'); /* Replace 'your_background_image.jpg' with your image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: #fff;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
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
    <h2>Complaints</h2>
    <table>
        <tr>
            <th>Complaint ID</th>
            <th>Description</th>
            <th>Tenant</th>
            <th>Owner</th>
            <th>Employee</th>
        </tr>
        <?php
        while($row = $complaint_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["complaint_id"]."</td>";
            echo "<td>".$row["description"]."</td>";
            echo "<td>".$row["tenant_first_name"]." ".$row["tenant_last_name"]."</td>";
            echo "<td>".$row["owner_first_name"]." ".$row["owner_last_name"]."</td>";
            echo "<td>".$row["employee_first_name"]." ".$row["employee_last_name"]."</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <a href="admin_dashboard.php" class="back-button">Return Home</a>
</body>
</html>
