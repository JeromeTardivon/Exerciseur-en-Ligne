<?php
include_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/Database.php';

use db\Database;

$db = Database::getInstance()->getDb();

$_TITLE = "Éditeur Classe";
$class = getClass($db, $_GET['id-class']);
$listStudents = getStudentsFromClass($db, $class['id']);
$teacher = getResponsableFromClass($db, $class['id']);
$activesClassCodes = getClassCodes($db, $class['id']);
$listChapters = getChaptersClass($db, $class['id']);
?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'modules/include.php' ?>
<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main id="main-editor-class">
    <h1><?= $class['name'] ?></h1>
    <h2>Responsable: <?= $teacher['name'] . ' ' . $teacher['surname'] ?></h2>
    <p><?= $class['description'] ?></p>
    <?php
    if ($_SESSION['user']['type'] == "teacher") {
        ?>
        <a class="btn" href="editor-class.php?id-class=<?= $class['id'] ?>">Modifier</a>
    <?php } ?>
    <h3>Chapitres de la classe</h3>
    <ul>
        <?php
        foreach ($listChapters as $chapter) { ?>
            <li class="">
                <div>
                    <a href="chapter.php?id-chapter=<?= $chapter['id'] ?>"><?= $chapter['title'] ?></a>
                </div>
            </li>
        <?php }
        ?>
    </ul>

    <h3 <?= empty($listStudents) ? "hidden" : "" ?>>Liste des étudiants inscrite</h3>
    <ul>
        <?php
        foreach ($listStudents as $student) { ?>
            <li class="">
                <a href="profile.php?id-profil=<?= $student['id_user'] ?>"><?= getUser($db, $student['id_user'])['name'] ?></a>
            </li>
        <?php } ?>
    </ul>
</main>


<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>
