<?php
session_start();
?>

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
        <form action="/processing-forms/processing-chapter-search.php" method="get">
            <div>
                <!-- @Bastien changement de h2 dans le label parce que c'est interdit ça bonne journée-->
                <!-- oulà oui en effet je suis outré-->
                <label for="search"><h2>Rechercher un chapitre par mot clé</h2></label>

                <div>
                    <input type="search" id="exerciseSearchBar" name="search" class="btn">
                    <button type="submit" class="btn">Rechercher</button>
                </div>
            </div>
        </form>

        <form action="/processing-forms/processing-class-search.php" method="get">
            <div>
                <label for="search"><h2>Rechercher une classe</h2></label>

                <div>
                    <input type="search" id="classSearchBar" name="search" class="btn">
                    <button type="submit" class="btn">Rechercher</button>
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