<?php
require './fragments/header.php';
?>

<div class="container mt-5">
    <form method="GET" action="">
        <input type="text" placeholder="1+2" class="form-control mb-2" name="calcul" />
        <button type="submit" class="btn btn-primary">Calculer</button>
    </form>
    <?php
    if (isset($_GET['calcul'])) {
        $str = $_GET['calcul'];
        eval('$result = ' . $str . ';');
        echo "<h3>Le résultat est : $result</h3>";
    }
    ?>
</div>

<?php
require './fragments/footer.php';