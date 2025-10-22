<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Simon Game - Login</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
  <style>
    .form-container {
      max-width: 400px;
      margin: 50px auto;
      padding: 30px;
      background: rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      color: white;
    }
    .form-container input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: none;
      font-size: 16px;
    }
    .form-container button {
      width: 100%;
      padding: 12px;
      background: #00a8ff;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }
    .form-container button:hover {
      background: #0097e6;
    }
    .error {
      color: #ff3838;
      font-size: 12px;
      margin-top: -5px;
      margin-bottom: 10px;
    }
    label {
      display: block;
      margin-top: 10px;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="form-container">
    <h1 style="text-align: center; font-size: 24px;">Simon Game</h1>
    <form id="loginForm" method="POST" action="save_user.php">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username">
      <div class="error" id="username-error"></div>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email">
      <div class="error" id="email-error"></div>

      <button type="submit">Start Game</button>
    </form>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#loginForm").on("submit", function(e) {
        e.preventDefault();
        
        $(".error").text("");
        
        let username = $("#username").val();
        let email = $("#email").val();
        let isValid = true;
        
        if (username.length < 3) {
          $("#username-error").text("Username must be at least 3 characters");
          isValid = false;
        }
        
        if (!email.includes("@")) {
          $("#email-error").text("Please enter a valid email");
          isValid =  false;
        }
        
        if (isValid) {
          $.ajax({
            url: 'save_user.php',
            type: 'POST',
            data: {
              username: username,
              email: email
            },
            success: function(response) {
              window.location.href = 'playground.php';
            },
            error: function() {
              alert("Error saving user data");
            }
          });
        }
      });
    });
  </script>
</body>

</html>