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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenant_id = $_POST["tenant_id"];
    $service_id = $_POST["service_id"];
    $amount_paid = $_POST["amount_paid"];
    $payment_date = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO maintenance_payment (tenant_id, service_id, amount_paid, payment_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iids", $tenant_id, $service_id, $amount_paid, $payment_date);

    if ($stmt->execute()) {
        header("Location: maintanencefee.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
