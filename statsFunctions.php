<?php
function updateStats($subject, $class, $readingTime = 0) {
    $statsFile = 'stats.txt';
    $data = [];

    // Lire le contenu du fichier stats.txt s'il existe
    if (file_exists($statsFile)) {
        $json = file_get_contents($statsFile);
        $data = json_decode($json, true);
        if (!$data) {
            $data = [];
        }
    }
    if (!isset($data['courses'])) {
        $data['courses'] = [];
    }
    $courseKey = $subject . '/' . $class;
    if (!isset($data['courses'][$courseKey])) {
         $data['courses'][$courseKey] = [
              'clicks'  => 0,
              'visits'  => []
         ];
    }
    if ($readingTime > 0) {
         // Enregistrement d'une visite avec durée (en secondes)
         $visit = [
             'timestamp' => date('Y-m-d H:i:s'),
             'duration'  => $readingTime
         ];
         $data['courses'][$courseKey]['visits'][] = $visit;
    } else {
         // Enregistrement d'un clic (chargement de la page)
         $data['courses'][$courseKey]['clicks']++;
    }
    // Sauvegarde des données mises à jour dans stats.txt
    file_put_contents($statsFile, json_encode($data, JSON_PRETTY_PRINT));
}
?>
