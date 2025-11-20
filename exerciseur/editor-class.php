<?php
include_once __DIR__ .'/config/config.php';
include_once __DIR__ .'/db/db-connection.php';
$_TITLE = "Éditeur Classe" ;
$class = getClass($db, $_GET['id-class']);
?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'modules/include.php' ?>
<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main id="main-editor-class">
<h3><?= $class['name'] ?></h3>
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
        foreach ($list as $student) {?>
            <li class=""><a href="profile.php?id-profil=<?= $student['id']?>"><?=$student['name']?></a></li>
        <?php }
        ?>
    </ul>
</main>



<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>
