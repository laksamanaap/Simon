buttonColours = ["red", "blue", "green", "yellow"];
blockPattern = [];
userClickedPattern = [];

// $(".btn").on("click", () => {
//     var userChosenColor = $(this).attr("id");
//     userClickedPattern.push(userChosenColor);
//     console.log(userClickedPattern);
//     // console.log(userChosenColor);
//     // console.log("clicked");
// }) 

/* => Can't work cause in the es6 do not  the this value (does not bind its own this, arguments, super, or new.target) */
/* => https://stackoverflow.com/questions/24900875/whats-the-meaning-of-an-arrow-formed-from-equals-greater-than-in-javas */


$(".btn").on("click", function () {
    var userChosenColor = $(this).attr("id");
    userClickedPattern.push(userChosenColor);
    console.log(userClickedPattern);
    // console.log("clicked");
})

const nextSequence = () => {
    // Random pattern logic
    var randomNumber = Math.floor(Math.random() * 4);
    var randomChosenColor = buttonColours[randomNumber];
    blockPattern.push(randomChosenColor);

    $(`#${randomChosenColor}`).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);

    // Audio play when the button get the same id
    var buttonSound = new Audio("sounds/" + randomChosenColor + ".mp3");
    buttonSound.play();

};

nextSequence();