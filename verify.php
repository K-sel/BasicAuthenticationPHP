<?php
use \auth\DbManager;
require_once("./config/autoload.php");
require_once './lib/vendor/autoload.php';

session_start();

$db = new DbManager();

//Filtrage du token avec un regex
$token = filter_input(INPUT_GET, 'token', FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[a-f0-9]{32}$/"]]);

//Si le token est valide la sess
if ($db->checkToken($token)) {
    $_SESSION['verify'] = true;
    $_SESSION['sucess'] = "<p style='color : green'>Succès : Votre compte a été vérifié, veuillez vous authentifier,</p>";
    header('Location: ./sign_in.php');
} else {
    header('Location: ./index.php');
}

