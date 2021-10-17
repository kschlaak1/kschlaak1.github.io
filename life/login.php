<?php
session_start();

if (isset($_SESSION["validated"]) && $_SESSION["validated"] === true) {
    header("location: life.php");
    exit;
}

require_once "connect.php"; //ensures connection to mysql
$username = $password = "";
$usernameErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $usernameErr = "Enter your username";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $passwordErr = "Enter your password";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($usernameErr) && empty($passwordErr)) { //search for credentials if no errors are shown
        $sql = "SELECT id, username, password FROM account WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_username); //binds string parameter to username
            $param_username = $username;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) { //validates if entered password matches the hashed password               
                            session_start();
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["validated"] = true;
                            header("location: life.php");
                            exit;
                        } else {
                            $passwordErr = "Incorrect password";
                        }
                    }
                } else {
                    $usernameErr = "Account not found";
                }
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
    <title>Sign in</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div>
        <h1>Login</h1>
        <form method="post" class="formLayout">
            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span class="error"><?php echo $usernameErr; ?></span>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password">
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
            <p><a href="register.php">Sign up here</a> if you don't have an account</p>
        </form>
    </div>
</body>

</html>