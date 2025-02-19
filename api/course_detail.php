<?php
$subject = htmlspecialchars($_GET['subject'] ?? '');
$course = htmlspecialchars($_GET['course'] ?? '');
$courseDir = __DIR__ . "/COURSES/" . $subject . "/" . $course;

// Vérifier si le dossier du cours existe
if (!is_dir($courseDir)) {
    die("Course not found!");
}

// Récupérer le fichier PDF et le fichier audio
$pdfFile = glob($courseDir . "/*.pdf")[0] ?? null;
$audioFile = glob($courseDir . "/*.{mp3,wav,ogg}", GLOB_BRACE)[0] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($course); ?></h1>

    <?php if ($pdfFile): ?>
        <iframe src="<?php echo htmlspecialchars(str_replace(__DIR__, '', $pdfFile)); ?>" width="100%" height="500px"></iframe>
    <?php else: ?>
        <p>No PDF available for this course.</p>
    <?php endif; ?>

    <?php if ($audioFile): ?>
        <audio controls>
            <source src="<?php echo htmlspecialchars(str_replace(__DIR__, '', $audioFile)); ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    <?php else: ?>
        <p>No audio available for this course.</p>
    <?php endif; ?>
</body>
</html>
