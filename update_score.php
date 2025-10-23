<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = intval($_POST['score']);
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    
    $scoresFile = 'scores.json';
    
    $scores = [];
    if (file_exists($scoresFile)) {
        $jsonData = file_get_contents($scoresFile);
        $scores = json_decode($jsonData, true);
        if (!is_array($scores)) {
            $scores = [];
        }
    }
    
    $userFound = false;
    foreach ($scores as &$userScore) {
        if ($userScore['username'] === $username) {
            if ($score > $userScore['score']) {
                $userScore['score'] = $score;
                $userScore['timestamp'] = date('Y-m-d H:i:s');
            }
            $userFound = true;
            break;
        }
    }
    
    if (!$userFound) {
        $scores[] = [
            'username' => $username,
            'email' => $email,
            'score' => $score,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    file_put_contents($scoresFile, json_encode($scores, JSON_PRETTY_PRINT));
    
    $_SESSION['current_score'] = $score;
    
    echo json_encode(['success' => true, 'score' => $score]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
