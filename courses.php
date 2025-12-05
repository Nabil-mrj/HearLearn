<?php
$baseDir = __DIR__ . '/COURSES';

if (isset($_GET['subject']) && !isset($_GET['class'])) {
    $subject = $_GET['subject'];
    $classes = [];

    $subjectPath = $baseDir . '/' . $subject;
    if (is_dir($subjectPath)) {
        $items = scandir($subjectPath);
        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..' && is_dir($subjectPath . '/' . $item)) {
                $classes[] = $item;
            }
        }
    }
    header('Content-Type: application/json');
    echo json_encode($classes);
    exit;
}

$subject = $_GET['subject'] ?? '';
$class   = $_GET['class'] ?? '';
$classPath = $baseDir . '/' . $subject . '/' . $class;

include 'statsFunctions.php';
if ($subject && $class) {
    updateStats($subject, $class, 0, '');
}

function listFiles($directory, $extensions = []) {
    $files = [];
    if (is_dir($directory)) {
        $items = scandir($directory);
        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..') {
                $filePath = $directory . '/' . $item;
                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                if (empty($extensions) || in_array($ext, $extensions)) {
                    $files[] = $item;
                }
            }
        }
    }
    return $files;
}

$pdfFiles   = listFiles($classPath, ['pdf']);
$audioFiles = listFiles($classPath, ['mp3', 'wav', 'ogg']);

if (!empty($pdfFiles)) {
    $encodedSubject = rawurlencode($subject);
    $encodedClass   = rawurlencode($class);
    $encodedPdf     = rawurlencode($pdfFiles[0]);
    $pdfRelativePath = "../../COURSES/$encodedSubject/$encodedClass/$encodedPdf";
    $pdfJsViewerUrl  = "pdfjs/web/viewer.html?file=" . urlencode($pdfRelativePath) . "#zoom=page-fit";
    $pdfDirectUrl    = "COURSES/$encodedSubject/$encodedClass/$encodedPdf";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($subject . ' - ' . $class); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 800px;
            background: white;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            color: #0056b3;
            font-size: 26px;
            margin-bottom: 20px;
        }

        h2 {
            color: #0056b3;
            font-size: 20px;
            margin-top: 30px;
        }

        .pdf-viewer {
            width: 100%;
            height: 600px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 20px 0;
        }

        audio {
            width: 100%;
            margin: 10px 0;
        }

        .button {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 10px 0;
            cursor: pointer;
        }

        .button:hover {
            background-color: #003f7f;
        }

        #mobileLink {
            margin: 20px 0;
        }

        #mobileLink a {
            color: #0056b3;
            text-decoration: none;
        }

        #mobileLink a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home.php" class="button">Retour à l'accueil</a>
        
        <h1><?php echo htmlspecialchars($subject . ' - ' . $class); ?></h1>

        <div class="content">
            <h2>Lecture du PDF</h2>
            <?php if (!empty($pdfFiles)): ?>
                <div id="pdfContainer">
                    <iframe id="pdfIframe" class="pdf-viewer"
                            src="<?php echo htmlspecialchars($pdfJsViewerUrl); ?>"
                            allowfullscreen>
                    </iframe>
                </div>
                <div id="mobileLink">
                    <a href="<?php echo htmlspecialchars($pdfDirectUrl); ?>" target="_blank">
                        Ouvrir le PDF en plein écran
                    </a>
                </div>
            <?php else: ?>
                <p>Aucun fichier PDF disponible.</p>
            <?php endif; ?>

            <h2>Fichiers audio</h2>
            <?php if (!empty($audioFiles)): ?>
                <?php foreach ($audioFiles as $file): ?>
                    <?php
                        $encodedFile = rawurlencode($file);
                        $audioUrl    = "COURSES/$encodedSubject/$encodedClass/$encodedFile";
                    ?>
                    <audio controls>
                        <source src="<?php echo htmlspecialchars($audioUrl); ?>"
                                type="audio/<?php echo pathinfo($file, PATHINFO_EXTENSION); ?>">
                        Votre navigateur ne prend pas en charge la lecture audio.
                    </audio>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun fichier audio disponible.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        var isMobile = /Mobi|Android/i.test(navigator.userAgent);
        if (isMobile) {
            var pdfContainer = document.getElementById('pdfContainer');
            var mobileLink   = document.getElementById('mobileLink');
            if (pdfContainer) pdfContainer.style.display = 'none';
            if (mobileLink) mobileLink.style.display = 'block';
        } else {
            var pdfContainer = document.getElementById('pdfContainer');
            var mobileLink   = document.getElementById('mobileLink');
            if (pdfContainer) pdfContainer.style.display = 'block';
            if (mobileLink) mobileLink.style.display = 'none';
        }

        var startTime = Date.now();
        window.addEventListener("beforeunload", function() {
            var duration = (Date.now() - startTime) / 1000;
            var data = new URLSearchParams();
            data.append("subject", "<?php echo htmlspecialchars($subject); ?>");
            data.append("class", "<?php echo htmlspecialchars($class); ?>");
            data.append("readingTime", duration);
            <?php
            if (!empty($pdfFiles)) {
                echo "data.append('file', " . json_encode($pdfFiles[0]) . ");";
            }
            ?>
            navigator.sendBeacon("updateStats.php", data);
        });
    </script>
</body>
</html>