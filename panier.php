<?php require 'header.php'; ?>
<div class="checkout">
    <div class="title">
        <div class="wrap">
            <h2 class="first">Shopping Cart</h2>
        </div>
    </div>
    <form method="post" action="panier.php">
        <div class="table">
            <div class="wrap">

                <div class="rowtitle">
                    <span class="name">Product name</span>
                    <span class="price">Price</span>
                    <span class="quantity">Quantity</span>
                    <span class="action">Actions</span>
                </div>

                <?php
                $ids = array_keys($_SESSION['panier']);
                if (empty($ids)) {
                    $products = array();
                } else {
                    $products = $DB->query('SELECT * FROM products WHERE id IN (' . implode(',', $ids) . ')');
                }
                foreach ($products as $product) {
                    ?>
                    <div class="row">
                        <a href="#" class="img"> <img src="img/<?= $product->id; ?>.jpg" height="53"></a>
                        <span class="name"><?= $product->name; ?></span>
                        <span class="price"><?= number_format($product->price, 2, ',', ' '); ?> $</span>
                        <span class="quantity"><input type="text" name="panier[quantity][<?= $product->id; ?>]" value="<?= $_SESSION['panier'][$product->id]; ?>"></span>
                      
                        <span class="action">
                            <a href="panier.php?delPanier=<?= $product->id; ?>" class="del"><img src="img/del.png"></a>
                        </span>
                    </div>
<?php } ?>
                <div class="rowtotal">
                    Total Cart : <span class="total"><?= number_format($panier->total(), 2, ',', ' '); ?> $ </span>
                </div>
                <input type="submit" value="Recalculate">
            </div>
        </div>
    </form>
    <?php
    if (isset($_SESSION['auth'])) {
        $action = "credit_card";
    } else {
        $action = "register";
    }
    ?>
    <form method="post" action="<?php echo $action; ?>.php">
        <input type="submit" value="Checkout">
    </form>
</div>
