<?php
// Get the selected course name
$course = htmlspecialchars($_GET['course'] ?? '');

// Define the base directory as the "COURSES" folder in the current file directory.
$baseDir = __DIR__ . '/COURSES';

// Use the base directory if no path parameter is passed; otherwise, use the passed path.
$DirCurrent = $_GET['path'] ?? $baseDir;

// File upload handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the uploaded file is a PDF
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pdfFile']['tmp_name'];
        $fileName = $_FILES['pdfFile']['name'];
        $destPath = $DirCurrent . '/' . $fileName;

        // Move the uploaded file to the current directory
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            echo "PDF file uploaded successfully!";
        } else {
            echo "PDF file upload failed!";
        }
    }

    // Check if the uploaded file is an audio file
    if (isset($_FILES['audioFile']) && $_FILES['audioFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['audioFile']['tmp_name'];
        $fileName = $_FILES['audioFile']['name'];
        $destPath = $DirCurrent . '/' . $fileName;

        // Move the uploaded file to the current directory
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            echo "Audio file uploaded successfully!";
        } else {
            echo "Audio file upload failed!";
        }
    }
}

function showpage($DirCurrent) {
    // Check if the directory exists
    if (!is_dir($DirCurrent)) {
        echo "<p style='color: red;'>Directory does not exist: <strong>" . htmlspecialchars($DirCurrent) . "</strong></p>";
        return;
    }

    // Retrieve all files and folders in the current directory
    $items = scandir($DirCurrent);

    // Check if the directory is empty
    if (count($items) <= 2) { // If only "." and ".." exist, the directory is empty
        echo "<p>The current directory is empty. Please upload files:</p>";

        // Display the upload form
        echo "<form action='' method='post' enctype='multipart/form-data'>
        <label for='pdfFile'>Upload PDF File:</label>
        <input type='file' name='pdfFile' id='pdfFile' accept='.pdf' required>
        <br><br>
        <label for='audioFile'>Upload Audio File:</label>
        <input type='file' name='audioFile' id='audioFile' accept='.mp3,.wav,.ogg' required>
        <br><br>
        <button type='submit'>Upload Files</button>
      </form>";
    }

    echo "<ul>";

    foreach ($items as $item) {
        // Skip special directories "." and ".." as well as hidden files starting with "."
        if ($item === '.' || $item === '..' || strpos($item, '.') === 0) {
            continue;
        }

        $itemPath = $DirCurrent . '/' . $item;

        // Adjust the prefix path as needed
        $prefix = "/Users/fritato/PhpstormProjects/IE/WebPage/";
        $relativePath = str_replace($prefix, '', $itemPath);

        $fileExtension = strtolower(pathinfo($itemPath, PATHINFO_EXTENSION)); // Get file extension

        echo "<li style='margin-bottom: 10px;'>";

        if (is_dir($itemPath)) {
            // Directory link
            echo "<a href='?path=" . urlencode($itemPath) . "' style='text-decoration: none; color: #007BFF; font-size:16px;'>"
                . htmlspecialchars($item) . "</a>";
        } else {
            // Handle files
            if ($fileExtension === "pdf") {
                // Display PDF viewer
                echo "<iframe src=\"" . htmlspecialchars($relativePath) . "\" style=\"width:100%; height:600px; border:none;\"></iframe>";
            } elseif (in_array($fileExtension, ["mp3", "wav", "ogg"])) {
                // Display audio player
                echo "<audio controls style=\"width:100%;\">
                        <source src=\"" . htmlspecialchars($relativePath) . "\" type=\"audio/$fileExtension\">
                        Your browser does not support the audio element.
                      </audio>";
            } else {
                // Unsupported file types
                echo "Unsupported file type: " . htmlspecialchars($item);
            }
        }

        echo "</li>";
    }

    echo "</ul>";

    // Check if the directory has any visible items
    $visibleItems = array_filter($items, function($item) {
        return !($item === '.' || $item === '..' || strpos($item, '.') === 0);
    });

    if (empty($visibleItems)) {
        echo "<p>No visible content in this directory.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Browse Course Files</title>
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

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        li {
            font-size: 16px;
            color: #333;
        }

        a {
            text-decoration: none;
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
    <h1>Here is the PDF and Audio of class </h1>
    <?php showpage($DirCurrent); ?>
</div>
<footer></footer>
</body>
</html>
