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

// Fetch details of all tenants
$tenant_query = "SELECT * FROM tenant";
$tenant_result = $conn->query($tenant_query);

// Fetch details of all service requests
$request_query = "SELECT service_requests.request_id, CONCAT(tenant.first_name, ' ', tenant.last_name) AS tenant_name, services.service_name, DATE_FORMAT(service_requests.requested_time, '%Y-%m-%d %H:%i:%s') AS requested_time
                  FROM service_requests
                  INNER JOIN tenant ON service_requests.tenant_id = tenant.tenant_id
                  INNER JOIN services ON service_requests.service_id = services.service_id";
$request_result = $conn->query($request_query);

// Function to output CSV content
function outputCSV($data) {
    $output = fopen("php://output", "w");
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
}

// Prepare data for CSV export
$csv_data = array();

// Add header row for tenants
$csv_data[] = array('Tenant ID', 'First Name', 'Last Name', 'Email', 'Phone Number', 'Age', 'Date of Birth');

// Add tenant details to CSV data
if ($tenant_result->num_rows > 0) {
    while ($row = $tenant_result->fetch_assoc()) {
        $csv_data[] = array($row['tenant_id'], $row['first_name'], $row['last_name'], $row['email'], $row['phone_number'], $row['age'], $row['dob']);
    }
}

// Add header row for service requests
$csv_data[] = array('Request ID', 'Tenant Name', 'Service Name', 'Requested Time');

// Add service request details to CSV data
if ($request_result->num_rows > 0) {
    while ($row = $request_result->fetch_assoc()) {
        $csv_data[] = array($row['request_id'], $row['tenant_name'], $row['service_name'], $row['requested_time']);
    }
}

// Set headers for CSV file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="apartment_data.csv"');

// Output CSV data
outputCSV($csv_data);

// Close database connection
$conn->close();
?>
