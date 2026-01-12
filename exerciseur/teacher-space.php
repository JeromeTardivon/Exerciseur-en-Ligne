<?php
require_once __DIR__ . '/db/db-connection.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/Database.php';
use db\Database;
$code = "";
if (!isset($_SESSION["user"])) {
    header('Location: /login.php');
    exit();
} else if ($_SESSION["user"]["type"] != "teacher" && $_SESSION["user"]["type"] != "admin") {
    header('Location: /login.php');
    exit();
}

if (isset($_SESSION["code-generated"])) {
    $code = $_SESSION["code-generated"];
}
$db = Database::getInstance();

$classSearch = isset($_GET["class-search"]) ?  $_GET["class-search"] : "";
$listClasses = $db->classSearchFromTeacher($_SESSION['user']['id'], $classSearch);

$chapterSearch = isset($_GET["chapter-search"]) ? $_GET["chapter-search"] : "";
$listChapters = $db->chapterSearchFromTeacher($_SESSION['user']['id'], $chapterSearch);

?>

<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE = "Espace Professeur";
include 'modules/include.php' ?>

<body>

<?php include 'modules/header.php' ?>

<main class="teacher-space">
    <form action="teacher-space.php" method="get">
        <div>
            <!-- sert pour le carré de couleur dans le wireframing, comme ça le bouton "créer classe" reste dans le div -->
            <div>
                <h2>Gérer mes classes</h2>

                <div class="search">
                    <label for="class-search"></label><input class="btn" type="search" id="class-search" name="class-search" placeholder="Rechercher classe" value="<?=$classSearch ?>">
                    <button type="submit" class="btn">Rechercher</button>
                </div>

                <!-- le contenu de la liste sera à changer avec du php pour avoir la liste des classes auquels il a accès -->
                <!-- le nb de li sera en fonction de la hauteur de l'écran -->
                <ul>
                    <?php

                    foreach ($listClasses as $class) { ?>
                        <li class="btn"><a
                                    href="class.php?id-class=<?= $class['id'] ?>"><?= $class['name'] ?></a></li>
                    <?php }
                    ?>
                </ul>
            </div>

            <h2 class="btn"><a href="create-class.php">Créer classes</a></h2>
        </div>

        <div>
            <!-- sert pour le carré de couleur dans le wireframing, comme ça le bouton "créer classe" reste dans le div -->
            <div>
                <h2>Gérer mes chapitres</h2>

                <div class="search">
                    <label for="chapter-search"></label><input class="btn" type="search" id="chapter-search" name="chapter-search" placeholder="Rechercher chapitre" value="<?=$chapterSearch ?>">
                    <button type="submit" class="btn">Rechercher</button>
                </div>

                
                <ul>
                    <?php

                    foreach ($listChapters as $chapter) { ?>
                    
                        <li class="btn"><a
                                    href="chapter-edition.php?id-chapter=<?= $chapter['id'] ?>&exercise-num=1"><?= $chapter['title'] ?></a>
                        </li>
                    <?php }
                    ?>
                </ul>
            </div>

            <h2 class="btn"><a href="chapter-creation.php">Créer chapitres</a></h2>
        </div>
    </form>
    <div <?= $_SESSION["user"]["type"] == "admin" ? "" : "hidden" ?>>
        <form method="post" action="/processing-forms/processing-creation-code-teacher.php">
            <input class="btn" type="submit" value="Créer code pour professeur" name="create-code">
        </form>
        <div <?= empty($code) ? "hidden" : "" ?>>
            <p>Code créé <?= $code ?></p>
        </div>

    </div>
</main>

<?php include 'modules/footer.php' ?>

</body>

</html>