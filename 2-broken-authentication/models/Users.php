<?php
class Users {
    // Simule des données présentes en base de données
    private static $users = array(
        array('username' => 'brokenauth', 'password' => '$2y$10$JVuugxcEt6Bn1B4LXHi6J.LGKM7IR38/kcGxL8KfDFsogycSFqN2e')
    );
    
    public static function findUser(String $username, String $password) {
        foreach (Users::$users as $user) {
            if ($user['username'] == $username && password_verify($password, $user['password'])) {
                return $user['username'];
            }
        }
        return null;
    }
}