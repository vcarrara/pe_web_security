<?php
require './views/header.php';

session_start();

// S'il y a un nouveau message
if (isset($_POST['message']) && isset($_SESSION['username'])) {
    include_once './models/Messages.php';
    Messages::add($_SESSION['username'], $_POST['message']);
    header("Location: " . $_SERVER['PHP_SELF']);
}

// Si l'utilisateur est connecté
if (isset($_SESSION['username'])) {
    include_once './models/Messages.php';
    $user = $_SESSION['username'];

    // Affichage du bouton de deconnexion et du message de bienvenue
    echo '<div class="container d-flex flex-column p-3">
                <form method="POST" action="/7-cross-site-scripting/deconnexion.php">
                    <button type="submit" class="btn btn-danger">Déconnexion</button>
                </form>
                <h1 class="mb-5">Bienvenue ' . $user . ' !</h1>';
    foreach (Messages::get() as $message) {
        // Variables contenant des classes bootstrap pour styliser les messages
        $margin = $message['sender'] == $user ? 'ml-auto' : '';
        $classes = $message['sender'] == $user ? 'bg-primary text-right' : 'bg-secondary';

        // Affichage des messages
        echo    '<div class="p-3 text-white ' . $classes . ' ' . $margin . ' w-25 mb-2">
                    <span>' . $message['mess'] . '</span>
                </div>
                <small class="text-muted mb-3 ' . $margin . '">' . $message['sender'] . '</small>';
    }

    // Affichage du formulaire d'envoi de messages
    echo    '<form class="mt-5" method="POST" action="">
                <input type="text" name="message" class="form-control w-100 mb-2" placeholder="Un superbe message..." />
                <button type="submit" class="btn btn-primary">Envoyer</btn>
            </form>
        </div>';
} else {
    header('Location: /7-cross-site-scripting/connexion.php');
}

require './views/footer.php';
