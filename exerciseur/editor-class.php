<?php
include_once __DIR__ . '/config/config.php';
include_once __DIR__ . '/db/db-connection.php';
$_TITLE = "Éditeur Classe";
$class = getClass($db, $_GET['id-class']);
$listStudents = getStudentsFromClass($db, $class['id']);
$teacher = getResponsableFromClass($db, $class['id']);
if (isset($_POST['add-student'])) {
    if (!studentInList($_SESSION['studentsToAdd'], $_POST['add-student'])) {
        $_SESSION['studentsToAdd'][] = $_POST['add-student'];
    }
} elseif (isset($_POST['delete-student'])) {
    $_SESSION['studentsToAdd'] = array_diff($_SESSION['studentsToAdd'], ['', $_POST['delete-student']]);
} elseif (isset($_POST['add-student-db'])) {
    addStudentsDB($db, $_SESSION['studentsToAdd'], $class['id']);
    $_SESSION['studentsToAdd'] = array();
    header("Refresh:0");
} elseif (isset($_POST['delete-student-db'])) {
    deleteStudentFromClassDB($db, $class['id'], $_POST['delete-student-db']);
    header("Refresh:0");
}elseif (isset($_POST['className']) || isset($_POST['description'])) {
    $name = $_POST['className'];
    $description = $_POST['description'];
    updateClass($db, $class['id'], $name, $description);
    header("Refresh:0");

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
    <h3>Responsable: <?= $teacher['name'] . ' ' . $teacher['surname'] ?></h3>
    <form action="editor-class.php?id-class=<?= $class['id'] ?>" method="post">
        <fieldset>
            <label for="nameClass">Nom de la class:</label>
            <input id="nameClass" type="text" name="className" value="<?= $class['name'] ?>">
            <label for="desc">description</label>
            <textarea id="desc" name="description" rows="10" cols="50"><?= $class['description'] ?></textarea>
        </fieldset>
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
                    <form action="editor-class.php?id-class=<?= $class['id'] ?>" method="post">
                        <input type="hidden" name="add-student" value="<?= $student['id'] ?>">
                        <input  class = "btn" type="submit" value="Ajouter">
                    </form>
                </div>
            </li>
        <?php }
        ?>
    </ul>
    <div>
        <h2 <?= isset($_SESSION['studentsToAdd'])? "" : "hidden" ?>>Liste des étudiants à ajouter</h2>
        <ul>
            <?php
            if (isset($_SESSION['studentsToAdd'])) {
                foreach ($_SESSION['studentsToAdd'] as $student) { ?>
                    <li class="">
                        <div>
                            <a href="profile.php?id-profil=<?= $student ?>"><?= getUser($db, $student)['name'] ?></a>
                            <form action="editor-class.php?id-class=<?= $class['id'] ?>" method="post">
                                <input type="hidden" name="delete-student" value="<?= $student ?>">
                                <input class = "btn" type="submit" value="Supprimer">
                            </form>
                        </div>
                    </li>
                <?php }

            } ?>
        </ul>
        <form action="editor-class.php?id-class=<?= $class['id'] ?>" method="post" <?= isset($_SESSION['studentsToAdd'])? "" : "hidden" ?>>
            <input type="hidden" name="add-student-db" value="true">
            <input class = "btn" type="submit" value="Ajouter les étudiants">
        </form>
    </div>

    <h2 <?= empty($listStudents)? "hidden" : "" ?>>Liste des étudiants inscrite</h2>
    <ul>
        <?php
        foreach ($listStudents as $student) { ?>
            <li class="">
                <div>
                    <a href="profile.php?id-profil=<?= $student['id_user'] ?>"><?= getUser($db, $student['id_user'])['name'] ?></a>
                    <form action="editor-class.php?id-class=<?= $class['id'] ?>" method="post">
                        <input type="hidden" name="delete-student-db" value="<?= $student['id_user'] ?>">
                        <input class = "btn" type="submit" value="Supprimer">
                    </form>
                </div>
            </li>
        <?php } ?>
    </ul>
</main>


<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>
