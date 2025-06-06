<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// Fetch contact form submissions
$query = "SELECT name, email FROM contact_form ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Form Data</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card {
      border-radius: 0.75rem;
    }
    .card-title {
      font-weight: 600;
      font-size: 1.2rem;
      color: #3a3a3a;
    }
    .table thead th {
      background-color: #f6f6f8;
      font-weight: 600;
      color: #3a3a3a;
    }
    .table td {
      color: #6c757d;
      vertical-align: middle;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title mb-3">Contact Form Data</h5>
      <table class="table table-borderless">
        <thead>
          <tr>
            <th>NAME</th>
            <th>EMAIL</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="2" class="text-center text-muted">No data available.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
