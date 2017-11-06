<?php require 'header.php'; ?>
<div id="wrap">
    <div id="menu">
        <ul class="wrap">
            <li> <a href="/">All categories</a> </li>
            <?php
            $id = $_GET['id'];
            $categories = $DB->query('SELECT * FROM category');
            foreach ($categories as $key => $categorie) {
                if($id == $key){
                    $ariane = $categorie->category;
                }
                ?>
                <li> <a href="category.php?id=<?php echo $categorie->id; ?>"><?php echo $categorie->category; ?></a> </li>
            <?php } ?>
        </ul>
    </div>
    <div id="ariane">
        <div class="wrap">		
           
            You are right here : <?php echo $ariane; ?>
        </div>
    </div>
    <div id="main" class="clearfix">

        <div class="home">
            <div class="row">
                <div class="wrap">

                    <?php
                    
                    $products = $DB->query('SELECT * FROM products WHERE id_category = ' . $id);
                    ?>
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