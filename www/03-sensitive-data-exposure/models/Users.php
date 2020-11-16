<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class Users
{
    public static function insertUser(String $username, String $password)
    {
        $pdo = Database::pdo();

        $req = $pdo->prepare('SELECT username, pass FROM USERS WHERE username = :username');
        $req->execute(array('username' => $username));
        $result = $req->fetch();

        if ($result) {
            return false;
        }

        $req = $pdo->prepare('INSERT INTO USERS (username, pass) VALUES (:username, :pass)');
        $req->execute(array('username' => $username, 'pass' => $password));
        return true;
    }
}
