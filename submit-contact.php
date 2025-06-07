<?php
include 'db.php';
header('Content-Type: application/json'); // Return JSON for AJAX

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!$conn) {
        echo json_encode(["status" => "error", "message" => "DB connection failed"]);
        exit;
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Thank you! We'll contact you soon."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error saving data."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
