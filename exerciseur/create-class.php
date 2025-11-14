<!DOCTYPE html>
<html lang="fr">
<?php $_TITLE="Créer un classe";include 'modules/include.php' ?>

    <body>
        <!-- nav -->
         <?php include 'modules/header.php' ?>

        <main>
            <form action="formsignup.php" method="post">
                <fieldset>
                    <legend>Création de classe</legend>

                    <label for="email">Entrez ici le nom de la classe</label>
                    <input id="name" type="text" name="name">

                    <label for="password">Entrez ici une description de la classe</label>
                    <textarea id="desc" name="desc" rows="10" cols="50"></textarea>

                    <fieldset>
                        <legend>Générer un code d'accès?</legend>

                        <div>
                            <input type="radio" id="Oui" name="Oui" value="Oui" checked />
                            <label for="Oui">Oui</label>
                        </div>

                        <div>
                            <input type="radio" id="Non" name="Non" value="Non" />
                            <label for="Non">Non</label>
                        </div>

                        
                    </fieldset>



                </fieldset>

                <button type=”submit”>Valider</button>
                <button type=”reset”>Effacer</button>
            </form>
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?>
    </body>
</html>