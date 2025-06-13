<?php
include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid career ID.";
    exit;
}

$id = intval($_GET['id']);

// Fetch career data
$career_query = "SELECT * FROM careers WHERE id = $id";
$career_result = mysqli_query($conn, $career_query);
$career = mysqli_fetch_assoc($career_result);

if (!$career) {
    echo "Career not found.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $job_description = mysqli_real_escape_string($conn, $_POST['job_description']);
    $roles_responsibilities = mysqli_real_escape_string($conn, $_POST['roles_responsibilities']);
    $qualifications_skills = mysqli_real_escape_string($conn, $_POST['qualifications_skills']);

    $update = "UPDATE careers SET 
                designation='$designation', 
                experience='$experience', 
                location='$location', 
                job_description='$job_description', 
                roles_responsibilities='$roles_responsibilities', 
                qualifications_skills='$qualifications_skills' 
               WHERE id=$id";

    mysqli_query($conn, $update);
    header("Location: dashboard.php?page=careers");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Career</title>
  <!-- Link to Canonical -->
  <!-- <link rel="canonical" href="https://groupnirmal.com/edit-career.php"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .toolbar button, .toolbar select, .toolbar input[type="color"] {
      margin-right: 5px;
      padding: 4px 6px;
      border: 1px solid #ccc;
      background: #fff;
      cursor: pointer;
    }
    .form-control[contenteditable="true"] {
      border: 1px solid #ccc;
      min-height: 150px;
    }
  </style>
</head>
<body class="container py-5">

  <h2>Edit Career</h2>
  <form method="POST" id="careerForm">
    <div class="mb-3">
      <label>Designation</label>
      <input type="text" name="designation" class="form-control" value="<?= htmlspecialchars($career['designation']) ?>" required>
    </div>

    <div class="mb-3">
      <label>Experience (in years)</label>
      <input type="text" name="experience" class="form-control" value="<?= htmlspecialchars($career['experience']) ?>" required>
    </div>

    <div class="mb-3">
      <label>Location</label>
      <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($career['location']) ?>" required>
    </div>

    <div class="mb-3">
      <label>Job Description</label>
      <textarea name="job_description" id="job_description" class="form-control" rows="4"><?= htmlspecialchars($career['job_description']) ?></textarea>
    </div>

    <!-- Roles and Responsibilities -->
    <div class="mb-3">
      <label>Roles and Responsibilities</label>
      <div class="toolbar mb-2">
        <button type="button" onclick="format('bold', null, 'rolesEditor')"><b>B</b></button>
        <button type="button" onclick="format('italic', null, 'rolesEditor')"><i>I</i></button>
        <button type="button" onclick="format('underline', null, 'rolesEditor')"><u>U</u></button>
        <button type="button" onclick="format('insertOrderedList', null, 'rolesEditor')">1.</button>
        <button type="button" onclick="format('insertUnorderedList', null, 'rolesEditor')">•</button>
        <button type="button" onclick="format('formatBlock', 'H1', 'rolesEditor')">H1</button>
        <button type="button" onclick="format('formatBlock', 'H2', 'rolesEditor')">H2</button>
        <select onchange="format('fontSize', this.value, 'rolesEditor')">
          <option value="">Size</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
        </select>
        <input type="color" onchange="format('foreColor', this.value, 'rolesEditor')">
      </div>
      <div id="rolesEditor" contenteditable="true" class="form-control"><?= $career['roles_responsibilities'] ?></div>
      <textarea name="roles_responsibilities" id="rolesInput" style="display:none;"></textarea>
    </div>

    <!-- Qualifications & Skills -->
    <div class="mb-3">
      <label>Qualifications & Skills</label>
      <div class="toolbar mb-2">
        <button type="button" onclick="format('bold', null, 'qualEditor')"><b>B</b></button>
        <button type="button" onclick="format('italic', null, 'qualEditor')"><i>I</i></button>
        <button type="button" onclick="format('underline', null, 'qualEditor')"><u>U</u></button>
        <button type="button" onclick="format('insertOrderedList', null, 'qualEditor')">1.</button>
        <button type="button" onclick="format('insertUnorderedList', null, 'qualEditor')">•</button>
        <button type="button" onclick="format('formatBlock', 'H1', 'qualEditor')">H1</button>
        <button type="button" onclick="format('formatBlock', 'H2', 'qualEditor')">H2</button>
        <select onchange="format('fontSize', this.value, 'qualEditor')">
          <option value="">Size</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
        </select>
        <input type="color" onchange="format('foreColor', this.value, 'qualEditor')">
      </div>
      <div id="qualEditor" contenteditable="true" class="form-control"><?= $career['qualifications_skills'] ?></div>
      <textarea name="qualifications_skills" id="qualifications_skills" style="display:none;"></textarea>
    </div>

    <div class="mb-3">
      <button type="submit" class="btn btn-primary">Update Career</button>
      <a href="dashboard.php?page=careers" class="btn btn-secondary">Cancel</a>
    </div>
  </form>

  <!-- Script to sync contenteditable content before submit -->
  <script>
    function format(command, value = null, editorId) {
      const editor = document.getElementById(editorId);
      editor.focus();
      document.execCommand(command, false, value);
    }

    document.getElementById("careerForm").addEventListener("submit", function () {
      document.getElementById("rolesInput").value = document.getElementById("rolesEditor").innerHTML;
      document.getElementById("qualifications_skills").value = document.getElementById("qualEditor").innerHTML;
    });
  </script>

</body>
</html>
