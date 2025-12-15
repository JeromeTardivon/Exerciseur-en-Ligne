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
?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'modules/include.php' ?>
<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main id="main-editor-class">
    <h1><?= $class['name'] ?></h1>
    <h3>Responsable: <?= $teacher['name'] . ' ' . $teacher['surname'] ?></h3>
    <form action="/processing-forms/processing-form-class-edition.php" method="post">
        <fieldset>
            <label for="nameClass">Nom de la class:</label>
            <input id="nameClass" type="text" name="className" value="<?= $class['name'] ?>">
            <label for="desc">description</label>
            <textarea id="desc" name="description" rows="10" cols="50"><?= $class['description'] ?></textarea>
        </fieldset>
        <input type="hidden" name="class" value="<?= $class['id'] ?>">
        <input class="btn" type="submit" value="Modifier">
    </form>
    <h2>Ajouter étudiants</h2>
    <ul>
        <?php
        $list = getStudents($db);
        foreach ($list as $student) { ?>
            <li class="">
                <div>
                    <a href="profile.php?id-profil=<?= $student['id'] ?>"><?= $student['name'] ?></a>
                    <form action="/processing-forms/processing-form-class-edition.php" method="post">
                        <input type="hidden" name="add-student" value="<?= $student['id'] ?>">
                        <input type="hidden" name="class" value="<?= $class['id'] ?>">
                        <input class="btn" type="submit" value="Ajouter">
                    </form>
                </div>
            </li>
        <?php }
        ?>
    </ul>
    <div>
        <h2 <?= isset($_SESSION['studentsToAdd']) ? "" : "hidden" ?>>Liste des étudiants à ajouter</h2>
        <ul>
            <?php
            if (isset($_SESSION['studentsToAdd'])) {
                foreach ($_SESSION['studentsToAdd'] as $student) { ?>
                    <li class="">
                        <div>
                            <a href="profile.php?id-profil=<?= $student ?>"><?= getUser($db, $student)['name'] ?></a>
                            <form action="/processing-forms/processing-form-class-edition.php" method="post">
                                <input type="hidden" name="delete-student" value="<?= $student ?>">
                                <input type="hidden" name="class" value="<?= $class['id'] ?>">
                                <input class="btn" type="submit" value="Supprimer">
                            </form>
                        </div>
                    </li>
                <?php }

            } ?>
        </ul>
        <form action="/processing-forms/processing-form-class-edition.php"
              method="post" <?= isset($_SESSION['studentsToAdd']) ? "" : "hidden" ?>>
            <input type="hidden" name="add-student-db" value="true">
            <input type="hidden" name="class" value="<?= $class['id'] ?>">
            <input class="btn" type="submit" value="Ajouter les étudiants">
        </form>
    </div>

    <h2 <?= empty($listStudents) ? "hidden" : "" ?>>Liste des étudiants inscrite</h2>
    <ul>
        <?php
        foreach ($listStudents as $student) { ?>
            <li class="">
                <div>
                    <a href="profile.php?id-profil=<?= $student['id_user'] ?>"><?= getUser($db, $student['id_user'])['name'] ?></a>
                    <form action="/processing-forms/processing-form-class-edition.php" method="post">
                        <input type="hidden" name="delete-student-db" value="<?= $student['id_user'] ?>">
                        <input type="hidden" name="class" value="<?= $class['id'] ?>">
                        <input class="btn" type="submit" value="Supprimer">
                    </form>
                </div>
            </li>
        <?php } ?>
    </ul>
    <div>
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
