<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// Check role
$role = $_SESSION['admin_role'] ?? '';
if (!in_array($role, ['admin', 'blog'])) {
    echo "<div class='container mt-5'><h4>Unauthorized Access</h4></div>";
    exit();
}

// Fetch blogs with category name using JOIN
$query = "SELECT blogs.id, blogs.title, blogs.image, blog_categories.name AS category_name
          FROM blogs
          LEFT JOIN blog_categories ON blogs.category_id = blog_categories.id
          ORDER BY blogs.id DESC";

$result = mysqli_query($conn, $query);
?>

<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Blogs</h2>
    <?php if ($role === 'admin' || $role === 'blog'): ?>
      <a href="dashboard.php?page=add-blog" class="btn btn-primary">+ Add Blog</a>
    <?php endif; ?>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>Image</th>
          <th>Title</th>
          <th>Category</th>
          <th style="width: 200px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td>
                <?php if (!empty($row['image'])): ?>
                  <img src="uploads/blogs/<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                <?php else: ?>
                  <span>No Image</span>
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($row['title']); ?></td>
              <td><?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></td>
              <td>
                <a href="view-blog.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">View</a>

                <?php if ($role === 'admin' || $role === 'blog'): ?>
                  <a href="edit-blog.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                  <a href="delete-blog.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-center">No blogs found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
