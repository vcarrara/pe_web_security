<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class Users
{
    public static function connection(String $username, String $password)
    {
        $pdo = Database::pdo();

        $query = "SELECT username FROM USERS WHERE username = '" . $username . "' AND pass = '" . $password . "'";

        $req = $pdo->prepare($query);
        $req->execute();
        $result = $req->fetch();

        if (!$result) {
            return null;
        } else {
            return $result['username'];
        }
    }
}
