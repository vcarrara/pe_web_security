<?php
class Database {
    private static $DSN = 'mysql:host=localhost;dbname=security';
    private static $USERNAME = 'root';
    private static $PASSWORD = '';

    private static ?PDO $pdo = null;    
    public static function pdo() {
        if (Database::$pdo == null) {
            Database::$pdo = new PDO(Database::$DSN, Database::$USERNAME, Database::$PASSWORD);
        }
        return Database::$pdo;
    }
}