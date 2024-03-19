<?php
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

$request_query = "SELECT service_requests.request_id, CONCAT(tenant.first_name, ' ', tenant.last_name) AS tenant_name, 
                   tenant.email AS tenant_email, services.service_name, DATE_FORMAT(service_requests.requested_time, '%Y-%m-%d %H:%i:%s') AS requested_time
                   FROM service_requests
                   INNER JOIN tenant ON service_requests.tenant_id = tenant.tenant_id
                   INNER JOIN services ON service_requests.service_id = services.service_id";

$request_result = $conn->query($request_query);

// Function to send email with attachments (optional)
function sendEmailWithAttachment($to, $subject, $message, $file_path) {
    $headers = "From: noreply@yourdomain.com\r\n"; // Replace with your sender email address
    $headers .= "Content-Type: multipart/mixed; boundary=\"unique_boundary\"\r\n";

    // Message part
    $message_part = "--unique_boundary\r\n";
    $message_part .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $message_part .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $message_part .= $message . "\r\n";

    // Attachment part
    $attachment_part = "--unique_boundary\r\n";
    $attachment_part .= "Content-Type: application/pdf; name=\"invoice.pdf\"\r\n";
    $attachment_part .= "Content-Transfer-Encoding: base64\r\n";
    $attachment_part .= "Content-Disposition: attachment; filename=\"invoice.pdf\"\r\n\r\n";
    $attachment_part .= base64_encode(file_get_contents($file_path)) . "\r\n";

    $headers .= "--unique_boundary--\r\n";

    return mail($to, $subject, $message_part . $attachment_part, $headers);
}

// Function to generate invoice with additional details and styling (optional)
function generateInvoice($service_name, $amount, $tenant_email, $file_path = null) {
    $invoice_html = "<h2>Invoice</h2>";
    $invoice_html .= "<p><strong>Tenant Name:</strong> " . $tenant_email . "</p>"; // Replace with actual tenant name from database
    $invoice_html .= "<p><strong>Service:</strong> " . $service_name . "</p>";
    $invoice_html .= "<p><strong>Amount:</strong> $" . number_format($amount, 2, '.', ',') . "</p>";

    // Additional invoice details and styling (optional)
    // ...

    if ($file_path) {
        // Save the invoice HTML to PDF using a library like mPDF
        // ...
        // Send email with the generated PDF attachment
        sendEmailWithAttachment($tenant_email, "Invoice for Service Request", $invoice_html, $file_path);
    } else {
        // Send email with the invoice HTML content
        sendEmail($tenant_email, "Invoice for Service Request", $invoice_html);
    }
}

// Function to handle approval of service request
function approveRequest($request_id, $service_name, $amount, $tenant_email) {
    // Retrieve service cost from the database (if not provided explicitly)
    $cost_query = "SELECT cost FROM services WHERE service_name = '$service_name'";
    $cost_result = $conn->query($cost_query);

    if ($cost_result->num_rows > 0) {
        $cost_row = $cost_result->fetch_assoc();
        $amount = $cost_row['cost']; // Use the retrieved cost
    } else {
        // Handle case where service cost is not found
        // Handle case where service cost is not found:
        // 1. Log the error for tracking purposes:
            error_log("Service cost not found for service: $service_name. Request ID: $request_id");

            // 2. Display an error message to the user:
            echo "<script>alert('Service cost not found. Please contact the administrator to update the service cost in the database.');</script>";
    
            // 3. (Optional) Prevent further processing:
            return; // Exit the function without generating invoice or sending email
        }
    
        // Generate invoice (using the retrieved cost)
        generateInvoice($service_name, $amount, $tenant_email);
    
        // Update database to mark service request as approved
        $update_query = "UPDATE service_requests SET status = 'Approved' WHERE request_id = $request_id";
        if ($conn->query($update_query) === TRUE) {
            echo "Service request approved successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    
    // Function to handle denial of service request
    function denyRequest($tenant_email) {
        sendEmail($tenant_email, "Service Request Denied", "Your service request has been denied.");
    }
    
    ?>
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Service Requests</title>
    <style>
        p {
  background-image: url('../images/1.jpg');
}
body {
            font-family: Arial, sans-serif;
            background-color: #56cdc2;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-approve {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .btn-deny {
            background-color: #f44336;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Service Requests</h2>
        <table>
            <table background="/wp-content/uploads/wov.png">
            <tr>
                <th>Request ID</th>
                <th>Tenant Name</th>
                <th>Service Name</th>
                <th>Requested Time</th>
                <th>Action</th>
            </tr>
            <?php
            if ($request_result->num_rows > 0) {
                while ($row = $request_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["request_id"] . "</td>";
                    echo "<td>" . $row["tenant_name"] . "</td>";
                    echo "<td>" . $row["service_name"] . "</td>";
                    echo "<td>" . $row["requested_time"] . "</td>";
                    echo "<td>";
                    // Include request ID, service name, and email as URL parameters
                    echo "<a href='approve_request.php?request_id=" . $row["request_id"] . "&service_name=" . $row["service_name"] . "&tenant_email=" . $row["tenant_email"] . "' class='btn btn-approve'>Approve</a>";
                    echo "<a href='deny_request.php?tenant_email=" . $row["tenant_email"] . "' class='btn btn-deny'>Deny</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No service requests found</td></tr>";
            }
            ?>
        </table>
        
    </div>
</body>
</html>

    
    