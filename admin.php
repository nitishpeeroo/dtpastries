<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require 'header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['auth']) && $_SESSION['auth']->id_role != 2) {
    $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'acceder à cette page";
    header('Location:register.php');
    exit();
}
if (isset($_POST)) {
    if (isset($_POST['addProduct'])) {
        $product_name = $_POST['name'];
        $product_price = $_POST['price'];
        $product_quantity = $_POST['quantity'];
        $product_category = $_POST['category'];
        $DB->query('INSERT INTO products SET name = ?, price = ?, id_category = ?, stock_quantity = ?', [$product_name, $product_price, $product_category, $product_quantity]);
        $lastId = $DB->query('SELECT id from products ORDER BY id DESC LIMIT 1');
        $tmp_name = $_FILES["picture"]["tmp_name"];
        move_uploaded_file($tmp_name, "img/" . $lastId[0]->id . ".jpg");
    }
    if (isset($_POST['ManageProduct'])) {
        $product_id = $_POST['ManageProduct'];
        $stock = $_POST['quantity'];
        $DB->query("UPDATE products SET stock_quantity = ? WHERE id = ?", [$stock, $product_id]);
    }
}
?>
<style>
    body {
        font-family: sans-serif;
        background-color: #eeeeee;
    }

    .file-upload {
        background-color: #ffffff;
        width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
    }

    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }

    .drag-text {
        text-align: center;
    }

    .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
    }

    .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
    }

    .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .remove-image:active {
        border: 0;
        transition: all .2s ease;
    }
</style>
<div style="min-height: 400px;">

    <h1>Bonjour <?php echo $_SESSION['auth']->username; ?></h1>

    <a href="logout.php">Logout</a>
    <form action="" method="post" enctype="multipart/form-data">



        <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <div class="file-upload">
            <h1>Add Product</h1>
            <input type="hidden" name="addProduct">
            <input type="text" name="name" placeholder="Name of Product" required="required">
            <input type="text" name="price" placeholder="Price" required="required">
            <input type="text" name="quantity" placeholder="Quantity" required="required">
            <select name="category">Categories
                <?php
                $categories = $DB->query('SELECT * FROM category');
                foreach ($categories as $key => $categorie) {
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $categorie->category; ?> </option> 
                <?php } ?>
            </select>
            <br><br>
            <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger('click')">Add Image</button>

            <div class="image-upload-wrap">
                <input class="file-upload-input" type='file' name="picture" onchange="readURL(this);" accept="image/*" />
                <div class="drag-text">
                    <h3>Drag and drop a file or select add Image</h3>
                </div>
            </div>
            <div class="file-upload-content">
                <img class="file-upload-image" src="#" alt="your image" />
                <div class="image-title-wrap">
                    <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                </div>
            </div>
            <input type="submit" value="Add Product">
        </div>

    </form>
</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image-upload-wrap').hide();

                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();

                $('.image-title').html(input.files[0].name);
            };

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUpload();
        }
    }

    function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function () {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
        $('.image-upload-wrap').removeClass('image-dropping');
    });

</script>
<!--Gestion des stock ----->
<?php
$products = $DB->query('SELECT * FROM products');
?>
<div style="position: relative;text-align: center;display: block;    min-height: 300px;">
    <table style="    text-align: center;
           position: relative;
           display: inline-block;">
        <tr>
            <td>Name of Product</td>
            <td>Quantity</td>
            <td>Apply</td>
        </tr>
        <?php foreach ($products as $product) { ?>
            <form method="POST" action="">
                <input type="hidden" name="ManageProduct" value="<?php echo $product->id; ?>">
                <tr>
                    <td><?php echo $product->name; ?></td>
                    <td><input type="number" value="<?php echo $product->stock_quantity; ?>" name="quantity"></td>
                    <td><input type="submit" value="Apply"></td>
                </tr>
            </form>
        <?php }
        ?>
    </table>
</div>
<?php require_once 'footer.php'; ?>