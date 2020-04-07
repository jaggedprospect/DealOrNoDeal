<!DOCTYPE html>
<html class="plain">
<head>
    <meta charset="UTF-8"/>
    <link href="deal-style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
    <?php
    session_start();

    $username = $_SESSION["username"];
    $finalAmount = intval($_SESSION["finalAmount"]);
    $onLeaderboard = false;

    echo "<div class=\"trans-white\">";
    echo "<h2 style=\"font-style: italic\">".$username." won $".$finalAmount."</h2>";
    $maxLeaders = 10;
    
    $leaders = array();
    $leaders = pruneLeaders(getLeaders($leaders));

    printLeaders($leaders);

    writeLeaders($leaders);

    echo "<br/><form method=\"get\" action=\"login.php\">
            <button type=\"submit\">Back to Login</button>
        </form>";
    echo "</div>";

    session_destroy();


    function getLeaders($leaders){
        global $onLeaderboard, $username, $finalAmount;

        $file = fopen('leaders.txt','r');

        while (!feof($file)) {
            $line = fgets($file);
            $leaderInfo = explode(",", $line);

            // filter out duplicate scores from same player
            if(($username == $leaderInfo[0] && $finalAmount == $leaderInfo[1]) 
            || $username == null){
                $onLeaderboard = true;
            }

            if(!$onLeaderboard && $finalAmount > $leaderInfo[1]){
                $onLeaderboard = true;
                array_push($leaders, $username.",".$finalAmount);
                array_push($leaders, $line);
            }else if(!$onLeaderboard && $finalAmount == $leaderInfo[1]){
                $onLeaderboard = true;
                array_push($leaders, $line);
                array_push($leaders, $username.",".$finalAmount);
            }else{
                array_push($leaders, $line);
            }
        }

        if(!$onLeaderboard){
            array_push($leaders, $username.",".$finalAmount);
        }

        fclose($file);

        return $leaders;
    }

    function pruneLeaders($leaders){
        global $maxLeaders;

        while(sizeof($leaders) > $maxLeaders){
            array_pop($leaders);
        }

        return $leaders;
    }

    function printLeaders($leaders){
        echo "<h1>Leaderboard</h1>";
        echo "<table class=\"score-table\">";

        foreach($leaders as $element){
            $leaderInfo = explode(",", $element);

            if(trim($leaderInfo[0]) != "" && trim($leaderInfo[0]) != null){
                echo "<tr><td class=\"left\">";
                echo $leaderInfo[0];
                echo "</td><td class=\"right\">"; 
                echo "$ ".trim($leaderInfo[1]);
                echo "</td></tr>";
            }
        }

        echo "</table>";
    }

    function writeLeaders($leaders){
        $file = fopen('leaders.txt','w');

        foreach($leaders as $element){
            $element = trim($element)."\r\n";
            fputs($file, $element);
        }

        fclose($file);
    }
    ?>
</body>
</html>