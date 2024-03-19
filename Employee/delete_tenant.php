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

if (isset($_GET['tenant_id']) && !empty($_GET['tenant_id'])) {
    $tenant_id = $_GET['tenant_id'];

    $sql = "DELETE FROM tenant WHERE tenant_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $tenant_id);

        if ($stmt->execute()) {
            header("Location: viewtenant.php");
            exit();
        } else {
            echo "Error executing the deletion query.";
        }

        $stmt->close();
    } else {
        echo "Error preparing the deletion query.";
    }
} else {
    echo "No tenant ID provided for deletion.";
}

$conn->close();
?>
