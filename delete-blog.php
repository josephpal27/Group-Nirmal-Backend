<?php
include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid blog ID.";
    exit;
}

$id = intval($_GET['id']);

// Get image file name
$res = mysqli_query($conn, "SELECT image FROM blogs WHERE id = $id");
$blog = mysqli_fetch_assoc($res);

// Delete image file from server
if ($blog && !empty($blog['image'])) {
    $path = 'uploads/blogs/' . $blog['image'];
    if (file_exists($path)) {
        unlink($path);
    }
}

// Delete blog from database
mysqli_query($conn, "DELETE FROM blogs WHERE id = $id");

// Redirect
header("Location: dashboard.php?page=blogs");
exit;
?>
