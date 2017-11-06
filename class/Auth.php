<?php

/**
 * Description of Auth
 *
 * @author Nancy
 */
class Auth {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($username, $password, $email, $adress) {
        $password_encrypt = password_hash($password, PASSWORD_BCRYPT);
        $token = Str::str_random(60);
        $this->db->query("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?, adress = ?", [$username, $password_encrypt, $email, $token, $adress]);
        $user = $this->db->query('SELECT * FROM users ORDER BY id DESC LIMIT 1');
        return $user[0];
    }

}
