<?php
// Ensure files are uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the file is a PDF
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pdfFile']['tmp_name'];
        $fileName = $_FILES['pdfFile']['name'];
        $uploadDir = __DIR__; // Current directory
        $destPath = $uploadDir . '/' . $fileName;

        // Move the uploaded file to the current directory
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            echo "PDF file has been successfully uploaded!";
        } else {
            echo "PDF file upload failed!";
        }
    }

    // Check if the file is an audio file
    if (isset($_FILES['audioFile']) && $_FILES['audioFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['audioFile']['tmp_name'];
        $fileName = $_FILES['audioFile']['name'];
        $uploadDir = __DIR__; // Current directory
        $destPath = $uploadDir . '/' . $fileName;

        // Move the uploaded file to the current directory
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            echo "Audio file has been successfully uploaded!";
        } else {
            echo "Audio file upload failed!";
        }
    }
} else {
    echo "No files uploaded!";
}
?>
