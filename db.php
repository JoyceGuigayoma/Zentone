<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "zentonedb";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$encryption_key = 'ZentoneEmotionEncryptKey_2025'; 
$iv = substr(hash('sha256', 'ZentoneIVSecret_2025'), 0, 16); 

function encrypt_emotion($emotion, $key, $iv) {
    return openssl_encrypt($emotion, 'AES-256-CBC', $key, 0, $iv);
}

function decrypt_emotion($encrypted, $key, $iv) {
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
}
if (isset($_POST["login"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $name, $user_email, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["user_name"] = $name;
            $_SESSION["email"] = $user_email;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found.";
    }
    $stmt->close();
}
if (isset($_POST["signup"])) {
    $fullName = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullName, $email, $hashedPassword);
   
    if ($stmt->execute()) {
    echo "<script>
        alert('Account created successfully!');
        window.location.href = 'index.php'; // Change this to your actual login file
    </script>";
    }
    
    $stmtif->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['email'])) {
    $input = json_decode(file_get_contents("php://input"), true);

    $emotion = encrypt_emotion($input['emotion'], $encryption_key, $iv);
    $source = $input['source'];
    $email = $_SESSION['email'];

    $stmt = $conn->prepare("INSERT INTO emotion_logs (email, emotion, source) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $emotion, $source);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Failed to insert"]);
    }
    $stmt->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT emotion, source, timestamp FROM emotion_logs WHERE email = ? ORDER BY timestamp DESC");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $row['emotion'] = decrypt_emotion($row['emotion'], $encryption_key, $iv);
        $logs[] = $row;
    }

    echo json_encode($logs);
    $stmt->close();
}

$conn->close();
?>
