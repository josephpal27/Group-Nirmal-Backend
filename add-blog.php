<?php
include 'db.php';

$message = "";

// Fetch categories
$categories = mysqli_query($conn, "SELECT id, name FROM blog_categories ORDER BY name ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category_id = (int)$_POST['category_id'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // Generate slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));

    if (!empty($title) && $category_id > 0 && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/blogs/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $insert = "INSERT INTO blogs (title, slug, image, category_id, content)
                       VALUES ('$title', '$slug', '$image_name', $category_id, '$content')";

            if (mysqli_query($conn, $insert)) {
                $message = "<div class='alert alert-success'>Blog added successfully.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Database error: Unable to add blog.</div>";
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
    <title>Add Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Add New Blog</h2>
        <?php echo $message; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Blog Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter blog title" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">-- Select Category --</option>
                    <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Blog Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <!-- Toolbar -->
            <div class="mb-2">
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
                <!-- Font color -->
                <input type="color" onchange="format('foreColor', this.value)" title="Text Color">
            </div>
    </div>

    <!-- Editable Div -->
    <div id="editor" contenteditable="true" style="border:1px solid #ccc; padding:10px; min-height:200px;"></div>

    <!-- Hidden input to submit -->
    <textarea name="content" id="content" style="display:none;"></textarea>

    <button type="submit" class="btn btn-primary">Add Blog</button>
    <a href="dashboard.php?page=blogs" class="btn btn-secondary">Back</a>
    </form>
    </div>
    <script>
        function format(command, value = null) {
            document.execCommand(command, false, value);
        }

        // Sync content to textarea on form submit
        document.querySelector("form").addEventListener("submit", function() {
            document.getElementById("content").value = document.getElementById("editor").innerHTML;
        });
    </script>

</body>

</html>