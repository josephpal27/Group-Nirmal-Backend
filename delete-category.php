<?php
include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid ID.";
    exit;
}

$id = intval($_GET['id']);

// Get current image to optionally delete from folder
$res = mysqli_query($conn, "SELECT image FROM blog_categories WHERE id = $id");
$category = mysqli_fetch_assoc($res);

// Delete image file (optional but recommended)
if ($category && !empty($category['image'])) {
    $imgPath = 'uploads/categories/' . $category['image'];
    if (file_exists($imgPath)) {
        unlink($imgPath);
    }
}

// Delete from database
mysqli_query($conn, "DELETE FROM blog_categories WHERE id = $id");

// Redirect back
header("Location: dashboard.php?page=blog-categories");
exit;
