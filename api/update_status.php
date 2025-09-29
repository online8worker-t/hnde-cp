<?php
header('Content-Type: application/json');

// Database credentials
include_once('config.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Get POST data
$unique_key = $_POST['unique_key'] ?? '';
$status = $_POST['status'] ?? '';

// Validate inputs
if (empty($unique_key) || empty($status)) {
    echo json_encode(['success' => false, 'message' => 'Missing unique key or status.']);
    $conn->close();
    exit();
}

// Prepare and execute the update statement
$stmt = $conn->prepare("UPDATE hnde_rh_users SET status = ? WHERE unique_key = ?");
$stmt->bind_param("ss", $status, $unique_key);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating record: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
