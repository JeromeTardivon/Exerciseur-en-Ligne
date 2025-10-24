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
            <form action="formlogin.php" method="post">
                <fieldset>
                    <legend>Connexion</legend>
                    <label  for="email">Email</label>
                    <input id="email" type="email" name="email">

                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password">
                </fieldset>

                <button type=”submit”>Valider</button>
                <button type=”reset”>Effacer</button>
            </form>
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?>
    </body>
</html>