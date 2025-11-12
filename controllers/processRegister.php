<?php
header('Content-Type: application/json; charset=utf-8');

// Start output buffering to capture any unexpected output (PHP warnings, echoes)
ob_start();

/**
 * Send JSON response ensuring any buffered output is attached for debugging.
 * Exits after sending.
 */
function send_json($payload, $httpStatus = 200) {
    // collect any buffered output
    $buffer = '';
    if (ob_get_length() !== false) {
        $buffer = ob_get_clean();
    }
    if ($buffer !== '') {
        // attach raw output to payload for easier debugging
        if (!isset($payload['errors'])) $payload['errors'] = [];
        $payload['errors'][] = "Raw output: " . trim($buffer);
    }
    http_response_code($httpStatus);
    echo json_encode($payload);
    exit;
}

// Database connection
$host = getenv('POSTGRES_HOST') ?: 'postgres_db';
$port = getenv('POSTGRES_PORT') ?: '5432';
$db = getenv('POSTGRES_DB');
$user = getenv('POSTGRES_USER');
$pass = getenv('POSTGRES_PASSWORD');

if (!$db || !$user || !$pass) {
    send_json([
        'success' => false,
        'message' => 'Database configuration is missing.',
        'errors' => ['Database configuration is missing.']
    ], 500);
}

// PostgreSQL connection
$dsn = "pgsql:host=$host;port=$port;dbname=$db;";
try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    send_json([
        'success' => false,
        'message' => 'DB connection error.',
        'errors' => ['DB connection error.']
    ], 500);
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = trim($data['password'] ?? '');

// validations
$errors = [];
if (empty($name) || !preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/', $name)) {
    $errors[] = 'Invalid name.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
}
if (strlen($password) < 8) {
    $errors[] = 'The password must be at least 8 characters long.';
}
if (!empty($errors)) {
    send_json([
        'success' => false,
        'message' => 'Validation errors.',
        'errors' => $errors
    ], 400);
}

// Check if user already exists
$stmt = $pdo->prepare("SELECT 1 FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    send_json([
        'success' => false,
        'message' => 'This email has already been registered.',
        'errors' => ['This email has already been registered.']
    ], 409);
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$role = 'customer';

try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $hashedPassword, $role]);
    send_json([
        'success' => true,
        'message' => 'User registered successfully.'
    ], 201);
} catch (PDOException $e) {
    send_json([
        'success' => false,
        'message' => 'Error saving user.',
        'errors' => ['Error saving user.']
    ], 500);
}
?>
