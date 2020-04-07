<!DOCTYPE html>
<html class="general" lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Register</title>
  <link href="deal-style.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="trans-white">
    <h1>Register</h1><br>

    <form method="post" action="registerUser.php">
      <label>Username</label>
      <input type="text" name="username" required>
      <?php
      if ($postback && strlen($username) < 1) {
        echo "Please enter your username.";
      }
      ?><br/>

      <label>Password:</label>
      <input type="text" name="password" required>
      <?php
      if ($postback && strlen($password) < 1) {
        echo "Please enter your password.";
      }
      ?><br/><br/>

      <input type="hidden" name="postback" value=<?php echo $postback ?>>
      <label> </label>
      <button type="submit">Register</button>
    </form>

    <br/>

    <form method="get" action="login.php">
      <button type="submit">Already have an account? Login here</button>
    </form>
  </div>
</body>
</html>