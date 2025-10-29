<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE = "Créer un compte";
include 'modules/include.php' ?>

<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main>
    <form action="/processing-forms/processing-form-signup.php" method="post">
        <fieldset>
            <legend>Inscription</legend>
            <fieldset>
                <legend>Statut</legend>
                <input type="radio" id="statusTeacher" name="status" value="teacher"/><label for="statusTeacher">Enseignant(e)</label>
                <input type="radio" id="statusStudent" name="status" value="student" checked/><label
                        for="statusStudent">Etudiant(e)</label>
            </fieldset>
            <fieldset>
                <legend>Identité</legend>
                <label for="lastname">NOM</label>
                <input id="lastname" type="text" name="lastname">

                <label for="surname">Prénom</label>
                <input id="surname" type="text" name="surname">

                <label for="email">adresse mail</label>
                <input id="email" type="email" name="email">

                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password">
            </fieldset>
            <input type="submit" value="Valider">
        </fieldset>
    </form>
</main>

<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>