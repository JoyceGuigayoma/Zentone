<?php
session_start();
header("Content-Type: application/json");

$host = "localhost";
$username = "root";
$password = "";
$database = "zentonedb";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

if (!isset($_SESSION['email'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$email = $_SESSION['email'];

$encryption_key = hash('sha256', 'ZentoneEmotionEncryptKey_2025');
$iv = substr(hash('sha256', 'ZentoneIVSecret_2025'), 0, 16);

function decrypt_emotion($encrypted_emotion, $key, $iv) {
    return openssl_decrypt($encrypted_emotion, 'AES-256-CBC', $key, 0, $iv);
}

$query = "SELECT emotion, source, timestamp FROM emotion_logs WHERE email = ? ORDER BY timestamp DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$logs = [];
while ($row = $result->fetch_assoc()) {
    $decrypted_emotion = decrypt_emotion($row['emotion'], $encryption_key, $iv);
    $logs[] = [
        "emotion" => $decrypted_emotion,
        "source" => $row["source"],
        "timestamp" => $row["timestamp"]
    ];
}

echo json_encode($logs);

$stmt->close();
$conn->close();
?>
