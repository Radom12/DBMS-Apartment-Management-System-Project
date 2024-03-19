<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../images/1.jpg'); /* Change 'background_image.jpg' to your image path */
            background-size: cover;
            background-repeat: no-repeat;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Add a semi-transparent white background for better readability */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f9f9f9; /* Set a light gray background color for the table */
            border: 1px solid #ddd; /* Set a light gray border for the table */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2; /* Set a slightly darker background color for table headers */
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            display: block;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #0056b3;
        }
        .logout-btn {
            display: block;
            margin-top: 20px;
            background-color: #dc3545;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 15px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-align: center; /* Center the logout button */
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, Tenant!</h2>
        <h3>Please select an option:</h3>
        <ul>
            <li><a href="complaintraise.php">Raise Complaints</a></li>
            <li><a href="maintanencefee.php">Pay Maintenance Fee</a></li>
            <li><a href="parkingslotallot.php">Manage Parking Slots</a></li>
            <li><a href="requestservice.php">Book Service</a></li>
        </ul>
        <a href="../index.html" class="logout-btn">Logout</a>
    </div>
</body>
</html>
