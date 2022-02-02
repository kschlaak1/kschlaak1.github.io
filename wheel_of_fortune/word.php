<!-- logic debugger for wheel of fortune -->

<?php

    function getWords(){
        $words = file("wordList.txt");
        $line = $words[rand(0, count($words) - 1)];
        $line = str_replace(' ',null, $line);
        $line=strtoupper($line);
        $letters = str_split($line);
        return $letters;
    }

    function hideLetters($letters) {
        $count = 0;
        $hidden = $letters;
        while ($count < (count($letters))) {
            $hidden = str_replace($hidden [$count], '_', $hidden);
            $count++;
        }
        return $hidden;
    }

    function checkGuess($input, $hidden, $letters) {
        $i = 0;
        $wrong = true;
        while ($i < count($letters)) {
            if ($letters[$i] == $input) {
                $hidden[$i] = $input;
                $wrong = false;
            }
            $i++;
        }
        if($wrong) echo 'Wrong!';
        return $hidden;
    }

    function gameOver($letters, $hidden) {
        if ($hidden==$letters) {
            echo 'GAME OVER!, The Correct word is ';
            foreach($letters as $char) {
                echo $char;
            }
            echo '<br><form method="post"><button type="submit" name="newWord" value = "Try Another Word"></form><br>';
            session_destroy();
        }
    }

    //print_r(getWords());
    //hideLetters(getWords());
    echo '<br>';
    
?>


<html>
    <head>
        <title>Wheel of Fortune!</title>
    </head>
    <body>
    <?php 
    session_start();
    if (isset($_POST['newWord'])) {
        unset ($_POST['letters']);
        session_destroy();
    }
    if (!isset($_SESSION['letters']))  {
        $letters = getWords();
        $_SESSION['letters'] = $letters;
        $_SESSION['hidden'] = hideLetters($letters);
    }
    else {
        if (isset($_POST['input'])) {
            $input = $_POST	['input'];
            $_SESSION['hidden'] = checkGuess(strtoupper($input), $_SESSION['hidden'], $_SESSION['letters']);
            gameOver($_SESSION['letters'], $_SESSION['hidden']);
        }
    }
        $count=0;
		$hidden = $_SESSION['hidden'];
		foreach($hidden as $char ) echo $char. "_";
    ?>
    <br/>
    <form method="post">
        <br/>
        Your Guess: <input name="input" type="text" size="1" maxlength="1">
        <input type="submit" value="Guess" />
        <button value="Try Another word" name="newWord" >
	</form>

    </body>
</html>
