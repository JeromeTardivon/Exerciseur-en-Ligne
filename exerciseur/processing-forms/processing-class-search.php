<?php

require_once __DIR__ . '/../db/db-connection.php';
require_once __DIR__ . '/../config/config.php';

if (!isset($_GET["search"])) {
    $_GET["search"] = "";
}

$command = $db->prepare("SELECT name FROM class WHERE name LIKE concat('%', :title, '%')");
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

        <main id="class-search">
            <form action="/processing-forms/processing-class-search.php" method="get">
                <div>
                    <label for="search"><h2>Rechercher une classe</h2></label>

                    <div>
                        <input type="search" id="classSearchBar" name="search" class="btn">
                        <button type="submit" class="btn">Rechercher</button>
                    </div>
                </div>
            </form>

            <h2>Résultats</h2>

            <ol>
                <?php
                    foreach ($res as $r) {
                        echo "<li>" . $r['name'] . "</li>";
                    }
                ?>
            </ol>
        </main>

        <!-- footer -->
        <?php include '../modules/footer.php' ?>
    </body>
</html>