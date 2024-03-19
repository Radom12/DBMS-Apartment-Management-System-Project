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

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get input data
    $first_name = sanitize_input($_POST["first_name"]);
    $last_name = sanitize_input($_POST["last_name"]);
    $email = sanitize_input($_POST["email"]);
    $phone_number = sanitize_input($_POST["phone_number"]);
    $age = sanitize_input($_POST["age"]);
    $dob = sanitize_input($_POST["dob"]);
    $owner_id = sanitize_input($_POST["owner_id"]);

    // Prepare SQL statement to insert tenant details
    $stmt = $conn->prepare("INSERT INTO tenant (first_name, last_name, email, phone_number, age, dob, owner_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisi", $first_name, $last_name, $email, $phone_number, $age, $dob, $owner_id);

    // Execute the prepared statement
    if ($stmt->execute() === TRUE) {
        echo "Tenant created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close prepared statement
    $stmt->close();
}

// Query to fetch employee names for dropdown menu
$employee_query = "SELECT employee_id, first_name, last_name FROM employee";

// Execute query
$employee_result = $conn->query($employee_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tenant</title>
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
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
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
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700");
        * {
            margin: 0;
            padding: 0;
            outline: none;
            border: none;
            text-decoration: none;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body {
            background: #dfe9f5;
        }
        .container {
            display: flex;
        }
        nav {
            position: relative;
            top: 0;
            bottom: 0;
            height: 100vh;
            left: 0;
            background: #fff;
            width: 280px;
            overflow: hidden;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
        }
        .logo {
            text-align: center;
            display: flex;
            margin: 10px 0 0 10px;
        }
        .logo img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }
        .logo span {
            font-weight: bold;
            padding-left: 15px;
            font-size: 18px;
            text-transform: uppercase;
        }
        .sidebar-buttons {
            margin-top: 20px;
            padding: 0 20px;
        }
        .sidebar-buttons button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            background: #fff;
            border-radius: 10px;
            text-align: left;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .sidebar-buttons button:hover {
            background: #eee;
        }
        .sidebar-buttons button i {
            margin-right: 10px;
        }
        /* Your existing CSS styles */

        .container {
    display: flex;
    align-items: flex-start; /* Align items at the start of the flex container */
}

nav {
    position: relative;
    /* Remove the fixed height and overflow properties */
    /* height: 100vh;
    overflow: hidden; */
    width: 280px;
    background: #fff;
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
}

.mySlides {
    display: none;
}

.fade {
    -webkit-animation-name: fade;
    -webkit-animation-duration: 1.5s;
    animation-name: fade;
    animation-duration: 1.5s;
}

@-webkit-keyframes fade {
    from {opacity: .4} 
    to {opacity: 1}
}

@keyframes fade {
    from {opacity: .4} 
    to {opacity: 1}
}

.numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
}

.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    margin-top: -22px;
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
}

.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

.prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.8);
}

/* Style the dots */
.dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}

.active, .dot:hover {
    background-color: #717171;
}
    </style>
</head>
<body>
    <h2>Create Tenant</h2>
    <form method="post" action="sendemail.php">
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone_number">Phone Number:</label>
    <input type="text" id="phone_number" name="phone_number" required>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required>

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required>

    <label for="owner_id">Employee:</label>
    <select id="owner_id" name="owner_id" required>
        <?php
        // Output employee names in dropdown menu
        while($row = $employee_result->fetch_assoc()) {
            echo "<option value='" . $row["employee_id"] . "'>" . $row["first_name"] . " " . $row["last_name"] . "</option>";
        }
        ?>
    </select>

    <!-- You can include hidden input fields here to pass additional data if needed -->

    <input type="submit" value="Create Tenant">
</form>


    <script>
             //  for Home button
        document.getElementById("homeBtn").addEventListener("click", function() {
            window.location.href = "home.php"; // Replace "home.php" with your actual URL
        });

        // Functionality for Tenant Details button
        document.getElementById("tenantDetailsBtn").addEventListener("click", function() {
            window.location.href = "viewtenant.php"; // Replace "tenant_details.php" with your actual URL
        });

        // Functionality for Parking button
        document.getElementById("parkingBtn").addEventListener("click", function() {
            window.location.href = "parking.php"; // Replace "parking.php" with your actual URL
        });

        // Functionality for Swimming Pool button
        document.getElementById("swimmingPoolBtn").addEventListener("click", function() {
            window.location.href = "swimming_pool.php"; // Replace "swimming_pool.php" with your actual URL
        });

        // Functionality for Log out button
        document.getElementById("logoutBtn").addEventListener("click", function() {
            window.location.href = "../index.html"; // Replace "logout.php" with your actual URL
        });
        document.getElementById("homeBtn").addEventListener("click", function() {
        window.location.href = "home.php"; // Replace "home.php" with your actual URL
    });

    // Functionality for Allot Flat button
    document.getElementById("allotFlatBtn").addEventListener("click", function() {
        window.location.href = "createroom.php"; // Replace "createroom.php" with your actual URL
    });

    // Functionality for View Complaints button
    document.getElementById("viewComplaintsBtn").addEventListener("click", function() {
        window.location.href = "viewcomplaints.php"; // Replace "viewcomplaints.php" with your actual URL
    });

    // Functionality for Fee Payment button
    document.getElementById("feePaymentBtn").addEventListener("click", function() {
        // Add functionality for Fee Payment button
    });

    // Functionality for Log out button
    document.getElementById("logoutBtn").addEventListener("click", function() {
        window.location.href = "../index.html"; // Replace "logout.php" with your actual URL
    });
    var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}

    </script>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
