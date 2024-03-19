<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/1.jpg'); /* Replace 'background-image.jpg' with your image file path */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the background image */
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Fees Details</h2>
        <table>
            <tr>
                <th>Tenant Name</th>
                <th>Service Name</th>
                <th>Total Fees Paid</th>
            </tr>
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

            // Query to retrieve fees details including service name and grouped by tenant name
            $query = "SELECT CONCAT(tenant.first_name, ' ', tenant.last_name) AS tenant_name, services.service_name, 
                      SUM(maintenance_payment.amount_paid) AS total_fees_paid
                      FROM tenant
                      LEFT JOIN maintenance_payment ON tenant.tenant_id = maintenance_payment.tenant_id
                      LEFT JOIN services ON maintenance_payment.service_id = services.service_id
                      GROUP BY tenant_name, service_name";

            // Execute query
            $result = $conn->query($query);

            // Check if any data found
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["tenant_name"] . "</td>";
                    echo "<td>" . $row["service_name"] . "</td>";
                    echo "<td>₹" . $row["total_fees_paid"] . "</td>"; // Assuming fees are in USD
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data found</td></tr>";
            }

            // Close database connection
            $conn->close();
            ?>
        </table>
    </div>
    <a href="../admin/admin_dashboard.php" class="back-button">Return Home</a>
</body>
</html>