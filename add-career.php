<?php
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.html");
  exit();
}

include 'db.php';

$message = "";

// Form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $designation = mysqli_real_escape_string($conn, $_POST['designation']);
  $experience = mysqli_real_escape_string($conn, $_POST['experience']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $job_description = mysqli_real_escape_string($conn, $_POST['job_description']);
  $roles_responsibilities = mysqli_real_escape_string($conn, $_POST['roles_responsibilities']);
  $qualifications_skills = mysqli_real_escape_string($conn, $_POST['qualifications_skills']);

  // Generate slug from designation
  $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $designation), '-'));

  // Optional: handle image upload
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "uploads/careers/";
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $image_name = time() . '_' . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $image_field = ", image";
      $image_value = ", '$image_name'";
    } else {
      $message = "<div class='alert alert-danger'>Error uploading image.</div>";
      $image_field = "";
      $image_value = "";
    }
  } else {
    $image_field = "";
    $image_value = "";
  }

  // Validate required fields
  if (!empty($designation) && !empty($location) && !empty($job_description)) {
    $insert = "INSERT INTO careers (
            designation, slug, experience, location, job_description,
            roles_responsibilities, qualifications_skills $image_field
        ) VALUES (
            '$designation', '$slug', '$experience', '$location', '$job_description',
            '$roles_responsibilities', '$qualifications_skills' $image_value
        )";

    if (mysqli_query($conn, $insert)) {
      $message = "<div class='alert alert-success'>Career added successfully.</div>";
    } else {
      $message = "<div class='alert alert-danger'>Database error: Unable to add career.</div>";
    }
  } else {
    $message = "<div class='alert alert-warning'>Please fill in all required fields.</div>";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Add Career</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Add New Career</h2>
      <a href="dashboard.php?page=careers" class="btn btn-success">← All Careers</a>
    </div>
    <?php echo $message; ?>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Designation</label>
        <input type="text" class="form-control" name="designation" placeholder="Enter job title" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Job Description</label>
        <textarea class="form-control" name="job_description" placeholder="Brief summary of the job" rows="4" required></textarea>
      </div>

      <!-- Roles and Responsibilities -->
      <div class="mb-3">
        <label class="form-label">Roles and Responsibilities</label>

        <!-- Toolbar -->
        <div class="toolbar mb-2">
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
          <input type="color" onchange="format('foreColor', this.value)">
        </div>

        <!-- Editable div -->
        <div id="rolesEditor" contenteditable="true" class="form-control" style="min-height: 150px;"></div>
        <textarea name="roles_responsibilities" id="rolesInput" style="display:none;"></textarea>
      </div>

      <!-- Qualifications & Skills -->
      <div class="mb-3">
        <label class="form-label">Qualifications & Skills</label>

        <!-- Toolbar -->
        <div class="toolbar mb-2">
          <button type="button" onclick="format('bold', null, 'qualificationsEditor')"><b>B</b></button>
          <button type="button" onclick="format('italic', null, 'qualificationsEditor')"><i>I</i></button>
          <button type="button" onclick="format('underline', null, 'qualificationsEditor')"><u>U</u></button>
          <button type="button" onclick="format('insertOrderedList', null, 'qualificationsEditor')">1.</button>
          <button type="button" onclick="format('insertUnorderedList', null, 'qualificationsEditor')">•</button>
          <button type="button" onclick="format('formatBlock', 'H1', 'qualificationsEditor')">H1</button>
          <button type="button" onclick="format('formatBlock', 'H2', 'qualificationsEditor')">H2</button>
          <select onchange="format('fontSize', this.value, 'qualificationsEditor')">
            <option value="">Size</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
          </select>
          <input type="color" onchange="format('foreColor', this.value, 'qualificationsEditor')">
        </div>

        <!-- Editable div -->
        <div id="qualificationsEditor" contenteditable="true" class="form-control" style="min-height: 150px;"></div>
        <textarea name="qualifications_skills" id="qualificationsInput" style="display:none;"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Experience (in years)</label>
        <input type="number" class="form-control" name="experience" placeholder="e.g. 3" min="0">
      </div>

      <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" class="form-control" name="location" placeholder="e.g. New York, Remote" required>
      </div>


      <div class="mb-3">
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
    </form>

  </div>
  <script>
    function format(command, value = null, editorId = 'rolesEditor') {
      const editor = document.getElementById(editorId);
      editor.focus();
      document.execCommand(command, false, value);
    }

    // Copy editable content to textarea before submit
    document.querySelector("form").addEventListener("submit", function() {
      document.getElementById("rolesInput").value = document.getElementById("rolesEditor").innerHTML;
      document.getElementById("qualificationsInput").value = document.getElementById("qualificationsEditor").innerHTML;
    });
  </script>
</body>

</html>