<?php

class Messages {
    public static function get() {
        $pdo = new PDO('mysql:host=localhost;dbname=security', 'root', '');

        $req = $pdo->prepare('SELECT * FROM MESSAGES');
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function add(String $sender, String $message) {
        $pdo = new PDO('mysql:host=localhost;dbname=security', 'root', '');

        $req = $pdo->prepare('INSERT INTO MESSAGES (mess, sender) VALUES (:mess, :sender)');
        $req->execute(array('mess' => $message, 'sender' => $sender));
    }
}