<!DOCTYPE html>
<html class="bankerEnd">
<head>
   <meta charset="UTF-8"/>
   <title>Game Over Accept Offer</title>
   <link href="deal-style.css" rel="stylesheet" type="text/css"/>

   <style>
      img{
         color: white;
         float: left;
         margin-left: 20%;
      }
   </style>
</head>

<body>
   <?php session_start();
   $amount = $_SESSION["offerAmount"];
   $_SESSION["finalAmount"] = $amount;
   echo "<div class=\"trans-white\">";
   echo '<h1> Congratulations! You won $' . round($amount, 2) . '!</h1>';
   echo '<h3> Your original case had $' . $_SESSION["ownerCaseValue"] . '</h3>';
   echo '<form method="get" action="leaderboard.php">
                    <button type="submit">Leaderboard</button>
                    </form>';
   echo "</div>";
   echo "<img src=\"assets/other/money-sign.png\"alt=\"Can't display image.\"/>";
   ?>
</body>
</html>