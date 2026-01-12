<?php

use db\Database;

require_once __DIR__ . '/../db/db-connection.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../db/Database.php';
$db = Database::getInstance();

if (!isset($_GET["search"])) {
    $_GET["search"] = "";
}
$search = $_GET["search"];
$res = $db->searchChapitreByTitleDesc($search);
?>
<!DOCTYPE html>
<html lang="fr">
<?php $_TITLE = "Recherche de Chapitre";
include '../modules/include.php' ?>

<body>
<!-- nav -->
<?php include '../modules/header.php' ?>
<main id="chapter-search">
    <form action="/processing-forms/processing-chapter-search.php" method="get">
        <div>
            <label class="titleSearchBar" for="exerciseSearchBar">Rechercher un chapitre</label>
            <div>
                <input type="search" id="exerciseSearchBar" name="search" class="btn">
                <button type="submit" class="btn">Rechercher</button>
            </div>
        </div>
    </form>
    <h2>Résultats</h2>
    <?php if (count($res) == 0) { echo "<p>il n'y a aucun chapitre avec '$search'</p>";} ?>
    <ol>
        <?php foreach ($res as $r) { echo "<li>" . $r['title'] . " ; " . $r['description'] . "</li>"; } ?>
    </ol>
</main>

<!-- footer -->
<?php include '../modules/footer.php' ?>
</body>
</html>