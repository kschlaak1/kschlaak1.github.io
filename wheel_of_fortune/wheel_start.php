<?php
session_start();
ob_start();

$rand_deg = 0;
$letters = "";
$guessInput = "";
$score = 0;
$hidden = "";

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'User Unknown!';
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

if (!isset($_SESSION['guessResponse'])) {
    $_SESSION['guessResponse'] = "";
}

$wheel_array = [
    15 => 550, 30 => 800, 45 => 300, 60 => 700, 75 => 900, 
    90 => 500, 105 => 5000, 120 => "Bankrupt", 135 => 300, 
    150 => 500, 165 => 450, 180 => 500, 195 => 800, 
    210 => "Lose a Turn", 225 => 700, 240 => "Free Play",
    255 => 650, 270 => "Bankrupt", 285 => 900, 300 => 500,
    315 => 350, 330 => 600, 345 => 500, 360 => 400
];

$_SESSION['wheel_array'] = $wheel_array;

function getWords()
{
    $words = file("wordList.txt", FILE_IGNORE_NEW_LINES);
    $line = $words[rand(0, count($words) - 1)];
    $line = str_replace(' ', '|', $line);
    $line = strtoupper($line);
    $letters = str_split($line);
    return $letters;
}

function hideLetters($letters)
{
    $count = 0;
    $hidden = $letters;
    foreach ($hidden as $findNonChar)
        if ($findNonChar == '|') {
            $count++;
        } else {
            $hidden = str_replace($hidden[$count], '_', $hidden);
            $count++;
        }
    return $hidden;
}

if (!isset($_SESSION['letters'])) {
    $letters = getWords();
    $_SESSION['letters'] = $letters;
    $_SESSION['hidden'] = hideLetters($letters);
} else {
    if (isset($_POST['guessInput'])) {
        $guessInput = $_POST['guessInput'];
        $_SESSION['hidden'] = checkGuess(strtoupper($guessInput), $_SESSION['hidden'], $_SESSION['letters']);
    }
}

$count = 0;
$hidden = $_SESSION['hidden'];

if (isset($_POST['newpuzzle'])) {
    unset($_SESSION['hidden']);
    unset($_SESSION['letters']);
    $_SESSION['score'] = 0;
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Wheel of Fortune</title>
    <link rel='stylesheet' type='text/css' href='./wheel_css.php' />

</head>

<body>
    <form method="post" action="./wheel_spin.php">

        <div class="display_background">

            <div class="column left">
                <div class="userInfo">Username: <br><span>
                        <?php echo $_SESSION['username'] ?>
                    </span></div>
                <div class="directionsArea">

                    <div class="directions">
                        <span>Directions:<br><br>
                        If wheel lands on "Bankrupt" you lose all your money.
                        <br>
                        <br>
                        If wheel lands on "Free Play" your score doubles.
                        <br>
                        <br>
                        If wheel lands on "Lose a Turn" your score is reduced by 1/2.
                        </span>
                    </div>
                </div>

                </div>


            <div class="column middle">

                <div id="headerText">Wheel of Fortune</div>
                <div class="gameArea">

                    <table>

                        <tbody class="word">

                            <?php foreach ($_SESSION['hidden'] as $char)
                                if ($char == "|") {
                                    echo "<tr>";
                                    echo "<td class=" . "space" . ">" . $char . "</td>";
                                    echo "</tr>";
                                } else {
                                    echo "<td class=" . "showChar" . ">" . $char . "</td>";
                                }
                            ?>

                        </tbody>
                    </table>
                </div>

                <input type="radio" class="hide" name="placeholder" checked></input>
                <div class="wheel"></div> 
                <div class="ticker"></div>

            </div>

            <div class="column right">
                <div class="scoreArea">Score: $<span> 0 </span></div>
                <div class="playArea">

                    <div class="rightColumn2ndArea">
                        <span>Play Area:<br><br>Click the "Spin Wheel" button to begin playing.
                        </span>

                    </div>

                </div>

            </div>

            <button class="menu_buttons startSpinButton" name="spin_wheel">Spin Wheel</button>
        </div>
    </form>
</body>

</html>
