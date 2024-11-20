<?php
require_once("./config/autoload.php");
require_once "./auth/DbManager.php";

session_start();
//Réinitalisation de la variable erreur
unset($_SESSION['error']);
unset($_SESSION['sucess']);
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
<header>
    <a href="index.php">Home</a>
    <a href="logout.php">Logout</a>
</header>
<body>
<div>
    <!-- Si le user est loggé, il a accès au contenu-->
    <?php if (isset($_SESSION['login'])) : ?>
        <h1>Bienvenue dans votre dashboard</h1>
        <?php if (isset($_SESSION['verify'])) : ?>
            <p>Votre mail a été vérifé</p>
        <?php endif; ?>
        <p> Where does it come from? Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
    <?php else : ?>
        <!--Proposition de création de compte ou de retour a l'accueil-->
        <h1>Vous n'avez pas accès à ce contenu</h1>
        <button onclick="window.location.href='index.php';">Accueil</button>
        <button onclick="window.location.href='sign_in.php';">Se connecter</button>
        <button onclick="window.location.href='sign_up.php';">Créer un compte</button>
    <?php endif; ?>
</div>
</body>

</html>