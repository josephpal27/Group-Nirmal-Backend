<?php
include 'db.php'; // Make sure you are connecting to the DB

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert into the database
    $query = "INSERT INTO contact_form (name, email, subject, message) 
              VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $query)) {
        // Redirect after success (can also show a thank-you message)
        header("Location: index.html");
        exit;
    } else {
        echo "Error saving your message.";
    }
} else {
    echo "Invalid request.";
}
?>
