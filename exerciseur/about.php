<?php

include_once __DIR__ . '/config/config.php';

?>

<!DOCTYPE html>

<html lang="fr">
    <?php $_TITLE = "À propos" ;include 'modules/include.php' ; ?>
    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>

        <main id="main-about">

            <!-- Faudra ajouter des trucs dedans ça fait un peu vide --> 
            
            <p>
                Ce site web a été réalisé dans le cadre d'un projet étudiant de 2eme année de BUT Informatique, à l'IUT Lyon 1 de Bourg-en-Bresse. <br>
                La police d'écriture utilisée est <a target="_blank" href="https://luciole-vision.com/">Luciole</a>, une police spécialement créée pour les personnes malvoyantes.
            </p>
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?>        
    </body>
</html>