<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Employee</title>
    <style>
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
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        select, input[type="submit"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
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
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Select Employee</h2>
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

    // Query to retrieve employee names
    $query = "SELECT employee_id, CONCAT(first_name, ' ', last_name) AS name FROM employee";

    // Execute query
    $result = $conn->query($query);

    // Check if any employees found
    if ($result->num_rows > 0) {
        echo '<form action="" method="post">';
        echo '<label for="employee_id">Employee:</label>';
        echo '<select name="employee_id" id="employee_id">';
        while ($row = $result->fetch_assoc()) {
            $employeeId = $row["employee_id"];
            $employeeName = $row["name"];
            echo "<option value='$employeeId'>$employeeName</option>";
        }
        echo '</select>';
        echo '<input type="submit" value="View Complaints">';
        echo '</form>';
    } else {
        echo "No employees found.";
    }

    // Query to retrieve complaints for the selected employee
    if (isset($_POST['employee_id'])) {
        $employeeId = $_POST['employee_id'];
        $query = "SELECT * FROM complaint WHERE employee_id = $employeeId";

        // Execute query
        $complaintResult = $conn->query($query);

        // Display complaints, if any
        if ($complaintResult->num_rows > 0) {
            echo "<h2>Complaints for Selected Employee</h2>";
            echo "<table>";
            echo "<tr><th>Complaint ID</th><th>Description</th></tr>";
            while ($row = $complaintResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["complaint_id"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No complaints found for the selected employee.";
        }
    }

    // Close connection
    $conn->close();
    ?>

    <a href="owner_dashboard.php" class="back-button">Return Home</a>
</body>
</html>
