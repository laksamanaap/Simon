// var script = document.createElement("script");
// script.src = "https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js";

buttonColours = ["red", "blue", "green", "yellow"];
gamePattern = [];
userClickedPattern = [];
let level = 0;
var started = false;

// Escape HTML to prevent XSS
function escapeHtml(text) {
  var map = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#039;",
  };
  return text.replace(/[&<>"']/g, function (m) {
    return map[m];
  });
}

function loadLeaderboard() {
  console.log("Loading leaderboard...");

  $.ajax({
    url: "get_leaderboard.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log("Leaderboard data received:", data);
      displayLeaderboard(data);
    },
    error: function (xhr, status, error) {
      console.error("Error loading leaderboard:", status, error);
      console.error("Response:", xhr.responseText);
      $("#leaderboard-content").html(
        '<p style="text-align: center; font-size: 11px; color: #ff3838;">Error loading data</p>'
      );
    },
  });
}

function displayLeaderboard(data) {
  let html = "";

  if (!data || data.length === 0) {
    html =
      '<p style="text-align: center; font-size: 11px; color: #888;">No scores yet. Be the first!</p>';
  } else {
    data.forEach(function (item, index) {
      rankEmoji = `#${index + 1}`;

      let currentUserClass = item.is_current ? "current-user" : "";
      let topThreeLeaderboard = [0, 1, 2];

      const spanClass = topThreeLeaderboard.includes(index)
        ? "rank-top-three"
        : "rank";

      html += `
        <div class="leaderboard-item ${currentUserClass}">
          <span class="${spanClass}">#${index + 1}</span>
          <span class="username">${escapeHtml(item.username)}</span>
          <span class="score">${item.score}</span>
        </div>
      `;
    });
  }

  $("#leaderboard-content").html(html);
}

function updateScore(score) {
  console.log("Updating score:", score);

  $.ajax({
    url: "update_score.php",
    type: "POST",
    data: { score: score },
    dataType: "json",
    success: function (response) {
      console.log("Score updated:", response);
      loadLeaderboard();
    },
    error: function (xhr, status, error) {
      console.error("Error updating score:", status, error);
      console.error("Response:", xhr.responseText);
    },
  });
}

$(document).ready(function () {
  console.log("Document ready!");
  console.log("jQuery version:", $.fn.jquery);

  loadLeaderboard();

  setInterval(loadLeaderboard, 3000);
});

// Start Game
$("#start-game").on("click", function (e) {
  e.preventDefault();
  console.log("Start game clicked");

  if (!started) {
    $("#level-title").text("Level " + level);
    $("#level-title").css("font-size", "48px");
    nextSequence();

    started = true;
  }
});

// Button Click Handler
$(".btn").on("click", function () {
  if (started) {
    var userChosenColour = $(this).attr("id");
    console.log("Button clicked:", userChosenColour);

    userClickedPattern.push(userChosenColour);

    playSound(userChosenColour);
    animatePress(userChosenColour);

    console.log(userClickedPattern.length, "LENGTH USER CLICKED PATTERN");
    checkAnswer(userClickedPattern.length - 1);
  }
});

function nextSequence() {
  userClickedPattern = [];
  level++;

  console.log("Next sequence - Level:", level);

  $("#level-title").text("Level " + level);
  $("#display-score").text(level - 1);

  var randomNumber = Math.floor(Math.random() * 4);
  var randomChosenColour = buttonColours[randomNumber];
  gamePattern.push(randomChosenColour);

  console.log("Game pattern:", gamePattern);

  $(`#${randomChosenColour}`).fadeIn(100).fadeOut(100).fadeIn(100);
  playSound(randomChosenColour);
}

function playSound(randomChosenColor) {
  try {
    var buttonSound = new Audio("sounds/" + randomChosenColor + ".mp3");
    buttonSound.play().catch(function (error) {
      console.warn("Audio play failed:", error);
    });
  } catch (error) {
    console.warn("Audio error:", error);
  }
}

function animatePress(currentColour) {
  let buttonAnimate = $(`#${currentColour}`);
  buttonAnimate.addClass("pressed");

  setTimeout(() => {
    buttonAnimate.removeClass("pressed");
  }, 100);
}

function checkAnswer(currentLevel) {
  console.log(
    "Checking answer - Current:",
    userClickedPattern[currentLevel],
    "Expected:",
    gamePattern[currentLevel]
  );

  if (gamePattern[currentLevel] === userClickedPattern[currentLevel]) {
    console.log("Correct!");

    if (userClickedPattern.length === gamePattern.length) {
      console.log("Sequence complete!");
      setTimeout(function () {
        nextSequence();
      }, 1000);
    }
  } else {
    let finalScore = level - 1;
    console.log("Game Over! Final score:", finalScore);

    playSound("wrong");
    $("body").addClass("game-over");

    $("#level-title").html(
      `  Game Over!<br>Score: ${finalScore}<br><a href='#' id='restart'>Restart</a>`
    );
    $("#level-title").css("font-size", "32px");
    $("#display-score").text(finalScore);

    updateScore(finalScore);

    setTimeout(function () {
      $("body").removeClass("game-over");
    }, 500);

    $(document)
      .off("click", "#restart")
      .on("click", "#restart", function (e) {
        e.preventDefault();
        console.log("Restarting game...");

        startOver();
        $("#level-title").text("Level " + level);
        $("#level-title").css("font-size", "48px");
        nextSequence();
        started = true;
      });

    startOver();
  }
}

function startOver() {
  console.log("Starting over...");
  level = 0;
  gamePattern = [];
  userClickedPattern = [];
  started = false;
}
