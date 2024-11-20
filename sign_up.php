<?php
require_once("./config/autoload.php");
require_once "./auth/DbManager.php";

use auth\Users;
use auth\DbManager;

session_start();
unset($_SESSION['verify']);
unset($_SESSION['error']);
unset($_SESSION['created']);
unset($_SESSION['sucess']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_DEFAULT);
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
    $noTel = filter_input(INPUT_POST, 'phone', FILTER_DEFAULT);
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);


    //creation de l'objet personne et ajout dans la base de données via la classe DB Manager CRUD
    $db = new DbManager();
    $personne = new Users($firstname, $name, $email, $noTel, $password);
    try {
        if ($db->ajouteUtilisateur($personne)) {
            $_SESSION['created'] = true;

        } else {
            $_SESSION['error'] = "<p style='color=red;'>Ce compte existe déja, veuillez vous authentifier ici <a href='sign_in.php'>sign in</a></p>";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }

}
?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
</head>
<header>
    <a href="index.php">home</a>
    <?php if (!isset($_SESSION['login'])): ?>
        <a href="sign_in.php">sign in</a>
    <?php endif ?>
</header>
<body>
<form method="post" action="">
    <h4>Welcome, to create an account, please sign up</h4>
    <label for="name">Name</label>
    <br>
    <input type="text" name="name" id="name" required>
    <br>
    <label for="firstname">Firstname</label>
    <br>
    <input type="text" name="firstname" id="firstname" required>
    <br>
    <label for="email">Email</label>
    <br>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="phone">Phone</label>
    <br>
    <input type="tel" name="phone" id="phone" required>
    <br>
    <label for="password">Password</label>
    <br>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" name="submit" value="Create my account">
</form>
<?php if (isset($_SESSION['created']) && isset($_SESSION['succes'])): ?>
<p style="color : green">Succès : Votre compte a été crée, <?php echo $_SESSION['succes']; ?></p>
<?php endif ?>
<?php if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
} ?>
</body>
</html>


