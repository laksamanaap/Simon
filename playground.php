<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Simon Game</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
  <style>
    .game-wrapper {
      display: flex;
      justify-content: space-between;
      max-width: 1400px;
      margin: 0 auto;
      padding: 20px;
      gap: 20px;
    }
    
    .game-area {
      flex: 1;
    }
    
    .leaderboard {
      width: 320px;
      background: rgba(0, 0, 0, 0.8);
      padding: 20px;
      border-radius: 15px;
      color: white;
      height: fit-content;
      position: sticky;
      top: 150px;
      border: 3px solid #00a8ff;
      box-shadow: 0 0 20px rgba(0, 168, 255, 0.3);
    }
    
    .leaderboard h2 {
      font-size: 16px;
      text-align: center;
      margin-bottom: 20px;
      color: #00a8ff;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    
    .leaderboard-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px;
      margin: 8px 0;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      font-size: 11px;
      transition: all 0.3s ease;
    }
    
    .leaderboard-item:hover {
      background: rgba(255, 255, 255, 0.15);
      transform: translateX(5px);
    }
    
    .leaderboard-item.current-user {
      background: rgba(0, 168, 255, 0.4);
      border: 2px solid #00a8ff;
      box-shadow: 0 0 15px rgba(0, 168, 255, 0.5);
    }
    
    .rank {
      font-weight: bold;
      color: #00a8ff;
      min-width: 50px;
    }

    .rank-top-three {
        font-weight: bold;
        color: #ffd700;
        min-width: 50px;
    }
    
    .username {
      flex: 1;
      text-align: center;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    
    .score {
      font-weight: bold;
      color: #4ade80;
      min-width: 40px;
      text-align: right;
    }
    
    .user-info {
      position: fixed;
      top: 10px;
      right: 10px;
      background: rgba(0, 0, 0, 0.9);
      padding: 15px 25px;
      border-radius: 10px;
      color: white;
      font-size: 12px;
      z-index: 1000;
      border: 2px solid #00a8ff;
      box-shadow: 0 0 15px rgba(0, 168, 255, 0.3);
    }
    
    .current-score {
      color: #4ade80;
      font-weight: bold;
      font-size: 14px;
    }
    
    .loading {
      text-align: center;
      color: #888;
      font-size: 11px;
      padding: 20px;
    }
    
    @media (max-width: 968px) {
      .game-wrapper {
        flex-direction: column;
      }
      
      .leaderboard {
        width: 100%;
        margin-top: 50x;
        position: relative;
      }
      
      .user-info {
        position: relative;
        margin: 10px auto;
        display: inline-block;
      }
    }
  </style>
</head>

<body>
  <div class="user-info">
    🎮 Player: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> | 
    Score: <span class="current-score" id="display-score">0</span>
  </div>

  <div class="game-wrapper">
    <div class="game-area">
      <h1 id="level-title">Press <a href="#" id="start-game">this</a> to Start</h1>
      <div class="container">
        <div class="row">
          <button id="green" class="btn green"></button>
          <button id="red" class="btn red"></button>
        </div>
        <div class="row">
          <button id="yellow" class="btn yellow"></button>
          <button id="blue" class="btn blue"></button>
        </div>
      </div>
    </div>

    <div class="leaderboard">
      <h2>Ini Leaderboard </h2>
      <div id="leaderboard-content">
        <div class="loading">Loading scores...</div>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  
  <script src="main.js"></script>
</body>

</html>