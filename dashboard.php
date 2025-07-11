<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

include 'db.php';
$page = $_GET['page'] ?? '';

// Get role from session
$role = $_SESSION['admin_role'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      margin: 0;
    }
    .sidebar {
      width: 250px;
      background-color: white;
      color: black;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
    }
    .sidebar a {
      color: black;
      padding: 12px 20px;
      display: block;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: hsl(215, 48.60%, 93.10%);
    }
    .sidebar .active {
      background-color: #3A739B;
      color: white;
    }
    .submenu a {
      padding-left: 40px;
      background-color: hsl(215, 48.60%, 93.10%);
    }
    .main {
      flex-grow: 1;
      padding: 30px;
      background-color: #f8f9fa;
    }
    .logo {
      font-size: 1.5rem;
      font-weight: bold;
      padding: 20px;
      text-align: center;
      background: #ffffff;
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    .logo-img {
      height: 115px;
    }
    .table-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
    .custom-card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
      transition: transform 0.2s ease;
      text-align: center;
      padding: 2rem 1rem;
      background-color: #fff;
      color: #000;
    }
    .custom-card:hover {
      transform: translateY(-4px);
    }
    .custom-card i {
      font-size: 2.5rem;
      color: #3A739B;
      margin-bottom: 1rem;
    }
    .custom-card-title {
      font-size: 1.1rem;
      color: #343a40;
      font-weight: 500;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <div class="logo">
    <div class="d-flex align-items-center justify-content-center bg-white p-3 border-bottom">
      <img src="assets/images/logo/logo.png" alt="Logo 1" class="logo-img">
    </div>
  </div>

  <?php if ($role == 'admin'): ?>
    <a href="dashboard.php" class="<?= $page == '' ? 'active' : '' ?>">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a data-bs-toggle="collapse" href="#careerMenu" role="button" aria-expanded="<?= in_array($page, ['careers', 'job-applications']) ? 'true' : 'false' ?>" aria-controls="careerMenu">
      <i class="bi bi-briefcase"></i> Manage Career
    </a>
    <div class="collapse submenu <?= in_array($page, ['careers', 'job-applications']) ? 'show' : '' ?>" id="careerMenu">
      <a href="dashboard.php?page=careers" class="<?= $page == 'careers' ? 'active' : '' ?>">
        <i class="bi bi-person-badge"></i> Careers
      </a>
      <a href="dashboard.php?page=job-applications" class="<?= $page == 'job-applications' ? 'active' : '' ?>">
        <i class="bi bi-file-earmark-text"></i> Job Applications
      </a>
    </div>
  <?php endif; ?>

  <?php if ($role == 'admin' || $role == 'blog'): ?>
    <a data-bs-toggle="collapse" href="#blogMenu" role="button" aria-expanded="<?= in_array($page, ['blog-categories', 'blogs', 'add-blog', 'edit-blog']) ? 'true' : 'false' ?>" aria-controls="blogMenu">
      <i class="bi bi-journal-text"></i> Manage Blogs
    </a>
    <div class="collapse submenu <?= in_array($page, ['blog-categories', 'blogs', 'add-blog', 'edit-blog']) ? 'show' : '' ?>" id="blogMenu">
      <a href="dashboard.php?page=blog-categories" class="<?= $page == 'blog-categories' ? 'active' : '' ?>">
        <i class="bi bi-tags"></i> Categories
      </a>
      <a href="dashboard.php?page=blogs" class="<?= $page == 'blogs' ? 'active' : '' ?>">
        <i class="bi bi-stickies"></i> Blogs
      </a>
    </div>
  <?php endif; ?>

  <?php if ($role == 'admin'): ?>
    <a href="dashboard.php?page=contact-form-data" class="<?= $page == 'contact-form-data' ? 'active' : '' ?>">
      <i class="bi bi-envelope"></i> Contact Form Data
    </a>
  <?php endif; ?>

  <a href="logout.php">
    <i class="bi bi-box-arrow-right"></i> Logout
  </a>
</div>

<div class="main">
  <?php if ($page == ''): ?>
    <h2 class="text-center mb-5">Welcome, <?php echo $_SESSION['admin_name']; ?>!</h2>
    <div class="row g-4">

      <?php if ($role == 'admin'): ?>
        <div class="col-md-3">
          <a href="dashboard.php?page=careers" class="text-decoration-none">
            <div class="custom-card">
              <i class="bi bi-briefcase-fill"></i>
              <div class="custom-card-title">Careers</div>
            </div>
          </a>
        </div>

        <div class="col-md-3">
          <a href="dashboard.php?page=job-applications" class="text-decoration-none">
            <div class="custom-card">
              <i class="bi bi-file-earmark-text-fill"></i>
              <div class="custom-card-title">Job Applications</div>
            </div>
          </a>
        </div>

        <div class="col-md-3">
          <a href="dashboard.php?page=contact-form-data" class="text-decoration-none">
            <div class="custom-card">
              <i class="bi bi-envelope-fill"></i>
              <div class="custom-card-title">Contact Form</div>
            </div>
          </a>
        </div>
      <?php endif; ?>

      <?php if ($role == 'admin' || $role == 'blog'): ?>
        <div class="col-md-3">
          <a href="dashboard.php?page=blogs" class="text-decoration-none">
            <div class="custom-card">
              <i class="bi bi-journal-text"></i>
              <div class="custom-card-title">Blogs</div>
            </div>
          </a>
        </div>
      <?php endif; ?>

    </div>

  <?php else:
    switch ($page) {
      case 'careers':
      case 'add-career':
      case 'edit-career':
      case 'job-applications':
      case 'contact-form-data':
        if ($role == 'admin') {
          include $page . '.php';
        } else {
          echo "<p>Unauthorized access.</p>";
        }
        break;

      case 'blog-categories':
      case 'blogs':
      case 'add-blog':
      case 'edit-blog':
        if (in_array($role, ['admin', 'blog'])) {
          include $page . '.php';
        } else {
          echo "<p>Unauthorized access.</p>";
        }
        break;

      default:
        echo "<p>Page not found.</p>";
        break;
    }
  endif;
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
