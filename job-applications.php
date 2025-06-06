<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';

// Fetch job applications joined with career title
$query = "
  SELECT a.*, c.designation AS career_title
  FROM job_applications a
  LEFT JOIN careers c ON a.career_id = c.id
  ORDER BY a.id DESC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Job Applications</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .table-resume {
      white-space: nowrap;
    }
  </style>
</head>
<body>
<div class="container mt-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Job Applications</h2>
  </div>

  <div id="applicationTable">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">All Applications</h5>
        <table class="table table-bordered table-striped mt-3">
          <thead class="table-dark">
            <tr>
              <th>Name</th>
              <th>Phone</th>
              <th>Career</th>
              <th>Experience</th>
              <th>Organization</th>
              <th>CTC (Current / Expected)</th>
              <th>Resume</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                  <td><?= htmlspecialchars($row['phone']) ?></td>
                  <td><?= htmlspecialchars($row['career_title'] ?? 'N/A') ?></td>
                  <td><?= htmlspecialchars($row['experience']) ?></td>
                  <td><?= htmlspecialchars($row['organization']) ?></td>
                  <td><?= htmlspecialchars($row['current_ctc']) ?> / <?= htmlspecialchars($row['expected_ctc']) ?></td>
                  <td class="table-resume">
                    <?php if (!empty($row['resume'])): ?>
                      <a href="uploads/resumes/<?= htmlspecialchars($row['resume']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                    <?php else: ?>
                      No File
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center">No applications found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
