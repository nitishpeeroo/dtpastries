<?php
require_once 'db.class.php';
require_once 'class/Panier.php';
$DB = new DB();
$panier = new panier($DB);
?><!DOCTYPE html>
<html>
    <head>
        <title>DT Pastries</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
    </head>

    <body>

        <div id="header">
            <div class="wrap">
                <div class="menu">
                    <a href="index.php" class="logo"><img src="img/DT_Pastries.jpg" style="height: auto;width: 70px;"></a>
                    <h1>Patisserie Secret Inside</h1>
                    <ul class="panier">
                        
                        <li class="caddie"><a href="panier.php">Caddie</a></li>
                        <li class="items">
                            ITEM(S)
                            <span id="count"><?= $panier->count(); ?></span>
                        </li>
                        <li class="total">
                            YOUR BAG
                            <span><span id="total"><?= number_format($panier->total(), 2, ',', ' '); ?></span> $</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        