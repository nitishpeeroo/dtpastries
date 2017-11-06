<?php
session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = "Vous avez bien  été déconnecter";
header("location:register.php");
