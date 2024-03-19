<?php
// Establish MySQLi connection
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

// Function to check if a flat is already allotted
function isFlatAllotted($conn, $room_id) {
    $sql = "SELECT tenant_id FROM tenant WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    return $num_rows > 0;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenant_id = $_POST['tenant_id'];
    $room_id = $_POST['room_id'];

    // Update tenant's room
    $sql = "UPDATE tenant SET room_id = ? WHERE tenant_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $room_id, $tenant_id);

    if ($stmt->execute()) {
        echo "Room allotted successfully.";
    } else {
        echo "Error allotting room: " . $conn->error;
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allot Room</title>
    <style>
        table {
            border-collapse: collapse;
        }
        td {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .allotted {
            background-color: red;
        }
        .available {
            background-color: green;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Allot Room</h2>
    <table>
        <tbody>
            <?php
            // Loop through each flat (assuming 70 flats)
            for ($i = 1; $i <= 70; $i++) {
                // Check if the flat is already allotted
                $allotted = isFlatAllotted($conn, $i);
                $class = $allotted ? 'allotted' : 'available';
                // Output cell with appropriate class
                echo "<td class='$class' data-room-id='$i'></td>";
                // Start new row after every 10 cells
                if ($i % 10 == 0) {
                    echo "</tr><tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="tenant_id">Tenant ID:</label>
        <input type="text" id="tenant_id" name="tenant_id" required>
        <input type="hidden" id="room_id" name="room_id">
        <input type="submit" value="Allot Room">
    </form>

    <script>
        // Add event listeners to cells
        document.querySelectorAll('td.available').forEach(function(cell) {
            cell.addEventListener('click', function() {
                document.getElementById('room_id').value = this.getAttribute('data-room-id');
                // Highlight selected cell
                this.style.backgroundColor = 'blue';
                // Remove highlight from other cells
                document.querySelectorAll('td.available').forEach(function(otherCell) {
                    if (otherCell != cell) {
                        otherCell.style.backgroundColor = 'green';
                    }
                });
            });
        });
    </script>
</body>
</html>
