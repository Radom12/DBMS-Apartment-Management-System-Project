<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        <form method="post" action="process_signup.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
            <label for="building_name">Building Name:</label>
            <select id="building_name" name="building_name" required>
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

                // Query to retrieve buildings
                $query = "SELECT building_name FROM apartment";

                // Execute query
                $result = $conn->query($query);

                // Check if any buildings found
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["building_name"] . "'>" . $row["building_name"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No buildings found</option>";
                }

                // Close connection
                $conn->close();
                ?>
            </select>
            <label for="owner_name">Owner Name:</label>
            <select id="owner_name" name="owner_name" required>
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

                // Query to retrieve owners
                $query = "SELECT CONCAT(first_name, ' ', last_name) AS owner_name FROM owner";

                // Execute query
                $result = $conn->query($query);

                // Check if any owners found
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["owner_name"] . "'>" . $row["owner_name"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No owners found</option>";
                }

                // Close connection
                $conn->close();
                ?>
            </select>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Sign Up">
        </form>
    </div>
</body>
</html>
