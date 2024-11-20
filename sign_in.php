<?php
require_once("./config/autoload.php");
require_once "./auth/DbManager.php";
use auth\DbManager;

session_start();
unset($_SESSION['verify']);
unset($_SESSION['error']);

if (isset($_POST['submit'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
    $mdp = filter_input(INPUT_POST, "password", FILTER_DEFAULT);

    $db = new DbManager();

    if ($db->checkPasswordAndMailVerification($mdp, $email)) {
        $_SESSION['login'] = true;
        header('Location: ./authentificated.php');
    }
};

?>

<!doctype html>
<html lang=fr>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign in</title>
</head>
<header>
    <a href="index.php">home</a>
    <?php if (!isset($_SESSION['login'])): ?>
        <a href="sign_up.php">sign up</a>
    <?php endif ?>
</header>
<body>
<form method="post" action="">
    <h4>Welcome back, please login</h4>
    <label for="Email">Email</label>
    <input type="text" name="email" id="email">
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <input type="submit" name="submit" value="Connexion">
</form>
</body>
</html>
