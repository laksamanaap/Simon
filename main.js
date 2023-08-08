buttonColours = ["red", "blue", "green", "yellow"];
blockPattern = [];
userClickedPattern = [];

const nextSequence = () => {
    // Random pattern logic
    var randomNumber = Math.floor(Math.random() * 4);
    var randomChosenColor = buttonColours[randomNumber];
    blockPattern.push(randomChosenColor);

    $(`#${randomChosenColor}`).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);

    // Audio play when the button get the same id
    var audio = new Audio("sounds/" + randomChosenColor + ".mp3");
    audio.play();

    $(`#${randomChosenColor}`).on("click", () => {
        console.log("clicked!");
    });
};

nextSequence();