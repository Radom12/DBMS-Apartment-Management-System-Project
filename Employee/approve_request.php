<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your actual password
$database = "apartment_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get request ID, service name, and tenant email from URL parameters
$request_id = $_GET['request_id'];
$service_name = $_GET['service_name'];
$tenant_email = $_GET['tenant_email'];

// Generate invoice and send approval email
approveRequest($conn, $request_id, $service_name, $tenant_email);

// Redirect back to viewrequest.php
header("Location: viewrequest.php");
exit(); // Ensure that no further code is executed after redirection

// Function to send approval email to the tenant
function approveRequest($conn, $request_id, $service_name, $tenant_email) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'example@gmail.com';  // Your Gmail address
        $mail->Password = ' ';  // Your Gmail password
        $mail->SMTPSecure = 'tls';  // Enable TLS encryption
        $mail->Port = 587;  // TCP port to connect to (TLS port)
        
        // Recipients
        $mail->setFrom('example@gmail.com', 'Trinity Apartment Suites');
        $mail->addAddress($tenant_email); // Tenant's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Service Request Approved';
        $mail->Body = "Your service request for '$service_name' has been approved. We will contact you shortly to schedule the service.";
        // You can attach the invoice PDF here if needed
        // $mail->addAttachment('path/to/invoice.pdf', 'invoice.pdf');

        $mail->send();
        echo 'Approval email sent successfully.';
    } catch (Exception $e) {
        echo "Approval email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Update database to mark service request as approved
    $update_query = "UPDATE service_requests SET status = 'Approved' WHERE request_id = $request_id";
    if ($conn->query($update_query) === TRUE) {
        echo "<br>Service request approved successfully.";
    } else {
        echo "<br>Error updating record: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
