<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $career_id = isset($_POST['career_id']) ? (int)$_POST['career_id'] : null;
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $industry = mysqli_real_escape_string($conn, $_POST['industry']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $current_ctc = mysqli_real_escape_string($conn, $_POST['current_ctc']);
    $expected_ctc = mysqli_real_escape_string($conn, $_POST['expected_ctc']);
    $notice_period = mysqli_real_escape_string($conn, $_POST['notice_period']);

    $resume_filename = '';

    // Handle resume upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === 0) {
        $upload_dir = 'uploads/resumes/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $original_name = basename($_FILES['resume']['name']);
        $resume_filename = time() . '_' . preg_replace('/\s+/', '_', $original_name);
        $target_path = $upload_dir . $resume_filename;

        if (!move_uploaded_file($_FILES['resume']['tmp_name'], $target_path)) {
            echo "Failed to upload resume.";
            exit;
        }
    } else {
        echo "Resume is required.";
        exit;
    }

    // Insert into database
    $query = "
        INSERT INTO job_applications (
            career_id, first_name, last_name, phone, organization,
            industry, experience, current_ctc, expected_ctc,
            notice_period, resume
        ) VALUES (
            '$career_id', '$first_name', '$last_name', '$phone', '$organization',
            '$industry', '$experience', '$current_ctc', '$expected_ctc',
            '$notice_period', '$resume_filename'
        )
    ";

    if (mysqli_query($conn, $query)) {
        header("Location: career.php?success=1");
        exit;
    } else {
        echo "Error saving application.";
    }
} else {
    echo "Invalid request.";
}
?>
