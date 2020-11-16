<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class Messages {
    public static function get() {
        $pdo = Database::pdo();

        $req = $pdo->prepare('SELECT * FROM MESSAGES');
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function add(String $sender, String $message) {
        $pdo = Database::pdo();

        $req = $pdo->prepare('INSERT INTO MESSAGES (mess, sender) VALUES (:mess, :sender)');
        $req->execute(array('mess' => $message, 'sender' => $sender));
    }
}