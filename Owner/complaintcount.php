<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner_id = sanitize_input($_POST["owner_id"]);

    $complaint_query = "SELECT COUNT(*) AS total_complaints
                        FROM complaint
                        WHERE owner_id = $owner_id";

    $complaint_result = $conn->query($complaint_query);
    $total_complaints = ($complaint_result->num_rows > 0) ? $complaint_result->fetch_assoc()["total_complaints"] : 0;

    $employee_query = "SELECT COUNT(*) AS total_employees
                       FROM employee
                       WHERE owner_id = $owner_id";

    $employee_result = $conn->query($employee_query);
    $total_employees = ($employee_result->num_rows > 0) ? $employee_result->fetch_assoc()["total_employees"] : 0;

    echo "<h2>Total Complaints: $total_complaints</h2>";
    echo "<h2>Total Employees: $total_employees</h2>";
}

$owner_names = array();
$owner_query = "SELECT owner_id, CONCAT(first_name, ' ', last_name) AS owner_name FROM owner";
$owner_result = $conn->query($owner_query);

if ($owner_result->num_rows > 0) {
    while ($row = $owner_result->fetch_assoc()) {
        $owner_names[$row['owner_id']] = $row['owner_name'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
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
    <div class="container">
        <h2>Select Owner</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="owner_id">Select Owner:</label>
            <select name="owner_id" id="owner_id" required>
                <option value="">Select Owner</option>
                <?php
                foreach ($owner_names as $owner_id => $owner_name) {
                    echo "<option value='$owner_id'>$owner_name</option>";
                }
                ?>
            </select>
            <button type="submit">View Details</button>
        </form>
    </div>
    <a href="owner_dashboard.php" class="back-button">Return Home</a>
</body>
</html>
