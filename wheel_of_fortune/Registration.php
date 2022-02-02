<?php

$usernameErr = $passwordErr = $confirm_passwordErr = $emailErr = $ageErr = $recovery_questionErr = $registration_dateErr = $hintErr = "";
$username = $password = $confirm_password = $email = $age = $recovery_question = $registration_date = $hint = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];
  $email = $_POST["email"];
  $age = $_POST["age"];
  $recovery_question =  $_POST["recovery_question"];
  $registration_date =  $_POST["registration_date"];
  $hint =  $_POST["hint"];
}

if (empty($username) || empty($password) || empty($confirm_password) || empty($email) || empty($age)  || empty($recovery_question) || empty($hint)) {
} else {
  echo " test passed no fields empty";
  $userRegistration = fopen("./registration.txt", "a");
  fputs($userRegistration, $username . "|" . $password . "|" . $confirm_password . "|" . $email . "|" . $age . "|" . $recovery_question . "|" . $registration_date . "|" . $hint . "\r\n");
  fclose($userRegistration);
  header('Location: ./login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["username"])) {
    $usernameErr = "Username is required!";
  } else {
    $username = test_input($_POST["username"]);
  }

  if (empty($_POST["password"])) {
    $passwordErr = "Password is required!";
  } else {
    $password = test_input($_POST["password"]);
  }

  if (empty($_POST["confirm_password"])) {
    $confirm_passwordErr = "Please confirm password entry!";
  } else {
    $confirm_password = test_input($_POST["confirm_password"]);
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email address is required!";
  } else {
    $email = test_input($_POST["email"]);
  }

  if (empty($_POST["age"])) {
    $ageErr = "Age is required!";
  } else {
    $age = test_input($_POST["age"]);
  }

  if (empty($_POST["recovery_question"])) {
    $recovery_questionErr = "Required!";
  } else {
    $recovery_question = test_input($_POST["recovery_question"]);
  }


  if (empty($_POST["hint"])) {
    $hintErr = "Password hint is required!";
  } else {
    $hint = test_input($_POST["hint"]);
  }
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>


<html class="registration">

<head>
  <title>User Registration</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div style="background-image:url('./registration.jpg'); width:100%; height:auto; background-attachment: fixed;">
    <div class="register-centerText focus-in-title">

      <h1 class="focus-in-title" style="font-size:50px;">Welcome</h1>
      <h1>New User Registration</h1> <br>
      <!--<?php echo $_POST['username']; ?> -->

      <form method="post" class="formLayout">
        <div>

          <label>Username:</label>
          <input type="text" name="username" width="25" value=<?php echo $username; ?>>
          <span class="error">
            <?php if (empty($_POST["username"])) {
              echo $usernameErr;
            }
            ?>
          </span>

          <label>Password:</label>
          <input type="password" name="password" width="25" value=<?php echo $password; ?>>
          <span class="error">
            <?php if (empty($_POST["password"])) {
              echo $passwordErr;
            }
            ?>
          </span>

          <label>Confirm Password:</label>
          <input type="password" name="confirm_password" width="25" value=<?php echo $confirm_password; ?>>
          <span class="error">
            <?php
            if (empty($_POST["confirm_password"])) {
              echo $confirm_passwordErr;
            } else {
              if ($_POST["password"] != $_POST["confirm_password"]) {
                echo "Passwords do not match!";
              }
            }
            ?>
          </span>

          <label>Email Address:</label>
          <input type="email" name="email" width="25" value=<?php echo $email; ?>>
          <span class="error">
            <?php
            if (empty($_POST["email"])) {
              echo $emailErr;
            }
            ?>
          </span>

          <label>Registration Date:</label>
          <input type="date" name="registration_date" width="10" value=<?php $month = date('m');
                                                                        $day = date('d');
                                                                        $year = date('Y');
                                                                        echo $today = $year . '-' . $month . '-' . $day; ?> readonly>

          <br><label>Age:</label>
          <input type="number" name="age" min="10" max="99" value=<?php echo $age; ?>>*
          <span class="error">
            <?php
            if (empty($_POST["age"])) {
              echo $ageErr;
            }
            ?>
          </span>
          <br>

          <label for="recovery_question">Password Recovery Question:</label>
          <select id="recovery_question" name="recovery_question" width="25px">
            <option value="">Select a value...</option>
            <option <?php if ($recovery_question == 1) echo 'selected'; ?> value="1">'What is your mother's maiden name?</option>
            <option <?php if ($recovery_question == 2) echo 'selected'; ?> value="2">What is the name of your first pet?</option>
            <option <?php if ($recovery_question == 3) echo 'selected'; ?> value="3">What was your first car?</option>
            <option <?php if ($recovery_question == 4) echo 'selected'; ?> value="4">What elementary school did you attend?</option>
            <option <?php if ($recovery_question == 5) echo 'selected'; ?> value="5">What is the name of the town where you were born?</option>
          </select>

          <span class="error input"> <?php if (empty($_POST["recovery_question"])) {
                                        echo $recovery_questionErr;
                                      } ?>
          </span>
          <br>
          
          <label>Password Hint:</label>
          <input type="text" name="hint" width="25" value=<?php echo $hint; ?>>
          <span class="error"> <?php if (empty($_POST["hint"])) {
                                  echo $hintErr;
                                } ?>
          </span>
          <input type="hidden" name="abandon" value="true">
          <label> </label>
          <br>
          <button name="Register" type="submit" style="margin: 0px 42%;width: 50%">Register</button>

        </div>
        <br>
      </form>
      <br>
      <br>
      <br>
    </div>
</body>

</html>