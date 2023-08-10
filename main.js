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
blockPattern = [];
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
    blockPattern = [];
    started = false;
}

// Logic

$(".btn").on("click", function () {
    var userChosenColor = $(this).attr("id");
    userClickedPattern.push(userChosenColor);

    playSound(userChosenColor);
    animatePress(userChosenColor);
    checkAnswer(userClickedPattern.length - 1, userChosenColor);
    console.log(userClickedPattern);
    // console.log(userChosenColor);

})

const nextSequence = () => {
    level++;
    $("#level-title").text("Level " + level);

    // Random pattern logic
    var randomNumber = Math.floor(Math.random() * 4); // 0 -3
    var randomChosenColor = buttonColours[randomNumber];
    blockPattern.push(randomChosenColor);
    console.log(blockPattern)

    $(`#${randomChosenColor}`).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
    playSound(randomChosenColor);

};

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
function checkAnswer(currentLevel, currentColour) {
    if (blockPattern[currentLevel] === userClickedPattern[currentLevel]) {
        console.log("success");
        //4. If the user got the most recent answer right in step 3, then check that they have finished their sequence with another if statement.
        if (userClickedPattern.length === blockPattern.length) {

            //5. Call nextSequence() after a 1000 millisecond delay.
            setTimeout(function () {
                nextSequence();
            }, 1000);
        }
    } else {
        console.log("wrong");
        var wrong = new Audio("sounds/wrong.mp3");
        wrong.play();

        // Game over
        $("body").addClass("game-over");
        setTimeout(() => {
            $("body").removeClass("game-over");
        }, 200);

        // Change level title
        $("#level-title").text("Game Over!,Press Space to Restart")
        $("#level-title").css("font-size", "32px");

        startOver();
    }
}

