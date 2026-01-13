<?php
include_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/Database.php';

use db\Database;

$db = Database::getInstance();

$_TITLE = "Classe";
$class = $db->getClass($_GET['id-class']);
$listStudents = $db->getStudentsFromClass($class['id']);
$teachers = $db->getResponsableFromClass($class['id']);
$activesClassCodes = $db->getClassCodes($class['id']);
$listChapters = $db->getChaptersClass($class['id']);
$teachersIds = [];
foreach ($teachers as $teacher) {
    $teachersIds[] = $teacher['id'];
}
?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'modules/include.php' ?>
<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main id="main-class">
    <div id="class-info">
        <h1><?= $class['name'] ?></h1>
        <p><?= $class['description']?></p>
    </div>
    <div class="display-row">
        <div id="class-responsable">
            <h2>Responsable(s) </h2>
            <?php foreach ($teachers as $teacher) {echo "<h3>".$teacher['name'] . ' ' . $teacher['surname']."</h3>";} ?>
        </div>
        <div id="class-students">
            <h2 <?= empty($listStudents) ? "hidden" : "" ?>>Liste des étudiants inscrite</h2>
            <ul>
                <?php
                foreach ($listStudents as $student) { ?>
                    <li class="">
                        <a href="profile.php?id-profil=<?= $student['id_user'] ?>"><?= Database::getInstance()->getUser($student['id_user'])['name'] ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <h2 <?= empty($listChapters) ? "hidden" : "" ?>>Chapitres de la classe</h2>
    <div id="class-chapitres"  <?= empty($listChapters) ? "hidden" : "" ?>>
        <ul>
            <?php
            foreach ($listChapters as $chapter) { ?>
                <li class="">
                    <div>
                        <a href="chapter.php?id-chapter=<?= $chapter['id'] ?>"><?= $chapter['title'] ?></a>
                        <p><?=$chapter['description']?></p>
                    </div>
                </li>
            <?php }
            ?>
        </ul>
    </div>
    <h2>Generation de codes d'invitation à la classe</h2>
    <div id="class-codes" <?=($_SESSION['user']['type'] == "teacher" && in_array($_SESSION['user']['id'], $teachersIds,true)) ?  "" : "hidden" ?>>
        <form action="/processing-forms/processing-form-class-edition.php" method="post">
            <label for="number-usages-code">Nombre d'usages:</label>
            <input  id="number-usages-code" type="number" name="number-usages-code" value="1" min="1" max="67000" step="1">
            <input type="hidden" name="class" value="<?= $class['id'] ?>">
            <input type="submit" name="generate-code-class" value="Créer code">
        </form>
        <div>
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
    </div>
    <div>
        <?php
        if ($_SESSION['user']['type'] == "teacher" && in_array($_SESSION['user']['id'], $teachersIds,true)) {
            ?>
            <a class="btn" href="editor-class.php?id-class=<?= $class['id'] ?>">Modifier</a>
        <?php } ?>
    </div>
</main>


<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>
