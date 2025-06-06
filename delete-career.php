<?php
include 'db.php';

if (!isset($_GET['id'])) {
  echo "Invalid request.";
  exit();
}

$id = (int) $_GET['id'];
$delete = "DELETE FROM careers WHERE id = $id";

if (mysqli_query($conn, $delete)) {
  header("Location: dashboard.php?page=careers&deleted=true");
  exit();
} else {
  echo "Error deleting record.";
}
?>
