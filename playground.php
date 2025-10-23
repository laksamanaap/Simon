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

    /* Instructions Button */
    .instructions-btn {
      position: fixed;
      top: 10px;
      left: 10px;
      background: rgba(0, 168, 255, 0.9);
      color: white;
      border: 2px solid #00a8ff;
      padding: 12px 20px;
      border-radius: 10px;
      font-size: 12px;
      cursor: pointer;
      z-index: 1000;
      transition: all 0.3s ease;
      box-shadow: 0 0 15px rgba(0, 168, 255, 0.5);
      font-weight: bold;
      font-family: 'Press Start 2P', cursive;
    }

    .instructions-btn:hover {
      background: rgba(0, 168, 255, 1);
      transform: translateY(-2px);
      box-shadow: 0 0 25px rgba(0, 168, 255, 0.8);
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      animation: fadeIn 0.3s ease;
    }

    .modal-content {
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
      margin: 3% auto;
      padding: 0;
      border: 3px solid #00a8ff;
      border-radius: 20px;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 0 40px rgba(0, 168, 255, 0.6);
      animation: slideDown 0.4s ease;
      color: white;
    }

    .modal-header {
      background: rgba(0, 168, 255, 0.2);
      padding: 20px 30px;
      border-bottom: 2px solid #00a8ff;
      border-radius: 17px 17px 0 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-header h2 {
      margin: 0;
      color: #00a8ff;
      font-size: 20px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .close-btn {
      color: #ff4444;
      font-size: 32px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      line-height: 1;
    }

    .close-btn:hover {
      color: #ff0000;
      transform: rotate(90deg);
    }

    .modal-body {
      padding: 30px;
      max-height: 70vh;
      overflow-y: auto;
    }

    .modal-body h3 {
      color: #00a8ff;
      font-size: 18px;
      margin-bottom: 20px;
      text-align: center;
      text-transform: uppercase;
    }

    .modal-body ol {
      list-style: none;
      counter-reset: item;
      padding: 0;
    }

    .modal-body ol li {
      counter-increment: item;
      margin-bottom: 15px;
      padding: 12px 15px;
      background: rgba(255, 255, 255, 0.05);
      border-left: 4px solid #00a8ff;
      border-radius: 5px;
      font-size: 13px;
      line-height: 1.6;
    }

    .modal-body ol li::before {
      content: counter(item) ". ";
      color: #00a8ff;
      font-weight: bold;
      font-size: 16px;
      margin-right: 8px;
    }

    .modal-body ol li strong {
      color: #4ade80;
    }

    .modal-footer {
      text-align: center;
      padding: 20px;
      border-top: 2px solid rgba(0, 168, 255, 0.3);
      font-size: 11px;
      color: #888;
    }

    .have-fun {
      color: #00a8ff;
      font-size: 14px;
      font-weight: bold;
      margin: 15px 0;
      text-align: center;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideDown {
      from {
        transform: translateY(-50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    /* Scrollbar */
    .modal-body::-webkit-scrollbar {
      width: 8px;
    }

    .modal-body::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.3);
      border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
      background: #00a8ff;
      border-radius: 10px;
    }

    @media (max-width: 1024px) {
      .game-wrapper {
        flex-direction: column !important;
      }
      
      .leaderboard {
        width: 100% !important;
        margin-top: 30px;
        position: relative !important;
        top: auto !important;
      }
      
      .game-area {
        width: 100%;
      }
    }

    @media (max-width: 600px) {
      .game-wrapper {
        padding: 10px;
        gap: 10px;
      }
      
      .user-info {
        position: relative !important;
        margin: 10px auto 20px;
        display: block;
        text-align: center;
        top: auto !important;
        right: auto !important;
      }

      .instructions-btn {
        position: relative;
        margin: 10px auto;
        display: block;
        width: fit-content;
      }
      
      .leaderboard {
        padding: 15px;
      }
      
      .leaderboard h2 {
        font-size: 14px;
      }
      
      .leaderboard-item {
        font-size: 10px;
        padding: 10px;
      }
      
      #level-title {
        font-size: 2rem;
      }

      .modal-content {
        width: 95%;
        margin: 10% auto;
      }

      .modal-header h2 {
        font-size: 16px;
      }

      .modal-body {
        padding: 20px;
      }
    }

    @media (max-width: 400px) {
      .user-info {
        font-size: 9px;
        padding: 8px 12px;
      }
      
      .leaderboard-item {
        font-size: 9px;
        padding: 8px;
      }

      .instructions-btn {
        font-size: 10px;
        padding: 10px 15px;
      }
    }
  </style>

</head>

<body>

  <button class="instructions-btn" id="instructionsBtn">How to Play</button>

  <div class="user-info">
    🎮 Player: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> | 
    Score: <span class="current-score" id="display-score">0</span>
  </div>

  <div id="instructionsModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2>🎮 Simon Game Rules</h2>
        <span class="close-btn">&times;</span>
      </div>
      <div class="modal-body">
        <ol>
          <li><strong>Objective:</strong> Remember and repeat a sequence of colors and sounds.</li>
          <li><strong>Gameplay:</strong> Simon shows a color sequence, then it's your turn.</li>
          <li><strong>Memorization:</strong> Pay attention to colors and buttons.</li>
          <li><strong>Your Turn:</strong> Repeat the sequence exactly.</li>
          <li><strong>Accuracy:</strong> Progress for correct sequences, game ends for mistakes.</li>
          <li><strong>Challenge:</strong> Longer, complex sequences as you advance.</li>
          <li><strong>Winning:</strong> Aim for high score by accurate repetition.</li>
        </ol>
        <div class="have-fun">Have fun testing your memory and focus in the Simon Game!</div>
      </div>
    </div>
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
  
  <script>
    const modal = document.getElementById('instructionsModal');
    const btn = document.getElementById('instructionsBtn');
    const closeBtn = document.querySelector('.close-btn');

    btn.onclick = function() {
      modal.style.display = 'block';
    }

    closeBtn.onclick = function() {
      modal.style.display = 'none';
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = 'none';
      }
    }

    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape' && modal.style.display === 'block') {
        modal.style.display = 'none';
      }
    });

  </script>
  <script src="main.js"></script>
</body>

</html>