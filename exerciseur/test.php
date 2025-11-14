<!-- A SUPPRIMER AVANT DE MERGE LA BRANCHE DANS LE MAIN -->

<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE = "Connexion";
include 'modules/include.php' ?>
<?php include 'modules/latex-zone.php' ?>

<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main>
    <?php

    $zone = new LatexZone("test-zone");
    echo $zone->displayTextArea();
    echo $zone->getcontent();

    ?>
</main>

<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>