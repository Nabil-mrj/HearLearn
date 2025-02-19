<?php
// Define the file path
$file = "courses.txt";

// Get course list (GET request)
function getCourses($file) {
    if (file_exists($file)) {
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    } else {
        return false;
    }
}

// Add a new course (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCourse = trim($_POST['newCourse'] ?? '');

    if ($newCourse !== '') {
        file_put_contents($file, $newCourse . PHP_EOL, FILE_APPEND | LOCK_EX);
        $message = "Course added successfully!";
    } else {
        $message = "Course name cannot be empty!";
    }
}

// Get the current course list
$courses = getCourses($file);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Select a Course</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif;
            background: #f8f8f8;
            color: #333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 375px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            box-sizing: border-box;
        }
        h1 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
            color: #007aff;
        }
        select, input[type="text"], input[type="submit"], button {
            width: 100%;
            font-size: 16px;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
        }
        input[type="submit"], button {
            background-color: #007aff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-bottom: 15px;
            color: #28a745;
            font-size: 14px;
            text-align: center;
        }
        .form-section {
            margin-bottom: 30px;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-section">
        <h1>Select a Course</h1>
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="courses.php" method="get">
            <select name="course" id="courseSelect">
                <?php if ($courses): ?>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo htmlspecialchars($course); ?>"><?php echo htmlspecialchars($course); ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">File not found or empty</option>
                <?php endif; ?>
            </select>
            <input type="submit" value="Confirm">
        </form>
    </div>

    <div class="form-section">
        <h1>Add New Course</h1>
        <form action="" method="post">
            <input type="text" name="newCourse" id="newCourse" placeholder="Enter new course name" required>
            <button type="submit">Add</button>
        </form>
    </div>
</div>
<footer>Interface optimized for iPhone</footer>
</body>
</html>
