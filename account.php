<?php
require 'header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['auth'])) {
    $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'acceder à cette page";
    header('Location:register.php');
    exit();
}
?>
<div style="min-height: 600px;">
    <h1>Bonjour <?php echo $_SESSION['auth']->username; ?></h1>
    <a href="logout.php">Logout</a>
    Vos commandes
    <br>
    <br>
    <?php
    $commands = $DB->query('SELECT * FROM commands WHERE id_client = "' . $_SESSION['auth']->id . '"');
    foreach ($commands as $command) {
        ?>
        Commande Numéro <?php echo $command->id; ?>
        <table border="1" cellpadding="1">
            <thead>
                <tr>
                    <th>Name of the product</th>
                    <th>Quanity</th>
                    <th>Picture</th>
                </tr>
            </thead>
            <?php
            $lines = $DB->query('SELECT * FROM command_line WHERE id_command = "' . $command->id . '"');
            ?>
            <tbody>
                <?php
                foreach ($lines as $line) {
                    $pro = $DB->query('SELECT * from products WHERE id = "' . $line->id_product . '" LIMIT 1');
                    ?>
                    <tr>
                        <td><?php echo $pro[0]->name; ?></td>
                        <td><?php echo $line->quantity; ?></td>
                        <td><img src="http://dtpastries.nitishpeeroo.fr/img/<?php echo $line->id_product; ?>.jpg" style="max-height: 50px;"></td>
                    </tr>
                <?php }
                ?>


            </tbody>
        </table>
        <br>
        <br>
    <?php }
    ?>



</div>

<?php require_once 'footer.php'; ?>