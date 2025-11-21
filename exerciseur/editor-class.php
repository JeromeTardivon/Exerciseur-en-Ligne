<?php
include_once __DIR__ . '/config/config.php';
include_once __DIR__ . '/db/db-connection.php';
$_TITLE = "Éditeur Classe";
$studentsToAdd = array();
$class = getClass($db, $_GET['id-class']);
if (isset($_GET['add-student'])) {
    if (!studentInList($_SESSION['studentsToAdd'], $_GET['add-student'])) {
        $_SESSION['studentsToAdd'][] = $_GET['add-student'];
    }
} elseif (isset($_GET['delete-student'])){
    $_SESSION['studentsToAdd'] = array_diff($_SESSION['studentsToAdd'], ['',$_GET['delete-student']]);
}elseif (isset($_GET['add-student-bd'])){
    var_dump("--------list------");
    var_dump($_SESSION['studentsToAdd']);
    var_dump("--------list------");
    addStudentsDB($db, $_SESSION['studentsToAdd'],$class['id']);
}
else {
    $_SESSION['studentsToAdd'] = array();
}
?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'modules/include.php' ?>
<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main id="main-editor-class">
    <h1><?= $class['name'] ?></h1>
    <form action="/processing-forms/processing-form-class-edition.php" method="post">
        <fieldset>
            <label for="nameClass">Nom de la class:</label>
            <input id="nameClass" type="text" name="name" value="<?= $class['name'] ?>">
            <label for="desc">description</label>
            <textarea id="desc" name="desc" rows="10" cols="50"><?= $class['description'] ?></textarea>
        </fieldset>
        <input class="btn" type="submit">
    </form>
    <h2>Ajouter étudiants</h2>
    <ul>
        <?php
        $list = getStudents($db);
        foreach ($list as $student) { ?>
            <li class="">
                <div>
                    <a href="profile.php?id-profil=<?= $student['id'] ?>"><?= $student['name'] ?></a>
                    <form action="editor-class.php?id-class=<?= $class['id'] ?>&add-student=<?= $student['id'] ?>"
                          method="post">
                        <input type="submit" value="ajouter">
                    </form>
                </div>
            </li>
        <?php }
        ?>
    </ul>
    <div>
        <h2>Liste des étudiants à ajouter</h2>
        <ul>
            <?php
            if (isset($_SESSION['studentsToAdd'])) {
                foreach ($_SESSION['studentsToAdd'] as $student) { ?>
                    <li class="">
                        <div>
                            <a href="profile.php?id-profil=<?= $student ?>"><?= getStudentbyId($db,$student)['name'] ?></a>
                            <form action="editor-class.php?id-class=<?= $class['id'] ?>&delete-student=<?=$student ?>"
                                  method="post">
                                <input type="submit" value="Supprimer">
                            </form>
                        </div>
                    </li>
                <?php }

            } ?>
        </ul>
        <a class="" href="editor-class.php?id-class=<?= $class['id'] ?>&add-student-bd=true"> Ajouter les étudiants</a>
    </div>

    <h2>Liste des étudiants inscrite</h2>
    <ul>
        <?php
        if (isset($_SESSION['studentsToAdd'])) {
            foreach ($_SESSION['studentsToAdd'] as $student) { ?>
                <li class="">
                    <div>
                        <a href="profile.php?id-profil=<?= $student ?>"><?= getStudentbyId($db,$student)['name'] ?></a>
                        <form action="editor-class.php?id-class=<?= $class['id'] ?>&delete-student=<?=$student ?>"
                              method="post">
                            <input type="submit" value="Supprimer">
                        </form>
                    </div>
                </li>
            <?php }
        } ?>
    </ul>
</main>


<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>
