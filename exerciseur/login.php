<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE = "Connexion";
include 'modules/include.php' ?>

<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main>
    <form action="/processing-forms/processing-form-login.php" method="post">
        <fieldset>
            <legend>Connexion</legend>
            <label for="email">Email</label>
            <input id="email" type="email" name="email">

            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password">
        </fieldset>
        <input type="submit">
    </form>
    <div>
        <a  class="btn" href="signup.php">Creer compte</a>
    </div>
</main>

<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>