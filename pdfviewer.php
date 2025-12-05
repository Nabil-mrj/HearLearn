<?php
// pdfviewer.php

if (!isset($_GET['file'])) {
    exit('Aucun fichier spécifié.');
}

$file = $_GET['file'];
$fullPath = realpath(__DIR__ . '/' . $file);

// Vérifier que le fichier existe et est bien un PDF
if (!$fullPath || !file_exists($fullPath) || strtolower(pathinfo($fullPath, PATHINFO_EXTENSION)) !== 'pdf') {
    exit('Fichier non trouvé ou non valide.');
}

// Envoyer les en-têtes pour afficher le PDF inline
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($fullPath) . '"');
header('Content-Length: ' . filesize($fullPath));

readfile($fullPath);
exit;
?>
