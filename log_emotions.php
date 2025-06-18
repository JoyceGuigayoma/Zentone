<?php
session_start();
header("Content-Type: application/json");

$host = "localhost";
$username = "root";
$password = "";
$database = "zentonedb";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    error_log("DB connection failed: " . $conn->connect_error);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}
if (!isset($_SESSION['email'])) {
    error_log("Not logged in. Session: " . print_r($_SESSION, true));
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$email = $_SESSION['email'];
error_log("User: $email");

$encryption_key = hash('sha256', 'ZentoneEmotionEncryptKey_2025');
$iv = substr(hash('sha256', 'ZentoneIVSecret_2025'), 0, 16);

function encrypt_emotion($emotion, $key, $iv) {
    return openssl_encrypt($emotion, 'AES-256-CBC', $key, 0, $iv);
}

function decrypt_emotion($encrypted, $key, $iv) {
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
}
$inputRaw = file_get_contents("php://input");
$input = json_decode($inputRaw, true);
if (!$input || !isset($input['emotion']) || !isset($input['source'])) {
    error_log("Invalid input JSON: $inputRaw");
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$emotion = encrypt_emotion($input['emotion'], $encryption_key, $iv);
$source = $input['source'];
$timestamp = date("Y-m-d H:i:s");

$stmt = $conn->prepare("INSERT INTO emotion_logs (email, emotion, source, timestamp) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $email, $emotion, $source, $timestamp);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    error_log("Failed to insert emotion: " . $stmt->error);
    echo json_encode(["error" => "Failed to insert: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
