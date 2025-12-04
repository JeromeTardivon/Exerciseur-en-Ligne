<?php

require_once __DIR__ . '/../db/db-connection.php';
require_once __DIR__ . '/../config/config.php';

if (!isset($_GET["search"])) {
    $_GET["search"] = "";
}

$command = $db->prepare("SELECT c.title, c.description FROM exercise e JOIN chapter c ON e.id_chapter = c.id WHERE 
                                (c.title LIKE concat('%', :title, '%') OR c.description LIKE concat('%', :title, '%')) AND c.visible = TRUE ");
$command->execute([
    "title" => $_GET["search"]
]);

$res = $command->fetchAll();

?>

<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE="Recherche de Chapitre";include '../modules/include.php' ?>

    <body>
        <!-- nav -->
        <?php include '../modules/header.php' ?>

        <main id="chapter-search">
            <form action="/processing-forms/processing-chapter-search.php" method="get">
                <div>
                    <!-- @Bastien changement de h2 dans le label parce que c'est interdit ça bonne journée-->
                    <label for="search"><h2>Rechercher un chapitre</h2></label>

                    <div>
                        <input type="search" id="exerciseSearchBar" name="search" class="btn">
                        <button type="submit" class="btn">Rechercher</button>
                    </div>
                </div>
            </form>

            <h2>Résultats</h2>

            <ol>
                <?php
                    foreach ($res as $r) {
                        echo "<li>" . $r['title'] . " ; " . $r['description'] . "</li>";
                    }
                ?>
            </ol>
        </main>

        <!-- footer -->
        <?php include '../modules/footer.php' ?>
    </body>
</html>