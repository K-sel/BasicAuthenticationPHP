<?php
require_once("./config/autoload.php");
require_once './lib/vendor/autoload.php';
use auth\DbManager;

//Initialisation de la session et remise a 0 des variables responsables de l'affichage
session_start();
unset($_SESSION['verify']);
unset($_SESSION['error']);

//Initalisation de la base de données
$db = new DbManager();
//Création de la table utilisateur
$db->creeTableUtilisateur();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Welcome to our website</h1>
    <!--Si l'utilisateur n'est pas encore loggé, on lui propose de se loger ou de se créer un compte-->
    <?php if (!isset($_SESSION['login'])): ?>
    <a href="sign_in.php">Sign in</a>
    <br>
    <a href="sign_up.php">Sign up</a>
    <br>
    <?php endif ?>
    <!--Page contenu-->
    <a href="authentificated.php">page intérieur</a>
</body>
</html>

