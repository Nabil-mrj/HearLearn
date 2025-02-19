<?php
// Définition du chemin correct vers courses.txt
$file = __DIR__ . "/COURSES/courses.txt";

// Fonction pour récupérer les cours
function getCourses($file) {
    if (file_exists($file)) {
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    } else {
        return [];
    }
}

// Ajout d'un nouveau cours
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCourse = trim($_POST['newCourse'] ?? '');
    if ($newCourse !== '') {
        file_put_contents($file, $newCourse . PHP_EOL, FILE_APPEND | LOCK_EX);
        $message = "Course added successfully!";
    } else {
        $message = "Course name cannot be empty!";
    }
}

// Récupération des cours
$courses = getCourses($file);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select a Course</title>
</head>
<body>
<div>
    <h1>Select a Course</h1>
    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form action="courses.php" method="get">
        <select name="course">
            <?php foreach ($courses as $course): ?>
                <option value="<?php echo htmlspecialchars($course); ?>"><?php echo htmlspecialchars($course); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Confirm">
    </form>
</div>
</body>
</html>
