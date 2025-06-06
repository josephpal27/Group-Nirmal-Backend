<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

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
    <a href="dashboard.php?page=add-blog" class="btn btn-primary">+ Add Blog</a>
  </div>

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
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td>
            <img src="uploads/blogs/<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
          </td>
          <td><?php echo htmlspecialchars($row['title']); ?></td>
          <td><?php echo htmlspecialchars($row['category_name']); ?></td>
          <td>
            <a href="view-blog.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">View</a>
            <a href="edit-blog.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="delete-blog.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
