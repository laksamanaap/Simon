<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
    $_SESSION['email'] = htmlspecialchars($_POST['email']);
    $_SESSION['current_score'] = 0;
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>