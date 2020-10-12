<?php
require_once './models/Users.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = Users::findUser($_POST['username'], $_POST['password']);

    // Si un utilisateur est trouvé
    if (isset($username)) {
        session_start();
        $_SESSION['username'] = $username;
        // Redirection à la page d'accueil
        header('Location: index.php');
    } else {
        $error = 'Mauvais identifiant ou mot de passe';
    }
}

include_once './views/header.php';
?>
<div class="container mt-5">
    <?php
    if (isset($error)) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
    ?>

    <form method="POST" action="">
        <input type="text" placeholder="username" class="form-control mb-2" name="username" />
        <input type="password" placeholder="password" class="form-control mb-2" name="password" />
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>


<?php
include_once './views/footer.php';
