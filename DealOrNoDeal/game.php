<!DOCTYPE html>
<html class="plain">
<head>
  <meta charset="UTF-8"/>
  <title>Game</title>
  <link href="deal-style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
  <?php session_start();

  // check which case is selected 
  if (isset($_GET["caseSelected"])) {
    $case = $_GET["caseSelected"];
    $_SESSION["caseSelected"] = $case - 1;
    $_SESSION["turn"] = 0;
    $currentCases = $_SESSION["currentCases"];
    $currentCases[$case - 1] = 1;
    $_SESSION["currentCases"] = $currentCases;
    $caseValues = $_SESSION["caseValues"];
    $ownerCase = $_SESSION["caseSelected"];
    $_SESSION["ownerCaseValue"] = $caseValues[$ownerCase];
  }

  // opened case
  $currentCases = $_SESSION["currentCases"];
  if (isset($_GET["caseSelect"])) {
    $valSelected = intval($_GET["caseSelect"]);
    $currentCases[$valSelected - 1] = 1;
    $caseValues = $_SESSION["caseValues"];
    $valueOpened = $caseValues[$valSelected - 1];
    array_push($_SESSION["selectedValues"], $valueOpened); // push value to selected array  
    echo "<div class=\"trans-white-special\">";
    echo '<h2>The case you opened had $' . $valueOpened . '</h2>';
    echo "</div>";
    $_SESSION["currentCases"] = $currentCases;
  }

  echo "<div class=\"trans-white-notop\">";

  // turn logic
  if ($_SESSION["turn"] == 5 || $_SESSION["turn"] == 11 || $_SESSION["turn"] == 17 || $_SESSION["turn"] == 23 || $_SESSION["turn"] == 27 || $_SESSION["turn"] == 29) {
    $_SESSION["offer"] = 1;
  } else {
    $_SESSION["offer"] = 0;
  }
  if ($_SESSION["turn"] == 30) {
    $_SESSION["finalRound"] = 1;
  } else {
    $_SESSION["finalRound"] = 0;
  }
  $_SESSION["turn"] = $_SESSION["turn"] + 1;

  // display info
  if($_SESSION["offer"] == 0){
    $tableValues = $_SESSION["tableValues"];

    echo "<div class=\"opencase\">";
    echo "<img class =\"float-left\" src=\"assets/briefcases/open-briefcase-".$valueOpened.".png\" alt=\"(NO OPEN CASE)\"/>";
    echo "<table class=\"selected\"><tr>";

    for($x = 0; $x < 26; $x++){
      if($x == 6 || $x == 12 || $x == 18 || $x == 24){
        echo "</tr><tr>";
      }
      if(in_array($tableValues[$x], $_SESSION["selectedValues"]) && $x != $_SESSION["caseSelected"]){
        echo "<td class=\"selected\">";
      }else{
        echo "<td>";
      }
      echo $tableValues[$x]."</td>";
    }
    echo "</tr></table></div>";
  }

  // main logic
  if ($_SESSION["offer"] == 1) {
    offer();
  } elseif ($_SESSION["finalRound"] == 1) {
    finalRound();
  } else {
    nextTurn();
  }

  echo "</div>";

  function nextTurn(){
    $caseOfUser = intval($_SESSION["caseSelected"]) + 1;
    echo '<h2> Your case is: case ' . $caseOfUser . '</h2>';
    echo '<h2 style=\"font-style: italic\"> Select one of the available cases to open </h2>';
    echo '<form method="get" action="game.php">';
    $currentCases = $_SESSION["currentCases"];

    // display available cases
    echo "<table class=\"case-table\">";
    echo "<tr>";
    for ($x = 0; $x < 26; $x++) {
      if($x == 13){
        echo "</tr>";
        echo "<tr>";
      }

      echo "<td class=\"case-cell\">";
      if ($currentCases[$x] == 0) {
        $caseNumber = $x + 1;
        echo '<input type="radio" id="' .
          $caseNumber .
          '" name="caseSelect" value="' .
          $caseNumber .
          '" required> <label for="' .
          $caseNumber .
          '">' .
          $caseNumber .
          '</label><br>';
      }
      echo "</td>";
    }
    echo "</tr>";
    echo "</table><br/>";

    echo '<button type="submit">Submit</button>';
    echo '</form>';
  }

  function offer(){
    echo '<h2> The Banker is making you an offer.</h2>';
    $offer = calculateOffer2();
    echo "<img src=\"assets/other/banker.png\" id=\"banker\"/>";
    echo '<h2> Do you accept the offer of $' . round($offer, 2) . '? </h2>';
    $_SESSION["offerAmount"] = $offer;
    $_SESSION["offer"] = 0;
    echo '<form method="get" action="gameoverAccept.php">
                    <button type="submit">Deal</button>
                    </form><br/>';
                  
    echo '<form method="get" action="game.php">
                    <button type="submit">No Deal</button>
                    </form>';
  }

  function finalRound(){
    $otherCase = 1;
    $cases = $_SESSION["currentCases"];

    for ($x = 0; $x < 26; $x++) {
      if ($cases[$x] == 0) {
        $otherCase = $x;
      }
    }

    $_SESSION["swapCase"] = $otherCase;

    echo '<h2> Would you like to open your case or swap cases with the remaining one?</h2>';
    echo '<form method="get" action="gameoverSwap.php">
                    <button type="submit">Swap</button>'; 
    echo "</form>";
    echo '<form method="get" action="gameoverKeep.php">
                    <button type="submit">Open my Case</button>';
    echo "</form>";
  }

  function calculateOffer(){
    $cases = $_SESSION["currentCases"];
    $caseValues = $_SESSION["caseValues"];
    $sum = 0;
    $caseClosed = 0;
    for ($x = 0; $x < 26; $x++) {
      if ($cases[$x] == 0) {
        $sum += $caseValues[$x];
        $caseClosed++;
      }
    }
    return $sum / $caseClosed;
  }

  function calculateOffer2(){
    $cases = $_SESSION["currentCases"];
    $caseValues = $_SESSION["caseValues"]; 
    $playerCaseValue = caseValues[intval($_SESSION["caseSelected"]) + 1];
    $divisor = getDivisor();
    $multiplier = 1;
    $sum = 0; $bigCount = 0; $midCount = 0; $lowCount = 0; $offer = 0;

    for ($x = 0; $x < 26; $x++) {
      if ($cases[$x] == 0) {
        $val = $caseValues[$x];

        if($val >= 100000){
          $bigCount++;
          $val *= 0.75;
        }else if($val < 100000 && $val >= 10000){
          $midCount++;
          $val *= 1;
        }else if($val < 10000 && $val >= 750){
          $lowCount++;
          $val *= 1.5;
        }else{
          $lowCount++;
          $val *= 1.75;
        }

        $sum += $val;
      }
    }

    if($bigCount > $midCount + $lowCount){
      $multiplier = 2;
    }else if($bigCount > $lowCount){
      $multiplier = 1.75;
    }else if($midCount > $lowCount + $bigCount){
      $multiplier = 1.25;
    }

    $offer = ($sum + ($playerCaseValue * 0.8)) / 2;

    return round(($offer / $divisor) * $multiplier);
  }

  function getDivisor(){
    if($_SESSION["turn"] < 6){
      return 30;
    }else if($_SESSION["turn"] < 12){
      return 20;
    }else if($_SESSION["turn"] < 18){
      return 15;
    }else if($_SESSION["turn"] < 24){
      return 10;
    }else if($_SESSION["turn"] < 28){
      return 5;
    }else if($_SESSION["turn"] < 29){
      return 2; 
    }else{
      return 1;
    }
  }
  ?>
</body>
</html>