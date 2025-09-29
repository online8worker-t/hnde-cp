<?php
header('Content-Type: application/json');
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');

$response = [
    'success' => false,
    'message' => 'An unknown error occurred.',
    'key' => null
];

// Database credentials
include_once('config.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $response['message'] = "Connection failed: " . $conn->connect_error;
    echo json_encode($response);
    exit();
}

// Data validation function
function validate_data($data) {
    $errors = [];

    // Registration number validation
    if (empty($data['registration_number'])) {
        $errors[] = 'Registration number is required.';
    } elseif (!preg_match('/^(?:[A-Z]{3}\/[A-Z]{2}\/[0-9]{4}\/[A-Z]\/[0-9]{3}|[A-Z]{3}\/[A-Z]{3}\/[0-9]{4}\/[A-Z]\/[0-9]{3})$/', $data['registration_number'])) {
        $errors[] = 'Invalid registration number format.';
    }

    // Full name validation
    if (empty($data['full_name'])) {
        $errors[] = 'Full name is required.';
    }

    // Email validation
    // if (empty($data['email'])) {
    //     $errors[] = 'Transcation ID is required.';
    // }

    // // WhatsApp number validation
    // if (empty($data['whatsapp'])) {
    //     $errors[] = 'WhatsApp number is required.';
    // } elseif (!preg_match('/^07[0-9]{8}$/', $data['whatsapp'])) {
    //     $errors[] = 'Invalid WhatsApp number format. Use 07XXXXXXXX.';
    // }

    // File upload validation
    if (empty($_FILES['payment_receipt']) || $_FILES['payment_receipt']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Payment receipt file is required.';
    }

    return $errors;
}

// Get form data
$formData = [
    'registration_number' => $_POST['registration_number'] ?? '',
    'full_name' => $_POST['full_name'] ?? '',
    'course' => $_POST['course'] ?? '',
    'email' => $_POST['tr_id'] ?? '',
    'whatsapp' => $_POST['whatsapp'] ?? ''
];

$validationErrors = validate_data($formData);

if (!empty($validationErrors)) {
    $response['message'] = implode(' ', $validationErrors);
    echo json_encode($response);
    $conn->close();
    exit();
}

// Generate a unique key
function generate_unique_key($segments = 4, $segmentLength = 4) {
    $key = '';

    for ($i = 0; $i < $segments; $i++) {
        $segment = strtoupper(bin2hex(random_bytes($segmentLength / 2)));
        $key .= ($i > 0 ? '-' : '') . $segment;
    }

    return $key;
}


$unique_key = generate_unique_key();
$target_dir = "uploads/";

// Create uploads directory if it doesn't exist
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Allowed file types and MIME types
$allowed_extensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];
$allowed_mime_types = [
    'application/pdf',
    'image/jpeg',
    'image/png',
    'image/gif'
];

// Max file size (in bytes)
$max_file_size = 10 * 1024 * 1024; // 3 MB

$file = $_FILES["payment_receipt"];
$file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
$file_mime_type = mime_content_type($file["tmp_name"]);
$file_size = $file["size"];

// Validate file size
if ($file_size > $max_file_size) {
    $response['message'] = 'File size must be less than 10MB.';
    echo json_encode($response);
    $conn->close();
    exit();
}

// Validate extension and MIME type
if (!in_array($file_extension, $allowed_extensions) || !in_array($file_mime_type, $allowed_mime_types)) {
    $response['message'] = 'Only PDF and image files (JPG, PNG, GIF) are allowed.';
    echo json_encode($response);
    $conn->close();
    exit();
}

// Rename file with unique key
$new_file_name = $unique_key . '.' . $file_extension;
$target_file = $target_dir . $new_file_name;

// Move uploaded file
if (move_uploaded_file($file["tmp_name"], $target_file)) {
    $payment_receipt_path = $target_file;
} else {
    $response['message'] = 'Sorry, there was an error uploading your file.';
    echo json_encode($response);
    $conn->close();
    exit();
}
// ==================================================


// Prepare and bind SQL statement
$stmt = $conn->prepare("INSERT INTO hnde_rh_users (unique_key, registration_number, full_name, course, email, whatsapp, payment_receipt_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("sssssss", $unique_key, $formData['registration_number'], $formData['full_name'], $formData['course'], $formData['email'], $formData['whatsapp'], $payment_receipt_path);

// Execute the statement
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Registration successful!';
    $response['key'] = $unique_key;
} else {
    $response['message'] = "Error: " . $stmt->error;
    // Clean up uploaded file if database insertion fails
    unlink($target_file);
}

$stmt->close();
$conn->close();
echo json_encode($response);
?>