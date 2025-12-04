<?php
require_once __DIR__ . '/db/db-connection.php';
require_once __DIR__ . '/config/config.php';
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

?>

<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE = "Espace Professeur";
include 'modules/include.php' ?>

<body>

<?php include 'modules/header.php' ?>

<main class="teacher-space">
    <form action="formgteacherspace.php" method="post">
        <div>
            <!-- sert pour le carré de couleur dans le wireframing, comme ça le bouton "créer classe" reste dans le div -->
            <div>
                <h2>Gérer mes classes</h2>

                <input class="btn" type="search" placeholder="Rechercher classe">

                <!-- le contenu de la liste sera à changer avec du php pour avoir la liste des classes auquels il a accès -->
                <!-- le nb de li sera en fonction de la hauteur de l'écran -->
                <ul>
                    <?php
                    $list = getClasses($db, $_SESSION['user']['id']);
                    foreach ($list as $class) { ?>
                        <li class="btn"><a
                                    href="editor-class.php?id-class=<?= $class['id'] ?>"><?= $class['name'] ?></a></li>
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

                <input class="btn" type="search" placeholder="Rechercher chapitre">

                <!-- le contenu de la liste sera à changer avec du php pour avoir la liste des classes auquels il a accès -->
                <!-- le nb de li sera en fonction de la hauteur de l'écran -->
                <ul>
                    <li class="btn"><a href="">Chapitre 1</a></li>
                    <li class="btn"><a href="">Chapitre 2</a></li>
                    <li class="btn"><a href="">Chapitre 1</a></li>
                    <li class="btn"><a href="">Chapitre 2</a></li>
                    <li class="btn"><a href="">Chapitre 1</a></li>
                    <li class="btn"><a href="">Chapitre 2</a></li>
                    <li class="btn"><a href="">Chapitre 1</a></li>
                    <li class="btn"><a href="">Chapitre 2</a></li>
                    <li class="btn"><a href="">Chapitre 1</a></li>
                    <li class="btn"><a href="">Chapitre 2</a></li>
                </ul>
            </div>

            <h2 class="btn"><a href="">Créer chapitres</a></h2>
        </div>

        <div>
            <!-- sert pour le carré de couleur dans le wireframing, comme ça le bouton "créer classe" reste dans le div -->
            <div>
                <h2>Gérer mes sujets</h2>

                <input class="btn" type="search" placeholder="Rechercher sujet">

                <!-- le contenu de la liste sera à changer avec du php pour avoir la liste des classes auquels il a accès -->
                <!-- le nb de li sera en fonction de la hauteur de l'écran -->
                <ul>
                    <li class="btn"><a href="">Sujet 1</a></li>
                    <li class="btn"><a href="">Sujet 2</a></li>
                </ul>
            </div>

            <h2 class="btn"><a href="">Créer sujet</a></h2>
        </div>
    </form>
    <div <?= $_SESSION["user"]["type"] == "admin" ? "" : "hidden" ?>>
        <form method="post" action="/processing-forms/processing-creation-code-teacher.php">
            <input class="btn" type="submit" value="Créer code pour professeur" name="create-code">
        </form>
        <div <?= empty($code) ? "hidden" : "" ?>>
            <p>Code créé --> <?= $code ?></p>
        </div>

    </div>
</main>

<?php include 'modules/footer.php' ?>

</body>

</html>