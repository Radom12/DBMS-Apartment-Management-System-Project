<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = $_GET["type"];
$id = $_GET["id"];

if ($type === "employee") {
    $delete_query = "DELETE FROM employee WHERE employee_id = $id";
} elseif ($type === "tenant") {
    $delete_query = "DELETE FROM tenant WHERE tenant_id = $id";
} elseif ($type === "owner") {
    $delete_query = "DELETE FROM owner WHERE owner_id = $id";
}

if ($conn->query($delete_query) === TRUE) {
    header("Location: manage_data.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
