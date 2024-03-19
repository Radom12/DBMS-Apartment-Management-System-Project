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
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            text-align: center;
            color: #333;
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
            position: absolute;
            top: 70px;
            right: 270px;
            background-color: #dc3545;
            color: #fff;
            padding: 10px 25px;
            border: none;
            border-radius: 15px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .export-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .export-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, Owner!</h2>
        <h3>Please select an option:</h3>
        <ul>
            <li><a href="viewempl.php">View Employees</a></li>
            <li><a href="complaintcount.php">Count Statistics</a></li>
            <li><a href="createemployee.php">Create Employee</a></li>
            <li><a href="roomdetails.php">Display Details of Rooms</a></li>
            <li><a href="feesrecieved.php">Display Details of Fee Payment's</a></li>
        </ul>
        <button class="export-btn" onclick="exportToCSV()">Export to CSV</button>
        <a href="../index.html" class="logout-btn">Logout</a>
    </div>

    <script>
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob([csv], { type: "text/csv" });

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();
        }

        function exportToCSV() {
            var csv = 'Dashboard Content, Goes, Here'; // Example content

            // File name
            var filename = 'dashboard.csv';

            downloadCSV(csv, filename);
        }
    </script>
</body>
</html>
