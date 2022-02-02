<!DOCTYPE html>
<html lang="en" class="leaderboard">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="pageContainer">
        <h1 class="focus-in-title" style="font-size: 50px;">Leader Board</h1>
        <h2 style="text-align: center">Top Scores:</h2>
        </br>
        <?php
            $records = file("leaderBoard.txt", FILE_IGNORE_NEW_LINES);
            $records[] = natsort($records);
            foreach($records as $key => $item) {
                $leader[] =  $item;
            }

            $j = count($leader)-2;
            echo "<table cellspacing='10' style='margin: auto;'>";
            for($i = 1; $i <= 10; $i++) {
                echo "<tr><td>".$i."</td><td>". $leader[$j]."</td></tr>";
                $j--;
            }
            echo "</table>";
         ?>
        <br>
        <br>
        <br>
        <a href="wheel_start.php" class="button">Play again?</a>
    </div>

</body>

</html>