<?php
include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid ID.";
    exit;
}

$id = intval($_GET['id']);

// Fetch existing category
$query = "SELECT * FROM blog_categories WHERE id = $id";
$result = mysqli_query($conn, $query);
$category = mysqli_fetch_assoc($result);

if (!$category) {
    echo "Category not found.";
    exit;
}

// Update on form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $image = $category['image']; // default to existing image

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/categories/";
        $image_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $image_name;
        }
    }

    $update = "UPDATE blog_categories SET name = '$name', image = '$image' WHERE id = $id";
    mysqli_query($conn, $update);

    header("Location: dashboard.php?page=blog-categories");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Blog Category</title>
  <!-- Link to Canonical -->
  <!-- <link rel="canonical" href="https://groupnirmal.com/edit-category.php"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
  <h2>Edit Category</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="name" class="form-label">Category Name</label>
      <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($category['name']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">Category Image</label><br>
      <img src="uploads/categories/<?= htmlspecialchars($category['image']) ?>" width="100" class="mb-2"><br>
      <input type="file" class="form-control" name="image">
    </div>
    <button type="submit" class="btn btn-primary">Update Category</button>
    <a href="dashboard.php?page=blog-categories" class="btn btn-secondary">Cancel</a>
  </form>
</body>
</html>
