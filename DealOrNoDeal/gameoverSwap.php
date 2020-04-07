<!DOCTYPE html>
<html class="caseEnd">
<head>
   <meta charset="UTF-8"/>
   <title>Game Over Swap Case</title>
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
   <?php
   session_start();
   $case = $_SESSION["swapCase"];
   $caseValues = $_SESSION["caseValues"];
   $_SESSION["finalAmount"] = $caseValues[$case];
   echo "<div class=\"trans-white\">";
   echo '<h1> Congratulations! You won $' . $caseValues[$case] . '!</h1>';
   echo '<h3> Your original case had $' . $_SESSION["ownerCaseValue"] . '</h3>';
   echo '<form method="get" action="leaderboard.php">
                    <button type="submit">Leaderboard</button>
                    </form>';
   echo "</div>";
   echo "<img class=\"final\" src=\"assets/briefcases/open-briefcase-".$caseValues[$case].".png\"alt=\"Can't display case.\"/>";
   ?>
</body>
</html>