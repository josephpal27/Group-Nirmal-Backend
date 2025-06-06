<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    if (!empty($name) && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/categories/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $insert = "INSERT INTO blog_categories (name, image) VALUES ('$name', '$image_name')";
            if (mysqli_query($conn, $insert)) {
                $message = "<div class='alert alert-success'>Category added successfully.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Database error: Unable to add category.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Error uploading image.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Please fill all fields and upload an image.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Blog Category</h2>
    <?php echo $message; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Category Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
       <a href="dashboard.php?page=blog-categories" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
