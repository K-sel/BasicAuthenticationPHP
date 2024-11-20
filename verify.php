<?php
use \auth\DbManager;
require_once("./config/autoload.php");
require_once './lib/vendor/autoload.php';

session_start();

$db = new DbManager();
$token = $_GET['token'] ?? '';

if ($db->checkToken($token)) {
    $_SESSION['login'] = true;
    $_SESSION['verify'] = true;
    header('Location: ./authentificated.php');
} else {
    header('Location: ./index.php');
}

