<?php

require 'db.class.php';
$DB = new DB();
session_start();
$user = $_SESSION['auth'];
$id = $user->id;
$panier = $_SESSION['panier'];
$DB->query('INSERT INTO commands SET id_client = ?, date_created = ?', [$id, date("Y-m-d H:i:s")]);
$command = $DB->query('SELECT * FROM commands ORDER BY id DESC LIMIT 1');
foreach ($panier as $id_product => $quantity) {
    $DB->query('INSERT INTO command_line SET id_command = "' . $command[0]->id . '" , id_product = "' . $id_product . '", quantity = "' . $quantity . '"', []);
    $DB->query('UPDATE products SET stock_quantity = stock_quantity - ' . $quantity . ' WHERE id = "' . $id_product . '"');
}
unset($_SESSION['panier']);
require 'header.php';
echo("Stripe à bien pris en compte votre commande. <a href='/account.php'>Voir ma commande</a>");
require 'footer.php';
