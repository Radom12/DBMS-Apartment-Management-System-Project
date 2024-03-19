<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Maintenance Fees</title>
    <style>
                body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
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
            margin-top: 20px;
        }

        table, th, td {
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
    <h2>Select Tenant to View Maintenance Fees</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="tenant_name">Select Tenant:</label>
        <select id="tenant_name" name="tenant_name">
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

            // Retrieve tenant names for dropdown
            $tenant_query = "SELECT tenant_id, CONCAT(first_name, ' ', last_name) AS tenant_name FROM tenant";
            $tenant_result = $conn->query($tenant_query);

            if ($tenant_result->num_rows > 0) {
                while ($row = $tenant_result->fetch_assoc()) {
                    echo "<option value='" . $row["tenant_id"] . "'>" . $row["tenant_name"] . "</option>";
                }
            }

            // Close database connection
            $conn->close();
            ?>
        </select>
        <input type="submit" value="View Fees">
    </form>

    <?php
    // Display maintenance fees if form submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tenant_name"])) {
        $selected_tenant_id = $_POST["tenant_name"];

        // Database connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to retrieve maintenance fees paid by the selected tenant
        $fee_query = "SELECT payment_id, amount_paid, payment_date FROM maintenance_payment WHERE tenant_id = $selected_tenant_id";
        $fee_result = $conn->query($fee_query);

        if ($fee_result->num_rows > 0) {
            // Output fee details
            echo "<h3>Maintenance Fees Paid by Selected Tenant:</h3>";
            echo "<table>";
            echo "<tr><th>Payment ID</th><th>Amount Paid</th><th>Payment Date</th></tr>";
            while ($row = $fee_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["payment_id"] . "</td>";
                echo "<td>" . $row["amount_paid"] . "</td>";
                echo "<td>" . $row["payment_date"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No maintenance fees found for this tenant.";
        }

        // Close database connection
        $conn->close();
    }
    ?>
        <a href="owner_dashboard.php" class="back-button">Return Home</a>
</body>
</html>
