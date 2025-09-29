<?php
session_start();
header('Content-Type: application/json');

// DB config
include_once('config.php');

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit;
}

// Read input
$input = json_decode(file_get_contents('php://input'), true);
$key = trim($input['key'] ?? '');

if (!$key) {
    echo json_encode(['success' => false, 'error' => 'Reg No is required.']);
    exit;
}

// Fetch user by key
$stmt = $pdo->prepare("SELECT * FROM hnde_rh_users WHERE registration_number = ?");
$stmt->execute([$key]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'error' => 'Invalid Registration Number.']);
    exit;
}

if ($user['status'] === 'pending') {
    echo json_encode(['success' => false, 'status' => 'pending']);
    exit;
}

if ($user['status'] === 'allowed') {
    echo json_encode(['success' => true, 'data' => $user]);
    exit;
}

if ($user['status'] === 'allowed') {
    $_SESSION['user'] = $user; 
     echo json_encode(['success' => true]);
    exit;
}


// Unknown status fallback
echo json_encode(['success' => false, 'error' => 'Unknown status.']);
