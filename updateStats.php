<?php
include 'statsFunctions.php';

$subject     = $_POST['subject'] ?? '';
$class       = $_POST['class'] ?? '';
$readingTime = floatval($_POST['readingTime'] ?? 0);

if ($subject && $class) {
    updateStats($subject, $class, $readingTime);
}
?>
