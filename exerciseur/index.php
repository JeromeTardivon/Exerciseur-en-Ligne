<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<?php include 'modules/include.php' ?>


<body>
<?php include 'modules/header.php' ?>

<main id="home-page">
    <div class="recent-exercises">
        <h2>Exercices récents</h2>
        <a class="btn" href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
    </div>

    <div class="searching-section">
        <form action="" method="post">
            <div>
                <label for="exerciseSearchBar"><h2>Rechercher un exercice par mot clé</h2></label>

                <div>
                    <input type="search" id="exerciseSearchBar" name="searchExercise" class="btn">
                    <input type="submit" class="btn">
                </div>
            </div>
        </form>

        <form action="" method="post">
            <div>
                <label for="classSearchBar"><h2>Rechercher une classe</h2></label>

                <div>
                    <input type="search" id="classSearchBar" name="classSearchBar" class="btn">
                    <input type="submit" class="btn">
                </div>
            </div>
        </form>
    </div>

    <div class="popular-exercises">
        <h2>Exercices populaire</h2>
        <a class="btn" href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
    </div>
</main>

<?php include 'modules/footer.php' ?>
</body>
</html>