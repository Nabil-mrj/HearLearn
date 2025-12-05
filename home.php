<?php
$baseDir = __DIR__ . '/COURSES';

function getSubjects($baseDir) {
    $subjects = [];
    if (is_dir($baseDir)) {
        $items = scandir($baseDir);
        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..' && is_dir($baseDir . '/' . $item)) {
                $subjects[] = $item;
            }
        }
    }
    return $subjects;
}

$subjects = getSubjects($baseDir);

$uploadMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_FILES['pdfFile']['name']) || !empty($_FILES['audioFile']['name'])) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!empty($_FILES['pdfFile']['name'])) {
            $pdfPath = $uploadDir . basename($_FILES['pdfFile']['name']);
            if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $pdfPath)) {
                $uploadMessage .= "PDF uploadé avec succès ! ";
            } else {
                $uploadMessage .= "Échec de l'upload du PDF. ";
            }
        }

        if (!empty($_FILES['audioFile']['name'])) {
            $audioPath = $uploadDir . basename($_FILES['audioFile']['name']);
            if (move_uploaded_file($_FILES['audioFile']['tmp_name'], $audioPath)) {
                $uploadMessage .= "Audio uploadé avec succès !";
            } else {
                $uploadMessage .= "Échec de l'upload de l'audio.";
            }
        }
    } else {
        $uploadMessage = "Aucun fichier sélectionné.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEARlearn</title>
    <!-- Ajout du favicon -->
    <link rel="icon" type="image/png" href="logo.png">
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
            /* Aligne verticalement le contenu */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 img {
            height: 50px;
            margin-right: 10px;
        }

        select, input[type="submit"], input[type="file"] {
            width: 100%;
            font-size: 16px;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #0056b3;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #003f7f;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .upload-section {
            background: #f8f9fa;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            text-align: left;
        }

        .upload-section h2 {
            font-size: 18px;
            color: #0056b3;
        }

        .message {
            color: green;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .nav-button {
            background-color: #f5f5f5;
            color: #666;
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 20px;
        }

        .nav-button:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Ajout du logo à gauche du titre -->
        <h1><img src="logo.png" alt="Logo">HEARlearn</h1>
        
        <form action="courses.php" method="get">
            <label for="subjectSelect">Choisir une matière:</label>
            <select name="subject" id="subjectSelect" onchange="loadClasses()">
                <option value="">Sélectionner une matière</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?php echo htmlspecialchars($subject); ?>"><?php echo htmlspecialchars($subject); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="classSelect">Choisir un cours:</label>
            <select name="class" id="classSelect">
                <option value="">Sélectionner un cours</option>
            </select>

            <input type="submit" value="Confirmer">
        </form>

        <div class="upload-section">
            <h2>Vous ne trouvez pas votre cours ?</h2>
            <p>Uploadez votre PDF (et l'audio si disponible) et nous proposerons votre cours au plus vite sur notre application.</p>

            <?php if (!empty($uploadMessage)): ?>
                <div class="message"><?php echo htmlspecialchars($uploadMessage); ?></div>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data">
                <label for="pdfFile">Upload PDF:</label>
                <input type="file" name="pdfFile" id="pdfFile" accept=".pdf"><br>

                <label for="audioFile">Upload Audio:</label>
                <input type="file" name="audioFile" id="audioFile" accept=".mp3,.wav,.ogg"><br>

                <input type="submit" value="Upload">
            </form>
        </div>
    </div>

    <script>
        function loadClasses() {
            let subject = document.getElementById('subjectSelect').value;
            let classSelect = document.getElementById('classSelect');

            classSelect.innerHTML = '<option value="">Chargement...</option>';

            if (subject) {
                fetch('courses.php?subject=' + encodeURIComponent(subject))
                    .then(response => response.json())
                    .then(data => {
                        classSelect.innerHTML = '<option value="">Sélectionner un cours</option>';
                        data.forEach(cls => {
                            let option = document.createElement('option');
                            option.value = cls;
                            option.textContent = cls;
                            classSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des cours:', error);
                        classSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    });
            } else {
                classSelect.innerHTML = '<option value="">Sélectionner un cours</option>';
            }
        }
    </script>

    <a href="index.html" class="nav-button">Menu du projet</a>
</body>
</html>
