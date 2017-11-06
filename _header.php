<?php
require 'db.class.php';
require 'class/Panier.php';
$DB = new DB();
$panier = new panier($DB);
?>