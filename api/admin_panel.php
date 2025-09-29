<?php
header('Content-Type: application/json');

// Database credentials
include_once('config.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => "Connection failed: " . $conn->connect_error]);
    exit();
}

// SQL query to select all data from the registrations table
$sql = "SELECT id, unique_key, registration_number, full_name, course, email, payment_receipt_path, status FROM hnde_rh_users ORDER BY id DESC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // Fetch all rows and add them to the data array
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the connection and return the data as JSON
$conn->close();
echo json_encode($data);
?>
