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

// Logic

$(".btn").on("click", function () {
    var userChosenColor = $(this).attr("id");
    userClickedPattern.push(userChosenColor);

    playSound(userChosenColor);
    animatePress(userChosenColor);
    // console.log(userClickedPattern);
    // console.log(userChosenColor);
})

const nextSequence = () => {
    level++;
    $("#level-title").text("Level " + level);

    // Random pattern logic
    var randomNumber = Math.floor(Math.random() * 4);
    var randomChosenColor = buttonColours[randomNumber];
    blockPattern.push(randomChosenColor);

    $(`#${randomChosenColor}`).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
    playSound(randomChosenColor);

};

// Function

function playSound(randomChosenColor) {
    var buttonSound = new Audio("sounds/" + randomChosenColor + ".mp3");
    buttonSound.play();
}

function animatePress(currentColour) {
    let buttonAnimate = $(`#${currentColour}`);
    buttonAnimate.addClass("pressed");

    setTimeout(() => {
        buttonAnimate.removeClass("pressed");
    }, 100);
}

// Function