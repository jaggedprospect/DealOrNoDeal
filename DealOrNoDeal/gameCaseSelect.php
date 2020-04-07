<!DOCTYPE html>
<html class="choose">
<head>
   <meta charset="UTF-8"/>
   <title>Case Select</title>
   <link href="deal-style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
   <?php
         session_start();
         echo "<div class=\"trans-white\">";
         echo "<h1> Welcome ";
         echo $_SESSION["username"];
         echo "</h1>";

         start();

         function start(){
            $currentCases = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0); //0 means case not opened yet, 1 means opened
            $caseValues = array(0.01,1,5,10,25,50,100,200,300,400,500,750,1000,2500,5000,7500,10000,15000,25000,50000,75000,100000,250000,500000,750000,1000000);
            $_SESSION["selectedValues"] = array();
            $_SESSION["tableValues"] = $caseValues;
            shuffle($caseValues); //randomizing case values
            $_SESSION["currentCases"] = $currentCases;
            $_SESSION["caseValues"] = $caseValues;
            $_SESSION["offer"] = 0;
            $_SESSION["finalOffer"] = 0;
            echo '<h2> Please select your case (1-26) </h2>';
            echo '<form method="get" action="game.php">';
            echo '<input type="number" id="caseSelected" name="caseSelected" min="1" max="26">';
            echo '<button type="submit">Confirm</button> </form>';
         }

         echo "</div>";
   ?>
</body>
</html>
