<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Slot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .parking-slot {
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Parking Slot</h2>
        <form method="POST" action="">
            <label for="employee">Select Employee:</label>
            <select name="employee" id="employee">
                <!-- Populate dropdown with employee names -->
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
                $query = "SELECT employee_id, first_name, last_name FROM employee";

                // Execute query
                $result = $conn->query($query);

                // Check if any employees found
                if ($result->num_rows > 0) {
                    // Output employee names as dropdown options
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["employee_id"] . "'>" . $row["first_name"] . " " . $row["last_name"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No employees found</option>";
                }

                // Close database connection
                $conn->close();
                ?>
            </select>
            <button type="submit" name="submit">Submit</button>
        </form>

        <!-- Display parking slot information -->
        <?php
        if (isset($_POST['submit'])) {
            // Get selected employee ID
            $employee_id = $_POST['employee'];

            // Query to retrieve parking slot for selected employee
            $query = "SELECT parking_slot FROM parking WHERE employee_id = $employee_id";

            // Execute query
            $result = $conn->query($query);

            // Check if any parking slot found
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<div class='parking-slot'>Parking Slot: " . $row['parking_slot'] . "</div>";
            } else {
                echo "<div class='parking-slot'>No parking slot allotted to this employee</div>";
            }
        }
        ?>
    </div>
</body>
</html>
