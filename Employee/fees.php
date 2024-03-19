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

// Fetch fees details from the database
$query = "SELECT CONCAT(t.first_name, ' ', t.last_name) AS tenant_name, mp.amount_paid, mp.payment_date, s.service_name
          FROM maintenance_payment mp
          INNER JOIN tenant t ON mp.tenant_id = t.tenant_id
          INNER JOIN services s ON mp.service_id = s.service_id";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fees Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Fees Details</h2>
        <table>
            <tr>
                <th>Tenant Name</th>
                <th>Amount Paid</th>
                <th>Payment Date</th>
                <th>Service</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["tenant_name"] . "</td>";
                    echo "<td>" . $row["amount_paid"] . "</td>";
                    echo "<td>" . $row["payment_date"] . "</td>";
                    echo "<td>" . $row["service_name"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No data found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
