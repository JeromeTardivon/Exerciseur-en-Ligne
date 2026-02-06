<?php
include_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/Database.php';

use db\Database;

$db = Database::getInstance();

$_TITLE = "Classe";
$class = $db->getClass($_GET['id-class']);
if (empty($_SESSION["user"])){
    $listStudents = array();
}else{
    $listStudents = $db->getStudentsFromClass($class['id']);
}
$teachers = $db->getResponsableFromClass($class['id']);
$activesClassCodes = $db->getClassCodes($class['id']);
$listChapters = $db->getChaptersClass($class['id']);
$teachersIds = array();
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
        <div id="class-students" <?= (empty($listStudents) || empty($_SESSION["user"])) ? "style = display:none" : "" ?>>
            <h2>Liste des étudiants inscrite</h2>
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
                        <a href="exercise.php?id-chapter=<?= $chapter['id'] ?>&exercise-num=1"><?= $chapter['title'] ?></a>
                        <p><?=$chapter['description']?></p>
                    </div>
                </li>
            <?php }
            ?>
        </ul>
    </div>
    <h2 <?=(isset($_SESSION['user']) && $_SESSION['user']['type'] == "teacher" && in_array($_SESSION['user']['id'], $teachersIds,true)) ?  "" : "hidden" ?>>Generation de codes d'invitation à la classe</h2>
    <div id="class-codes" <?=(isset($_SESSION['user']) && $_SESSION['user']['type'] == "teacher" && in_array($_SESSION['user']['id'], $teachersIds,true)) ?  "" : "style = display:none" ?>>
        <form action="/processing-forms/processing-form-class-edition.php" method="post" <?=(isset($_SESSION['user']) && $_SESSION['user']['type'] == "teacher" && in_array($_SESSION['user']['id'], $teachersIds,true)) ?  "" : 'hidden' ?>>
            <label for="number-usages-code">Nombre d'usages:</label>
            <input  id="number-usages-code" type="number" name="number-usages-code" value="1" min="1" max="67000" step="1">
            <input type="hidden" name="class" value="<?= $class['id'] ?>">
            <input type="submit" name="generate-code-class" value="Créer code">
        </form>
        <div <?=(isset($_SESSION['user']) && $_SESSION['user']['type'] == "teacher" && in_array($_SESSION['user']['id'], $teachersIds,true)) ?  "" : "hidden" ?>>
            <h4 <?=(isset($_SESSION['user']) && $_SESSION['user']['type'] == "teacher" && in_array($_SESSION['user']['id'], $teachersIds,true)) ?  "" : "hidden" ?>>Codes Actifs</h4>
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
    <div <?=(isset($_SESSION['user']) && $_SESSION['user']['type'] == "teacher" && in_array($_SESSION['user']['id'], $teachersIds,true)) ?  "" : "hidden" ?>>
        <?php
        if ($_SESSION['user']['type'] == "teacher" && in_array($_SESSION['user']['id'], $teachersIds,true)) {
            ?>
            <a class="btn" href="editor-class.php?id-class=<?= $class['id'] ?>">Modifier</a>
        <?php } ?>
    </div>
</main>


<!-- footer -->
    <?php include 'modules/footer.php' ?>
    <script> //reseting localstorage in case we come from the 'go back' button (<--)
        localStorage.removeItem('dynamicModules');
    </script>
</body>
</html>
