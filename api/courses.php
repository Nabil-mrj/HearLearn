<?php
// Récupération du cours sélectionné
$course = htmlspecialchars($_GET['course'] ?? '');
$courseDir = __DIR__ . "/COURSES/" . $course;

// Vérification de l'existence du dossier du cours
if (!is_dir($courseDir)) {
    echo "Course not found!";
    exit;
}

// Récupération des fichiers du dossier
$items = scandir($courseDir);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Files</title>
</head>
<body>
<h1>Files for <?php echo htmlspecialchars($course); ?></h1>
<ul>
    <?php foreach ($items as $item): 
        if ($item === '.' || $item === '..') continue;
        $filePath = "COURSES/$course/$item";
        $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
        echo "<li>";
        if ($fileExt === "pdf") {
            echo "<iframe src='$filePath' width='600' height='500'></iframe>";
        } elseif (in_array($fileExt, ["mp3", "wav", "ogg"])) {
            echo "<audio controls><source src='$filePath' type='audio/$fileExt'></audio>";
        } else {
            echo "<a href='$filePath'>$item</a>";
        }
        echo "</li>";
    endforeach; ?>
</ul>
</body>
</html>
