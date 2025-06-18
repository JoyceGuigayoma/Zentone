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
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input['consent'])) {
    echo json_encode(["error" => "Consent value not provided"]);
    exit;
}

$email = $_SESSION['email'];
$consent = (int)$input['consent'];

$stmt = $conn->prepare("UPDATE users SET consent = ? WHERE email = ?");
$stmt->bind_param("is", $consent, $email);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Database update failed"]);
}

$stmt->close();
$conn->close();
?>
