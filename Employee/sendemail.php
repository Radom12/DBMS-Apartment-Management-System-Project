<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

// Function to send email to tenant
function sendEmailToTenant($to_email, $username, $password) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'example@gmail.com'; // SMTP username
        $mail->Password   = ' '; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; // TCP port to connect to

        //Recipients
        $mail->setFrom('example@gmail.com', 'Trinity Apartment Suites');
        $mail->addAddress($to_email); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Welcome to our Apartment Management System';
        $mail->Body    = 'Dear Tenant,<br><br>'
                        . 'Welcome to our Apartment Management System! Here are your login credentials:<br><br>'
                        . '<strong>Username:</strong> ' . $username . '<br>'
                        . '<strong>Password:</strong> ' . $password . '<br><br>'
                        . 'Please keep your credentials secure. Enjoy your stay with us!<br><br>'
                        . 'Best regards,<br>'
                        . 'Apartment Management Team';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Retrieve newly created tenant's details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $age = $_POST["age"];
    $dob = $_POST["dob"];
    $owner_id = $_POST["owner_id"];

    // Use first name as username and set password to '12345'
    $username = strtolower($first_name); // Example: john
    $password = '12345';

    // Save the username and password to the database (assuming you have columns for them in the tenant table)
    // Note: You need to implement this part based on your database structure

    // Send email to the tenant
    if (sendEmailToTenant($email, $username, $password)) {
        echo "Tenant created successfully. Email sent.";
        // Redirect back to the create tenant page
        header("Location: createtenant.php");
        exit();
    } else {
        echo "Error sending email.";
    }
}
?>
