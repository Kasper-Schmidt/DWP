<?php require("connection.php");
require_once("classes/SessionHandle.php");
require_once("classes/DbCon.php");
require_once("classes/Redirector.php");
require_once("classes/LoginUser.php");

spl_autoload_register(function ($class) {
    include "classes/" . $class . ".php";
});
$session = new SessionHandle();

// Se efter logud nøgleord og log brugeren ud, hvis == 1
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    $logout = new Logoutor();
    $msg = "You are now logged out.";
} elseif ($session->logged_in()) {
    $redirect = new Redirector("index.php");
}

// START FORM PROCESSING
if (isset($_POST['submit'])) { // Form has been submitted.
    $profile = new LoginUser($_POST['Username'], $_POST['Pass']);
    $msg = $profile->message;

    // Log ind som administrator
    $Username = $_POST['Username'];
    $Pass = $_POST['Pass'];

    // Check for administrator credentials (replace these with your own authentication logic)
    if ($Username === 'admin' && $Pass === 'adminpass') {
        $session->logged_in($Username); // Log ind som administrator
        $_SESSION['admin'] = $Username; // Gem admin-session
        $redirect = new Redirector("edit.php"); // Omdirigér til admin-siden
    } else {
        $session->logged_in($Username); // Log ind som almindelig bruger
        $redirect = new Redirector("index.php"); // Omdirigér til brugerens startside
    }
}?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" />
</head>

<body>

    <?php
    if (!empty($msg)) {
        echo "<p>" . $msg . "</p>";
    }
    ?>


    <form action="" method="post">
        <h2>Login</h2>
        <h4>Username:</h4>
        <input type="text" name="Username" maxlength="30" />
        <h4>Password:</h4>
        <input type="password" name="Pass" maxlength="30" />
       <a href="./newuser.php"> <p>Or sign up</p> </a>
        <input type="submit" name="submit" value="Login" />
    </form>
</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url(./img/DWPBaggrund.jpg);
            background-size: cover;
        }

        h2 {
            text-align: center;
        }

        h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: lighter;
            margin: auto;
        }

        form {
            max-width: 400px;
            margin: 150px auto;
            background-color: #ffffff;
            padding: 27px;
            border-radius: 10px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
p {
    font-size: 12px;
    color: #9b9b9b;
    margin-top: -4px;
}
        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #ddb3b3;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 11px;
        }

        input[type="submit"]:hover {
            background-color: #e6cdcd;
        }
    </style>