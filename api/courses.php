<?php
$subject = htmlspecialchars($_GET['subject'] ?? '');
$subjectDir = __DIR__ . "/COURSES/" . $subject;

// Vérifier si la matière existe
if (!is_dir($subjectDir)) {
    die("Subject not found!");
}

// Récupérer les cours (les sous-dossiers)
$courses = array_filter(scandir($subjectDir), function($item) use ($subjectDir) {
    return is_dir($subjectDir . "/" . $item) && $item !== "." && $item !== "..";
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($subject); ?> - Courses</title>
</head>
<body>
    <h1>Courses in <?php echo htmlspecialchars($subject); ?></h1>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li>
                <a href="course_detail.php?subject=<?php echo urlencode($subject); ?>&course=<?php echo urlencode($course); ?>">
                    <?php echo htmlspecialchars($course); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
