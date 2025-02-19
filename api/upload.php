<?php
// Définition du répertoire d'upload
$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Gestion des fichiers uploadés
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (["pdfFile" => "pdf", "audioFile" => "audio"] as $inputName => $type) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$inputName]['tmp_name'];
            $fileName = basename($_FILES[$inputName]['name']);
            $destPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                echo ucfirst($type) . " file uploaded successfully!";
            } else {
                echo ucfirst($type) . " file upload failed!";
            }
        }
    }
}
?>
