<?php
session_start();
$validLogin = $password = "";

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

date_default_timezone_set("America/New_York");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $postback = $_POST['postback'];
    $validLogin = $_POST['validLogin'];
    $date_time = date("m/d/yy h:ia");
    $id = session_id();

    $row = 1;
    $file = fopen("registration.txt", "r");

    while (($data = fgetcsv($file, 10000, "|")) !== FALSE) {
        if ($username == $data[0] && $password == $data[1]) {
            echo "User:  " . $data[0] . "  Password: " . $data[1] . "<br />\n";
            $validLogin = true;
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            $_SESSION["date_time"] = $date_time;
            $_SESSION["id"] = $id;
            header("location: wheel_start.php");
        }
        {
            $row++;
            $validLogin = false;
        }
    }
    fclose($file);
}

//header("location: registration.php"); exit; //stops page execution

?>


<html class = login>

<head>
    <title>Let''s Play Wheel of Fortune</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="pageContainer centerText">

        <h1 class="focus-in-title" style="font-size: 50px;">Welcome</h1>

        <div>
            <img src="./main_logo.jpeg" class="rotate-90-vertical-bck-main-logo" style="width:70%;height:auto;" />
        </div>

        <h3> Existing users login below to play | New user? <a href="./registration.php"> Click here to register </a></h3>

        <form method="post" class="formLayout">

            <div class="formGroup2">

                <label>Username:</label>

                <input type="text" name="username" width="15" value=<?php if (isset($_POST['username'])) {echo $_POST['username'];} ?>>

                <div class="formGroup2">

                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if ($_POST['postback'] && strlen($_POST['username']) < 1) {
                                echo "Please enter your username";
                            }
                        }
                    ?>

                </div>

                <label>Password:</label>

                <input type="text" name="password" width="15" value=<?php if (isset($_POST['password'])) {echo $_POST['password'];} ?>>

                <div>
                    <?php 
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if ($_POST['postback'] && strlen($_POST['password']) < 1) {
                            echo "Please enter your password";
                            }
                        }
                    ?>
                </div>

                <input type="hidden" name="postback" value="true">

                <label> </label>

                <input type="hidden" name="validLogin">

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (($_POST['postback'] == true) && ($_POST['validLogin'] == false) && (strlen($_POST['username']) > 0) && (strlen($_POST['password']) > 0)) {
                        echo "<div class= 'formGroup2 error' style='text-align:center'>" . "Username and password do not match!" . "</div>";
                    }
                }
                ?>

                <button class="button" type="submit" height="40px" action="./wheel_start.php">Login</button>

            </div>

        </form>

    </div>
</body>

</html>