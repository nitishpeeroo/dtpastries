<?php require 'header.php'; ?>
<div id="wrap">
    <div id="menu">
        <ul class="wrap">
            <li> <a href="/">All categories</a> </li>
            <?php
            $categories = $DB->query('SELECT * FROM category');
            foreach ($categories as $key => $categorie) {
                ?>
                <li> <a href="category.php?id=<?php echo $categorie->id; ?>"><?php echo $categorie->category; ?></a> </li>
            <?php } ?>
            <li> <a href="register.php">Register or Login </a> </li>

        </ul>
    </div>
    <div id="ariane">
        <div class="wrap">		
            You are right here : Home
        </div>
    </div>
    <div id="main" class="clearfix">

        <div class="home">
            <div class="row">
                <div class="wrap">
                    <?php $products = $DB->query('SELECT * FROM products'); ?>
                    <?php foreach ($products as $product) { ?>
                        <div class="box">
                            <div class="product full">
                                <a href="#">
                                    <img style="width: 100%;" src="img/<?= $product->id; ?>.jpg">
                                </a>
                                <div class="description">
                                    <?= $product->name; ?>
                                    <a href="#" class="price"><?= number_format($product->price, 2, ',', ' '); ?> $</a>
                                </div>
<!--                                <a href="addpanier.php?id=<?= $product->id; ?>" class="gift addPanier">
                                    Gift
                                </a>
                                <div class="rating">
                                    <span>Rating :</span>
                                    <ul>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#" class="off">5</a></li>
                                    </ul>
                                </div>-->
                                <a class="add addPanier" href="addpanier.php?id=<?= $product->id; ?>">
                                    add
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>


        <?php require 'footer.php'; ?>