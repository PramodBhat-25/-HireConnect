<?php
require_once "dp.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name   = trim($_POST['name'] ?? '');
    $number = trim($_POST['number'] ?? '');
    $email  = trim($_POST['email'] ?? '');

    if (empty($name) || empty($number) || empty($email)) {
        die("<div style='text-align: center;'>Error: Please fill in all required text fields.</div>");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<div style='text-align: center;'>Error: Invalid email format.</div>");
    }

    if (!isset($_FILES['resume']) || $_FILES['resume']['error'] !== UPLOAD_ERR_OK) {
        die("<div style='text-align: center;'>Error: Please upload a valid resume file.</div>");
    }

    $fileTmpPath = $_FILES['resume']['tmp_name'];
    $fileName    = $_FILES['resume']['name'];
    $fileSize    = $_FILES['resume']['size'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    if ($fileSize > $maxFileSize) {
        die("<div style='text-align: center;'>Error: File size exceeds the 5MB limit.</div>");
    }

    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $finfo         = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType      = finfo_file($finfo, $fileTmpPath);
    finfo_close($finfo);

    if ($fileExtension !== 'pdf' || $mimeType !== 'application/pdf') {
        die("<div style='text-align: center;'>Error: Only PDF files are allowed.</div>");
    }

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $newFileName = uniqid('resume_', true) . '.pdf';
    $destPath    = $uploadDir . $newFileName;

    if (!move_uploaded_file($fileTmpPath, $destPath)) {
        die("<div style='text-align: center;'>Error: Failed to save uploaded file.</div>");
    }

    $sql = "INSERT INTO student (name, number, email, resume) VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {

        mysqli_stmt_bind_param($stmt, "ssss", $name, $number, $email, $destPath);

        if (mysqli_stmt_execute($stmt)) {
            echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif; line-height: 1.8;'>";
            echo "<h2>Candidate Details Submitted Successfully</h2>";
            echo "Name: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Phone: " . htmlspecialchars($number, ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Email: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "<br>";
            echo "Resume: <a href='" . htmlspecialchars($destPath, ENT_QUOTES, 'UTF-8') . "' target='_blank'>View Uploaded PDF</a><br><br>";
            echo "</div>";
        } else {
            echo "<div style='text-align: center;'>Error executing query: " . htmlspecialchars(mysqli_stmt_error($stmt)) . "</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<div style='text-align: center;'>Error preparing statement: " . htmlspecialchars(mysqli_error($conn)) . "</div>";
    }

    mysqli_close($conn);

} else {
    echo "<div style='text-align: center;'>Please submit the form first.</div>";
}
?>