<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION["admin_id"] = $id;
        $_SESSION["admin_name"] = $name;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid credentials. <a href='login.html'>Try again</a>";
    }
}
?>
