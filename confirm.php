<?php
require 'header.php';
$user_id = $_GET['id'];
$token = $_GET['token'];
$user = $DB->query('SELECT * FROM users WHERE id = ?', [$user_id]);
session_start();
if ($user[0] && $user[0]->confirmation_token == $token) {
    $DB->query('UPDATE users SET confirmation_token = NULL WHERE id = ?', [$user_id]);
    $_SESSION['auth'] = $user;
    $_SESSION['flash']['success'] = "Votre compte à bien été valider";
    header("Location:account.php");
} else {
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header("Location:register.php");
}
?>