<?php
session_start();
ob_start();

$rand_deg = 0;
$letters = "";
$guessInput = "";
$score = 0;


if (!isset($_SESSION['letterplayed'])) {
    $_SESSION['letterplayed'] = array();
}
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

function rNum()
{
    global $rand_deg;
    $rand_deg = mt_rand(1, 24) * 15;
    return $rand_deg;
}

$spinValue = rNum();
$_SESSION['spinValue'] = $spinValue;

if (isset($_POST['spinWheel'])) {
    $spinValue = rNum();
    $_SESSION['spinValue'] = $spinValue;
}

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

function checkGuess($guessInput, $hidden, $letters)
{
    global $letterplayed;

    $guessMessage = 0;
    if (!preg_match('/^[a-z]*$/i', $guessInput)) {
        $guessMessage = 5;      // not a valid input
    }
    elseif (in_array($_POST['guessInput'], $_SESSION['letterplayed'])) {
        $guessMessage = 6;      // this letter was already used
    }
    elseif (isset($_POST['vowel'])) {
        if (!preg_match('/^[aeiou]*$/i', $guessInput)) {
            $guessMessage = 1;      //not a vowel
            $guessInput = ' ';
        }
        else {
            if ($_SESSION['score'] > 0) {
                $_SESSION['score'] = $_SESSION['score'] - 250;
                array_push($_SESSION['letterplayed'], $_POST['guessInput']);
                $i = 0;
                while ($i < count($letters)) {
                    if ($letters[$i] == $guessInput) {
                        $hidden[$i] = $guessInput;
                        $guessMessage = 3;      //correct answer
                        
                        calculateScore();
                    } 
                    $i++;
                }
            }
            else {
                $guessMessage = 4;      //not enough money to buy a vowel
                $guessInput = ' ';
            }
        }
    }
    elseif (isset($_POST['consonant'])) {
        if (preg_match('/^[aeiou]*$/i', $guessInput)) {
            $guessMessage = 2;      //not a consonant
            $guessInput = ' ';
        }
        else array_push($_SESSION['letterplayed'], $_POST['guessInput']);
        $i = 0;
        while ($i < count($letters)) {
            if ($letters[$i] == $guessInput) {
                $hidden[$i] = $guessInput;
                $guessMessage = 3;      //correct answer
                
                calculateScore();
            } 
            $i++;
        }
    } 

    guessResponse_Function($guessMessage);

    $file = 'leaderBoard.txt';
    $username = $_SESSION['username'];
    $score = $_SESSION['score'];
    if ($hidden == $letters) {
        file_put_contents($file, $score . " - " . $username . "\n", FILE_APPEND | LOCK_EX);
        unset($_SESSION['hidden']);
        unset($_SESSION['letters']);
        header("Location: leaderBoard.php");
        session_destroy();
    }
    return $hidden;
}

function guessResponse_Function($guessMessage)
{
    if ($guessMessage == 1) {
        $_SESSION['guessResponse'] = "Error: Not a Vowel!";
    } elseif ($guessMessage == 2) {
        $_SESSION['guessResponse'] = "Error: Not a Constant!";
    } elseif ($guessMessage == 3) {
        $_SESSION['guessResponse'] = "Correct!";
    } elseif ($guessMessage == 4) {
        $_SESSION['guessResponse'] = "Not Enough $ to Buy a Vowel!";
    } elseif ($guessMessage == 5) {
        $_SESSION['guessResponse'] = "Error: Please Enter a Valid Letter!";
    } elseif ($guessMessage == 6) {
        $_SESSION['guessResponse'] = "This letter has already been used please try again!";
    }
    else $_SESSION['guessResponse'] = "Wrong, Try Again!";
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
    unset($_SESSION['letterplayed']);
    unset($_SESSION['guessResponse']);
    $_SESSION['score'] = 0;
    header("Location: wheel_start.php");
}

function calculateScore()
{
    if ($_SESSION['wheel_array'][$_SESSION['spinValue']] == "Bankrupt") {
        return $_SESSION['score'] = 0;
    } elseif ($_SESSION['wheel_array'][$_SESSION['spinValue']] == "Free Play") {
        $_SESSION['score'] = $_SESSION['score'] * 2;
        return $_SESSION['score'];
    } elseif ($_SESSION['wheel_array'][$_SESSION['spinValue']] == "Lose a Turn") {
        $_SESSION['score'] = $_SESSION['score'] / 2;
        return $_SESSION['score'];
    } else {
        $_SESSION['score'] += $_SESSION['wheel_array'][$_SESSION['spinValue']];
        return $_SESSION['score'];
    }
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
                <div class="userInfo">
                    Username:<br>
                    <span>
                        <?php echo $_SESSION['username'] ?>
                    </span>
                </div>
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
                            <?php foreach ($hidden as $char)
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

                <input type="radio" class="hide wheelRadioButton" name="game" checked>
                <div class="wheel"></div> 
                <div class="ticker"></div>
            </div>

            <div class="column right">
                <div class="scoreArea">Score: $<span> <?php echo $_SESSION['score']; ?> </span></div>
                <div class="playArea">
                    <div class="rightColumn2ndArea">
                    <?php //echo '<pre>'; print_r($_SESSION['letterplayed']); echo '</pre>'; ?>
                        <div>Play Area:<br><br>Click the "Spin Wheel" button to begin playing.
                            <hr>Select "Consonant" or "Vowel" button and enter the letter below.
                        </div>
                        <input name="guessInput" class="guessInput" maxlength="1" type="text" autofocus></input>
                        <hr>
                    </div>
                    <textarea id="guessResponsetext" name="guessResponseName" disabled><?php echo $_SESSION['guessResponse']; ?></textarea>
                </div>
            </div>

            <button class="menu_buttons" name="newpuzzle" id="newpuzzle" type="submit">New Puzzle</button>
            <button class="menu_buttons" name="consonant">Consonant</button>
            <button class="menu_buttons" name="vowel">Buy Vowel</button>
        </div>

    </form>


</body>

</html>