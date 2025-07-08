<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $hashed_password, $role);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION["admin_id"] = $id;
        $_SESSION["admin_name"] = $name;
        $_SESSION["admin_role"] = $role;

        if ($role === 'admin') {
            header("Location: dashboard.php");
        } elseif ($role === 'blog') {
            header("Location: dashboard.php");  // Using same dashboard with role restriction
        } else {
            echo "Unauthorized role.";
        }
        exit();
    } else {
        echo "Invalid credentials. <a href='login.html'>Try again</a>";
    }
}
?>
