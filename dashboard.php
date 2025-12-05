<?php
$statsFile = 'stats.txt';
$statsData = [];

// Charger les statistiques si le fichier existe
if (file_exists($statsFile)) {
    $json = file_get_contents($statsFile);
    $statsData = json_decode($json, true);
}

// Convertit un temps en secondes en format hh:mm:ss
function formatTime($seconds) {
    return gmdate("H:i:s", intval($seconds));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      color: #333;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 900px;
      background: white;
      margin: 0 auto;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }
    h1 {
      color: #0056b3;
      font-size: 26px;
      text-align: center;
    }
    h2 {
      color: #003f7f;
      font-size: 22px;
      margin-top: 20px;
      text-align: left;
    }
    .clicks {
      font-size: 18px;
      color: #555;
      margin-left: 10px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      background: white;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }
    th {
      background: #0056b3;
      color: white;
    }
    tr:nth-child(even) {
      background: #f9f9f9;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 16px;
      color: white;
      background: #0056b3;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }
    .btn:hover {
      background: #003f7f;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Dashboard des statistiques</h1>

    <?php if (!empty($statsData['courses'])): ?>
      <?php foreach ($statsData['courses'] as $course => $courseStats): ?>
        <h2>
          <?php echo htmlspecialchars($course); ?>
          <span class="clicks">(<?php echo $courseStats['clicks']; ?> clics)</span>
        </h2>

        <?php 
          // Filtrer les visites qui ont une durée supérieure à 60 secondes
          $validVisits = array_filter($courseStats['visits'], function($visit) {
              return $visit['duration'] > 60;
          });
        ?>

        <?php if (!empty($validVisits)): ?>
          <table>
            <thead>
              <tr>
                <th>Date/Heure</th>
                <th>Durée</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $totalDuration = 0;
                foreach ($validVisits as $visit):
                    $totalDuration += $visit['duration'];
              ?>
                <tr>
                  <td><?php echo htmlspecialchars($visit['timestamp']); ?></td>
                  <td><?php echo formatTime($visit['duration']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php 
            $averageDuration = count($validVisits) > 0 ? $totalDuration / count($validVisits) : 0;
          ?>
          <p><strong>Durée moyenne :</strong> <?php echo formatTime($averageDuration); ?></p>
        <?php else: ?>
          <p>Aucune donnée enregistrée pour les lectures de plus d'une minute.</p>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucune statistique enregistrée.</p>
    <?php endif; ?>

    <a href="/index.html" class="btn">Retour à l'accueil</a>
  </div>

</body>
</html>
