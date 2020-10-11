<?php

class Users
{
    private static $users = array(
        array(
            'username' => 'john_doe',
            'password' => '$2y$10$ABkNo88z0EK0xOqo1FqYSuZWpmU0vF9bbpnp8YU8i1H3Zk/PyCj2K'
        ),
        array(
            'username' => 'test',
            'password' => '$2y$10$R09Lsb.PGPhdpzXDVIi/m.T477D2nKQWc6dlBFbjorcbd7GyDaeoS'
        )
    );

    public static function findUser(String $username, String $password) {
        $pdo = new PDO('mysql:host=localhost;dbname=security', 'root', '');

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


        // foreach (Users::$users as $user) {
        //     if ($user['username'] == $username && $user['password'] == password_verify($password, $user['password'])) {
        //         return new User($user['username'], $user['password']);
        //     }
        // }
        // return null;
    }
}
