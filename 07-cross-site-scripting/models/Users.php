<?php
require_once './models/Database.php';

class Users {
    public static function findUser(String $username, String $password) {
        $pdo = Database::pdo();

        $req = $pdo->prepare('SELECT username, pass FROM USERS WHERE username = :username');
        $req->execute(array('username' => $username));
        $result = $req->fetch();

        if (!$result) {
            return null;
        } else {
            $passwordValidity = password_verify($password, $result['pass']);

            if (!$passwordValidity) {
                return null;
            }

            return $result['username'];
        }            
    }
}
