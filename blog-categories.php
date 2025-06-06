<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/categories/";
        $image_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $insert = "INSERT INTO blog_categories (name, image) VALUES ('$name', '$image_name')";
        mysqli_query($conn, $insert);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch categories
$query = "SELECT * FROM blog_categories ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blog Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .table-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
  </style>
</head>
<body>
<div class="container mt-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Blog Categories</h2>
    <button class="btn btn-success" onclick="toggleView('form')">
      <i class="bi bi-plus-lg"></i> Add Category
    </button>
  </div>

  <!-- Add Category Form (hidden by default) -->
  <div id="addCategoryForm" style="display: none;">
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3">Add New Blog Category</h5>
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Category Name" required>
          </div>
          <div class="mb-3">
            <input type="file" name="image" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-secondary ms-2" onclick="toggleView('table')">Cancel</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Blog Categories Table -->
  <div id="categoryTable">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">All Blog Categories</h5>
        <table class="table table-bordered table-striped mt-3">
          <thead class="table-dark">
            <tr>
              <th>Name</th>
              <th>Image</th>
              <th style="width: 160px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><img src="uploads/categories/<?php echo htmlspecialchars($row['image']); ?>" class="table-img" alt="Category Image"></td>
                <td>
                  <a href="edit-category.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                  <a href="delete-category.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
  function toggleView(view) {
    const form = document.getElementById('addCategoryForm');
    const table = document.getElementById('categoryTable');
    if (view === 'form') {
      form.style.display = 'block';
      table.style.display = 'none';
    } else {
      form.style.display = 'none';
      table.style.display = 'block';
    }
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
