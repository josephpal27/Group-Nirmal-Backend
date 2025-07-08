<?php
include 'db.php';
header('Content-Type: application/json'); // Return JSON for AJAX

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!$conn) {
        echo json_encode(["status" => "error", "message" => "Database connection failed"]);
        exit;
    }

    // Sanitize and fetch form inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $company_name = trim($_POST['company_name']);
    $phone_number = trim($_POST['phone_number']);

    // Prepare SQL statement for 'contacts' table
    $stmt = $conn->prepare("INSERT INTO contact_form (name, email, company_name, phone_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $company_name, $phone_number);

    // Execute and return response
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Thank you! We have received your message."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error saving data. Please try again."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>

