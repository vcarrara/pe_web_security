<?php
class Database
{
    # Pour Docker
    # $DSN = 'mysql:host=db;dbname=PE_SECURITY';
    private static $DSN = 'mysql:host=localhost;dbname=PE_SECURITY';
    private static $USERNAME = 'pe_user';
    private static $PASSWORD = 'pe_password';

    private static ?PDO $pdo = null;
    public static function pdo()
    {
        if (Database::$pdo == null) {
            Database::$pdo = new PDO(Database::$DSN, Database::$USERNAME, Database::$PASSWORD);
        }
        return Database::$pdo;
    }
}
