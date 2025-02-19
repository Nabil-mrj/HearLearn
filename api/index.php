<?php
$baseDir = __DIR__ . "/COURSES";

// Récupération des matières (les dossiers dans COURSES/)
$subjects = array_filter(scandir($baseDir), function($item) use ($baseDir) {
    return is_dir($baseDir . "/" . $item) && $item !== "." && $item !== "..";
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select a Subject</title>
</head>
<body>
    <h1>Select a Subject</h1>
    <ul>
        <?php foreach ($subjects as $subject): ?>
            <li>
                <a href="courses.php?subject=<?php echo urlencode($subject); ?>">
                    <?php echo htmlspecialchars($subject); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
