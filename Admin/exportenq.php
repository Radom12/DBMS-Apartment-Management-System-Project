<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_management";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$owner_query = "SELECT COUNT(*) AS total_owners FROM owner";
$owner_result = $conn->query($owner_query);

$tenant_query = "SELECT COUNT(*) AS total_tenants FROM tenant";
$tenant_result = $conn->query($tenant_query);

$employee_query = "SELECT COUNT(*) AS total_employees FROM employee";
$employee_result = $conn->query($employee_query);

$parking_slot_query = "SELECT COUNT(*) AS total_slots FROM parking_slot";
$parking_slot_result = $conn->query($parking_slot_query);

$enquiry_query = "SELECT * FROM enquiries";
$enquiry_result = $conn->query($enquiry_query);

$admin_query = "SELECT * FROM admin";
$admin_result = $conn->query($admin_query);

$csv_content = "Admin ID,Admin Username,Admin Email,Admin Phone Number,";
$csv_content .= "Total Owners,Total Tenants,Total Employees,Total Parking Slots\n";

if ($admin_result->num_rows > 0) {
    $admin_row = $admin_result->fetch_assoc();
    $csv_content .= $admin_row["admin_id"] . ",";
    $csv_content .= $admin_row["username"] . ",";
    $csv_content .= $admin_row["email"] . ",";
    $csv_content .= $admin_row["phone_number"] . ",";
} else {
    $csv_content .= "N/A,N/A,N/A,N/A,";
}

$row = $owner_result->fetch_assoc();
$csv_content .= $row["total_owners"] . ",";

$row = $tenant_result->fetch_assoc();
$csv_content .= $row["total_tenants"] . ",";

$row = $employee_result->fetch_assoc();
$csv_content .= $row["total_employees"] . ",";

$row = $parking_slot_result->fetch_assoc();
$csv_content .= $row["total_slots"] . "\n";

// Add Enquiry Details to CSV Content
if ($enquiry_result->num_rows > 0) {
    $csv_content .= "Enquiry ID,Name,Email,Contact,Enquiry Date\n";
    while ($enquiry_row = $enquiry_result->fetch_assoc()) {
        $csv_content .= $enquiry_row["enquiry_id"] . ",";
        $csv_content .= $enquiry_row["name"] . ",";
        $csv_content .= $enquiry_row["email"] . ",";
        $csv_content .= $enquiry_row["contact"] . ",";
        $csv_content .= $enquiry_row["enquiry_date"] . "\n";
    }
}

$conn->close();

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="apartment_totals_with_enquiries.csv"');

echo $csv_content;
?>
