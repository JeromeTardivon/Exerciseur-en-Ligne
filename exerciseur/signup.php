<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/style.css">
        <title>Connexion</title>
    </head>

    <body>
        <!-- nav -->
         <?php include 'modules/header.php' ?>

        <main>
            <form action="formsignup.php" method="post">
                <fieldset>
                    <legend>Inscription</legend>
                    <fieldset>
                        <legend>Statut</legend>
                        <input type="radio" name="statut" value="teacher"><p>Enseignant(e)</p>
                        <input type="radio" name="statut" value="student"><p>Etudiant(e)</p>
                    </fieldset>
                    <fieldset>
                        <legend>Identité</legend>
                        <label  for="lastname">NOM</label>
                        <input id="lastname" type="text" name="lastname">

                        <label for="surname">Prénom</label>
                        <input id="surname" type="text" name="surname">

                        <label  for="email">adresse mail</label>
                        <input id="email" type="email" name="email">

                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password">
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