<!DOCTYPE html>
<?php
session_start();
if ($_SESSION["error"] && $_SESSION["submitCount"] > 0) {
  echo "<div class=\"trans-white\">";
  echo "<h1>";
  echo $_SESSION["error"];
  echo "</h1>";
  echo "</div>";
}
?>

<html class="general" lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Login</title>
  <link href="deal-style.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="trans-white">
    <h1>Login</h1><br>

    <form method="post" action="validateLogin.php">
      <label>Username</label>
      <input type="text" name="username" required>
      <?php
      if ($postback && strlen($username) < 1) {
        echo "Please enter your username.";
      }
      ?> <br>
      <label>Password:</label>
      <input type="text" name="password" required>
      <?php
      if ($postback && strlen($password) < 1) {
        echo "Please enter your password."; 
      }
      ?><br/><br/>

      <input type="hidden" name="postback" value=<?php echo $postback ?>>
      <label> </label>
      <button type="submit" name="login">Login</button>
    </form>

    <br/>

    <form method="get" action="register.php">
      <button type="submit">Don't have an account? Sign up here</button>
    </form>
  </div>
</body>

</html>