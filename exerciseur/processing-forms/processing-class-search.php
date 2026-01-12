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
$res = $db->searchClassByTitleDesc($search);
?>

<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE = "Recherche de Chapitre";
include '../modules/include.php' ?>

<body>
<!-- nav -->
<?php include '../modules/header.php' ?>

<main id="class-search">
    <form action="/processing-forms/processing-class-search.php" method="get">
        <div>
            <label class="titleSearchBar" for="classSearchBar">Rechercher une classe</label>
            <div>
                <input type="search" id="classSearchBar" name="search" class="btn">
                <button type="submit" class="btn">Rechercher</button>
            </div>
        </div>
    </form>
    <h2>Résultats</h2>
    <?php if (isset($res) && count($res) == 0) { echo "<p>il n'y a aucune classe avec '$search'</p>";} ?>
    <ol>
        <?php foreach ($res as $r) { echo "<li><a href='/../class.php?id-class=".  $r['id'] . "' >" . $r['name'] . "</a></li>";} ?>
    </ol>
</main>
<!-- footer -->
<?php include '../modules/footer.php' ?>
</body>
</html>