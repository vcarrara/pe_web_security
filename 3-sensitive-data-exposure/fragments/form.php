<?php
?>
<form method="POST" action="" oninput='password2.setCustomValidity(password2.value != password.value ? "Les mots de passe doivent être identiques." : "")'>
    <input name="username" placeholder="Nom d'utilisateur" type="text" class="form-control mb-3" required />
    <div class="row">
        <div class="col">
            <input name="password" placeholder="Mot de passe" type="password" class="form-control mb-3" required />
        </div>
        <div class="col">
            <input name="password2" placeholder="Retaper le mot de passe" type="password" class="form-control mb-3" required />
        </div>
    </div>
    <button type="submit" class="btn btn-success">Créer un utilisateur</button>
</form>