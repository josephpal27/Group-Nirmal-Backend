<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// Fetch careers
$query = "SELECT id, designation, location, experience FROM careers ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Careers</h2>
    <a href="dashboard.php?page=add-career" class="btn btn-primary">+ Add Career</a>
  </div>

  <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
      <tr>
        <th>Designation</th>
        <th>Location</th>
        <th>Experience (years)</th>
        <th style="width: 200px;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['designation']); ?></td>
          <td><?php echo htmlspecialchars($row['location']); ?></td>
          <td><?php echo htmlspecialchars($row['experience']); ?></td>
          <td>
            <a href="view-career.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">View</a>
            <a href="edit-career.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="delete-career.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this career?');">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
