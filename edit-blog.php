<?php
include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid blog ID.";
    exit;
}

$id = intval($_GET['id']);

// Fetch blog data
$blog_query = "SELECT * FROM blogs WHERE id = $id";
$blog_result = mysqli_query($conn, $blog_query);
$blog = mysqli_fetch_assoc($blog_result);

if (!$blog) {
    echo "Blog not found.";
    exit;
}

// Fetch categories
$categories = mysqli_query($conn, "SELECT * FROM blog_categories");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_id = intval($_POST['category_id']);
    $image = $blog['image'];

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/blogs/";
        $image_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $image_name;
        }
    }

    $update = "UPDATE blogs SET title='$title', content='$content', category_id=$category_id, image='$image' WHERE id=$id";
    mysqli_query($conn, $update);
    header("Location: dashboard.php?page=blogs");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Link to Canonical -->
  <!-- <link rel="canonical" href="https://groupnirmal.com/edit-blog.php"> -->
  <style>
    .toolbar button, .toolbar select, .toolbar input[type="color"] {
      margin-right: 5px;
    }
    #editor {
      border: 1px solid #ccc;
      min-height: 200px;
      padding: 10px;
    }
  </style>
</head>
<body class="container py-5">
  <h2>Edit Blog</h2>
  <form method="POST" enctype="multipart/form-data" id="blogForm">
    <div class="mb-3">
      <label>Title</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($blog['title']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Category</label>
      <select name="category_id" class="form-select" required>
        <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
          <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $blog['category_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Image</label><br>
      <img src="uploads/blogs/<?= htmlspecialchars($blog['image']) ?>" width="100" class="mb-2"><br>
      <input type="file" name="image" class="form-control">
    </div>

    <!-- Custom Toolbar -->
    <div class="mb-2 toolbar">
      <button type="button" onclick="format('bold')"><b>B</b></button>
      <button type="button" onclick="format('italic')"><i>I</i></button>
      <button type="button" onclick="format('underline')"><u>U</u></button>
      <button type="button" onclick="format('insertOrderedList')">1.</button>
  <button type="button" onclick="format('insertUnorderedList')">•</button>
  <button type="button" onclick="format('formatBlock', 'H1')">H1</button>
  <button type="button" onclick="format('formatBlock', 'H2')">H2</button>
      <select onchange="format('fontSize', this.value)">
        <option value="">Size</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
      </select>
      <input type="color" onchange="format('foreColor', this.value)" title="Text Color">
    </div>

    <div class="mb-3">
      <label>Content</label>
      <div id="editor" contenteditable="true"><?= $blog['content'] ?></div>
      <textarea name="content" id="content" style="display: none;"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Blog</button>
    <a href="dashboard.php?page=blogs" class="btn btn-secondary">Cancel</a>
  </form>

  <script>
    function format(command, value = null) {
      document.execCommand(command, false, value);
    }

    // On submit, copy editor content to hidden textarea
    document.getElementById("blogForm").addEventListener("submit", function () {
      document.getElementById("content").value = document.getElementById("editor").innerHTML;
    });
  </script>
</body>
</html>
