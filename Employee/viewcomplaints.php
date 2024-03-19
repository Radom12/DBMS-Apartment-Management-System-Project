<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
            background-color: #f5f5f5;
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
    <div class="container">
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

        // Query to retrieve all complaints
        $query = "SELECT c.complaint_id, c.description, t.first_name AS tenant_first_name, t.last_name AS tenant_last_name, o.first_name AS owner_first_name, o.last_name AS owner_last_name, e.first_name AS employee_first_name, e.last_name AS employee_last_name
                  FROM complaint c
                  LEFT JOIN tenant t ON c.tenant_id = t.tenant_id
                  LEFT JOIN owner o ON c.owner_id = o.owner_id
                  LEFT JOIN employee e ON c.employee_id = e.employee_id";

        // Execute query
        $result = $conn->query($query);

        // Check if any complaints found
        if ($result->num_rows > 0) {
            // Output complaint details
            echo "<h2>All Complaints</h2>";
            echo "<table>";
            echo "<tr><th>Complaint ID</th><th>Description</th><th>Tenant Name</th><th>Owner Name</th><th>Employee Name</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["complaint_id"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["tenant_first_name"] . " " . $row["tenant_last_name"] . "</td>";
                echo "<td>" . $row["owner_first_name"] . " " . $row["owner_last_name"] . "</td>";
                echo "<td>" . $row["employee_first_name"] . " " . $row["employee_last_name"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No complaints found.</p>";
        }

        // Close
        ?>
        <a href="empdashboard.php" class="back-button">Return Home</a>
    </div>
</body>
</html>
