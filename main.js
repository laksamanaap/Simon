// $(".btn").on("click", () => {
//     var userChosenColor = $(this).attr("id");
//     userClickedPattern.push(userChosenColor);
//     console.log(userClickedPattern);
//     // console.log(userChosenColor);
//     // console.log("clicked");
// })

/* => Can't work cause in the es6 (does not bind its own this, arguments, super, or new.target) */
/* => https://stackoverflow.com/questions/24900875/whats-the-meaning-of-an-arrow-formed-from-equals-greater-than-in-javas */


buttonColours = ["red", "blue", "green", "yellow"];
gamePattern = [];
userClickedPattern = [];
var level = 0;
var started = false;

// Start Game

$(document).on("keypress", function (e) {
    if (e.code === "Space") {
        if (!started) {
            $("#level-title").text("Level " + level);
            nextSequence();
            started = true;
        }
    }
});


// Game over

function startOver() {
    level = 0;
    gamePattern = [];
    started = false;
}

// Logic

$(".btn").on("click", function() {
    var userChosenColour = $(this).attr("id");
    userClickedPattern.push(userChosenColour);
  
    playSound(userChosenColour);
    animatePress(userChosenColour);
  
    checkAnswer(userClickedPattern.length-1);
  });

  function nextSequence() {
    userClickedPattern = [];
    level++;
    $("#level-title").text("Level " + level);
    var randomNumber = Math.floor(Math.random() * 4);
    var randomChosenColour = buttonColours[randomNumber];
    gamePattern.push(randomChosenColour);
  
    $(`#${randomChosenColour}`).fadeIn(100).fadeOut(100).fadeIn(100);
    playSound(randomChosenColour);
  }

// Function

function playSound(randomChosenColor) {
    // Play sound when click
    var buttonSound = new Audio("sounds/" + randomChosenColor + ".mp3");
    buttonSound.play();
}

function animatePress(currentColour) {
    // Animation add when click
    let buttonAnimate = $(`#${currentColour}`);
    buttonAnimate.addClass("pressed");

    setTimeout(() => {
        buttonAnimate.removeClass("pressed");
    }, 100);

}

// Pattern Logic
function checkAnswer(currentLevel) {
    // if (gamePattern[currentLevel] === userClickedPattern[currentLevel]) {
    //     if (userClickedPattern.length === gamePattern.length) {
    //         setTimeout(function () {
    //             nextSequence();
    //         }, 1000);
    //     }
    // } else {
    //     console.log("wrong");
    //     var wrong = new Audio("sounds/wrong.mp3");
    //     wrong.play();

    //     // Game over
    //     $("body").addClass("game-over");
    //     setTimeout(() => {
    //         $("body").removeClass("game-over");
    //     }, 200);

    //     // Change level title
    //     $("#level-title").text("Game Over!,Press Space to Restart")
    //     $("#level-title").css("font-size", "32px");

    //     startOver();
    // }
    
    // Fix bug

    if (gamePattern[currentLevel] === userClickedPattern[currentLevel]) {
        if (userClickedPattern.length === gamePattern.length){
          setTimeout(function () {
            nextSequence();
          }, 1000);
        }
      } else {
        playSound("wrong");
        $("body").addClass("game-over");
        $("#level-title").text("Game Over, Press Any Key to Restart");
  
        // Game Over
        setTimeout(function () {
          $("body").removeClass("game-over");
        }, 200);
  
        startOver();
      }
}

