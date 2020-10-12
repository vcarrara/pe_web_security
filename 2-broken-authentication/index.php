<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: connexion.php');
}

include_once './views/header.php';
?>

<div class="container mt-5">
    <div class="jumbotron">
        <form method="POST" action="deconnexion.php">
            <button type="submit" name="deconnexion" class="btn btn-danger">Déconnexion</button>
        </form>
        <h2 id="greetings">
            <?php echo 'Bienvenue ' . $_SESSION['username'] . ' !' ?>
        </h2>
    </div>
</div>

<?php
include_once './views/footer.php';
