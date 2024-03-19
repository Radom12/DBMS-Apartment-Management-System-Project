<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
    <style>
body {
    background-image: url('../images/1.jpg'); /* Replace 'your_background_image.jpg' with your image path */
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
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

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .back-button, .delete-button, .create-employee-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            margin-right: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover, .delete-button:hover, .create-employee-button:hover {
            background-color: #45a049;
        }

        .delete-button {
            background-color: #f44336;
        }

        .delete-button:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Start session
        session_start();

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

        // Check if a deletion request is made
        if (isset($_GET['delete_id'])) {
            $delete_id = $_GET['delete_id'];
            // Delete the employee with the given ID
            $sql = "DELETE FROM employee WHERE employee_id = $delete_id";
            if ($conn->query($sql) === TRUE) {
                echo "Employee deleted successfully.";
            } else {
                echo "Error deleting employee: " . $conn->error;
            }
        }

        // Query to retrieve all employees
        $query = "SELECT * FROM employee";

        // Execute query
        $result = $conn->query($query);

        // Check if any employees found
        if ($result->num_rows > 0) {
            // Output employee details
            echo "<h2>All Employees</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["employee_id"] . "</td>";
                echo "<td>" . $row["first_name"] . "</td>";
                echo "<td>" . $row["last_name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone_number"] . "</td>";
                echo "<td><a href='?delete_id=" . $row["employee_id"] . "' class='delete-button'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No employees found.";
        }

        // Close database connection
        $conn->close();
        ?>
        <br>
        <a href="../admin/admin_dashboard.php" class="back-button">Return Home</a>
        <a href="../owner/createemployee.php" class="create-employee-button">Create Employee</a>
    </div>
</body>
</html>
