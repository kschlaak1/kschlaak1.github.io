<?php
/*Framework for register and login validation with mysql oberved from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */

require_once "connect.php"; //ensure connection to mysql

$username = $password = $confirm_password = "";
$usernameErr = $passwordErr = $confirmErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $usernameErr = "Create a username";
    } else {
        $sql = "SELECT id FROM account WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_username); //binds string parameter to username

            $param_username = trim($_POST["username"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $usernameErr = "Choose a different username";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Try again later";
            }
            $stmt->close();
        }
    }

    if (empty(trim($_POST["password"]))) {
        $passwordErr = "Create a password";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirmErr = "Must confirm";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($passwordErr) && ($password != $confirm_password)) {
            $confirmErr = "Passwords must match";
        }
    }
    if (empty($usernameErr) && empty($passwordErr) && empty($confirmErr)) { //if no errors then values are passed to table
        $sql = "INSERT INTO account (username, password) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $param_username, $param_password); //binds username and  password parameters to their own string

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); //hashes the stored password value

            if ($stmt->execute()) {
                session_start();
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["validated"] = true;
                header("location: life.php");
                exit;
            } else {
                echo "Try again";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div>
        <h1>Sign Up</h1>

        <form method="post" class="formLayout">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo $username; ?>">
                <span class="error"><?php echo $usernameErr; ?></span>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="<?php echo $password; ?>">
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            <div>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm" value="<?php echo $confirm_password; ?>">
                <span class="error"><?php echo $confirmErr; ?></span>
            </div>
            <div>
                <input type="submit" value="Register">
                <input type="button" value="Reset" onclick="customReset()">
            </div>
            <p><a href="login.php">Login here</a> if you already have an account</p>
        </form>
        <script>
            function customReset() {
                document.getElementById("username").value = "";
                document.getElementById("password").value = "";
                document.getElementById("confirm").value = "";
            }
        </script>
    </div>

</body>

</html>