<?php
require './fragments/header.php';

session_start();

// Si l'utilisateur est connecté
if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];

    // Affichage du bouton de deconnexion et du message de bienvenue
    echo '<div class="container d-flex flex-column p-3">
                <form method="POST" action="deconnexion.php">
                    <button type="submit" class="btn btn-danger">Déconnexion</button>
                </form>
                <h1 class="mb-5">Bienvenue ' . $user . ' !</h1>';
} else {
    header('Location: connexion.php');
}

require './fragments/footer.php';
?>
