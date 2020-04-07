<!DOCTYPE html>
<html class="caseEnd">
<head>
   <title>Game Over Keep Case</title>
   <link href="deal-style.css" rel="stylesheet" type="text/css">

   <style>
      img{
         color: white;
         float: right;
         margin-right: 20%;
      }
   </style>
</head>

<body>
   <?php session_start();
   $case = $_SESSION["swapCase"];
   $caseValues = $_SESSION["caseValues"];
   $_SESSION["finalAmount"] = $_SESSION["ownerCaseValue"];
   echo "<div class=\"trans-white\">";
   echo '<h1> Congratulations! You won $' . $_SESSION["ownerCaseValue"] . '!</h1>';
   echo '<h3> The other case had $' . $caseValues[$case] . '</h3>';
   echo '<form method="get" action="leaderboard.php">
                    <button type="submit">Leaderboard</button>
                    </form>';
   echo "</div>";
   echo "<img class=\"final\" src=\"assets/briefcases/open-briefcase-".$_SESSION["ownerCaseValue"].".png\" alt=\"Can't display case.\"/>";
   ?>
</body>
</html>