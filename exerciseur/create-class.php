<?php
session_start();
?>

<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE="Créer un classe";include 'modules/include.php' ?>

    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>

        <main id="main-create-class">
            <form action="/processing-forms/processing-form-class-creation.php" method="post">
                <fieldset>
                    <legend>Création de classe</legend>

                    <label for="nameClass">Entrez ici le nom de la classe</label>
                    <input id="nameClass" type="text" name="name">

                    <label for="desc">Entrez ici une description de la classe</label>
                    <textarea id="desc" name="desc" rows="10" cols="50"></textarea>
                </fieldset>
                <input class="btn" type="submit">
                <input class="btn" type="reset">
            </form>
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?>
    </body>
</html>