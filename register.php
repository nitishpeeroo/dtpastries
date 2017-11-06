<?php
require 'header.php';
require 'class/Auth.php';
require 'class/Mailer.php';
require 'class/Validator.php';
require 'class/Str.php';
if (isset($_SESSION['auth']) && $_SESSION['auth']->id_role == 1) {
    header("location:account.php");
}
if (isset($_SESSION['auth']) && $_SESSION['auth']->id_role == 2) {
    header("location:admin.php");
}
if (!empty($_POST)) {
    $errors = array();
    if (isset($_POST['register'])) {
        $validator = new Validator($_POST);
        $validator->isAlphanumerique('username', "Vous pseudo n'est pas valide (caractère alpha-numérique)");
        if ($validator->isValid()) {
            $validator->isUniq('username', $DB, 'users', 'Ce pseudo est déjà pris');
        }

        $validator->isEmail('email', "Votre email n'est pas valide");
        if ($validator->isValid()) {
            $validator->isUniq('email', $DB, 'users', 'Cette email est déjà pris sur un autre compte');
        }

        $validator->isConfirm('password', "Votre mot de passe n'est pas valide");
        if ($validator->isValid()) {

            $auth = new Auth($DB);
            $user = $auth->register($_POST['username'], $_POST['password'], $_POST['email'], $_POST['adress']);

            $mailer = new Mailer('SSL0.OVH.NET', 587, 'nitish@websiting.fr', 'Websiting123', 'tls');
            $mailer->envoiMail('Confirmation de votre compte', $user->email, "<img height='150' width='150' src='http://dtpastries.nitishpeeroo.fr/img/DT_Pastries.jpg'><br/> Bonjour " . $user->username . ",\n\nAfin de valider votre compte, merci de cliquer sur ce lien: \n\nhttp://dtpastries.nitishpeeroo.fr/confirm.php?id={$user->id}&token={$user->confirmation_token}");
            $_SESSION['flash']['success'] = "Un email de confirmation vous a été envoyer pour valider votre compte";
        } else {
            $errors = $validator->getErrors();
        }
    }
    if (isset($_POST['login'])) {
        $req = $DB->query('SELECT * FROM users WHERE (username =:username OR email =:username) AND confirmation_token IS NULL LIMIT 1', ['username' => $_POST['username']]);
        $user = $req[0];
        if (password_verify($_POST['password'], $user->password)) {
            session_start();
            $_SESSION['auth'] = $user;

            $_SESSION['flash']['success'] = "Vous vous êtes maintenant connecter";
            if ($user->id_role == 2) {
                header('Location:admin.php');
            } else {
                header('Location:account.php');
            }

            exit();
        } else {
            $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrecte";
        }
    }
}
?>          
<style>
    html{
        overflow-y: hidden;
    }
</style>
<div id="main" class="clearfix">
    <div class="register">
        <div class="title">
            <div class="wrap">
                <h2 class="first">Are you a new Customer ?</h2>
                <h2>You have already an account</h2>
            </div>
        </div>
        <div class="bloc">
            <div class="wrap">
                <div class="customer">
                    <?php
                    if (isset($_SESSION['flash'])) {
                        foreach ($_SESSION['flash'] as $type => $message) {
                            ?>
                            <div class="alert alert-<?php echo $type; ?>"><?php echo $message; ?></div>
                            <?php
                        }
                        unset($_SESSION['flash']);
                    }
                    ?>
                    <form method="POST" action="" id="register-form">
                        <input type="hidden" name="register">
                        <div class="input">
                            <label for="name">Name :</label>
                            <input type="text" name="username" value="" id="name"required="required" />
                        </div>

                        <div class="input">
                            <label for="email">Email adress :</label>
                            <input type="text" name="email" value="" id="email" required="required"/>
                        </div>

                        <div class="input">
                            <label for="password">Password :</label>
                            <input type="password" name="password" value="" id="password" required="required"/>
                        </div>
                        <div class="input">
                            <label for="password">Retape Password :</label>
                            <input type="password" name="password_confirm" value="" id="password_confirm" required="required"/>
                        </div>
                        <div class="input">
                            <label for="password">Adress :</label>
                            <input type="text" name="adress" value="" id="adress" required="required"/>
                        </div>

                        <div class="submit">
                            <input type="submit" name="submit" value="Create an account" id="submit" />
                        </div>

                    </form>

                </div>

                <div class="login">
                    <form action="" method="POST">
                        <input type="hidden" name="login">
                        <div class="input">
                            <label for="email">Email adress :</label>
                            <input type="text" name="username" value=""  />
                        </div>

                        <div class="input">
                            <label for="password">Password :</label>
                            <input type="password" name="password" value="" required="required"/>
                        </div>

                        <div class="submit">
                            <input type="submit" name="submit" value="Sign in"  />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?php require 'footer.php'; ?>
<script>
    /*
     * Test avant inscription
     * 
     */
    $(document).ready(function () {

        $('#register-form').on('submit', function (e) {
            /*
             * Validité du mail
             */
            var email = $('#email').val();
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if ((regex.test(email)) === false) {
                e.preventDefault();
                alert('Please insert correct adress mail')
            }
            /*
             * Vérification des mots de passe
             */
            var pass_1 = $('#password').val();
            var pass_2 = $('#password_confirm').val();
            if (pass_1 !== pass_2) {
                e.preventDefault();
                alert('Your passwords are not the same')
            }
            if (pass_1.length < 5) {
                e.preventDefault();
                alert('Please type password with minimum 5 characters')
            }
        });
    });
</script>