<?php
include_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/Database.php';

use db\Database;

$db = Database::getInstance();

$_TITLE = "Éditeur Classe";
$class = $db->getClass($_GET['id-class']);
$listStudents = $db->getStudentsFromClass($class['id']);
$teacher = $db->getResponsableFromClass($class['id']);
$activesClassCodes = $db->getClassCodes($class['id']);
$listChapters = $db->getChaptersClass($class['id']);
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
                <a href="profile.php?id-profil=<?= $student['id_user'] ?>"><?= Database::getInstance()->getUser($student['id_user'])['name'] ?></a>
            </li>
        <?php } ?>
    </ul>

    <div <?=$_SESSION['user']['type'] == "teacher" ?  "" : "hidden" ?>>
        <h2>Generation de codes d'invitation à la classe</h2>
        <form action="/processing-forms/processing-form-class-edition.php" method="post">
            <label>Nombre d'usages:
                <input type="number" name="number-usages-code" value="1" min="1">
            </label>
            <input type="hidden" name="class" value="<?= $class['id'] ?>">
            <input type="submit" name="generate-code-class">
        </form>
        <h4>Codes Actifs</h4>
        <ul>
            <?php
            foreach ($activesClassCodes as $code) { ?>
                <li>
                    <div>
                        <p><?= $code['code'] ?></p>
                        <p><?= $code['num_usage'] ?></p>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>

</main>


<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>
