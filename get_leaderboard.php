<?php
session_start();

header('Content-Type: application/json');

$scoresFile = 'scores.json';
$currentUsername = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$scores = [];
if (file_exists($scoresFile)) {
    $jsonData = file_get_contents($scoresFile);
    $scores = json_decode($jsonData, true);
    if (!is_array($scores)) {
        $scores = [];
    }
}

usort($scores, function($a, $b) {
    return $b['score'] - $a['score'];
});

// Top 10
$topScores = array_slice($scores, 0, 10);

foreach ($topScores as &$score) {
    $score['is_current'] = ($score['username'] === $currentUsername);
}

echo json_encode($topScores);
?>