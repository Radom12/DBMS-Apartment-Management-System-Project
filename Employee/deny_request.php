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

// Get tenant email from URL parameters
$tenant_email = $_GET['tenant_email'];

// Deny service request and send denial email
denyRequest($tenant_email);

// Function to send denial email to the tenant
function denyRequest($tenant_email) {
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
        $mail->Subject = 'Service Request Denied';
        $mail->Body = "Your service request for '$service_name' has been denied.";
        
        $mail->send();
        echo 'Denial email sent successfully.';
    } catch (Exception $e) {
        echo "Denial email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    // Redirect back to viewrequest.php after sending the denial email
    header("Location: viewrequest.php");
    exit; // Stop executing the script after redirection
}

// Close database connection
$conn->close();
?>
