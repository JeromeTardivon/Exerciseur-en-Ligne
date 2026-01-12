<?php
include_once __DIR__ . '/config/config.php';
?>

<!DOCTYPE html>

<html lang="fr">

<?php include 'modules/include.php' ?>


<body>
<?php include 'modules/header.php' ?>

<main id="home-page">
    <div class="searching-section">
        <form action="/processing-forms/processing-chapter-search.php" method="get">
            <div>
                <label class="titleSearchBar" for="exerciseSearchBar">Rechercher un chapitre par mot clé</label>
                <div>
                    <input type="search" id="exerciseSearchBar" name="search" class="btn">
                    <button type="submit" class="btn">Rechercher</button>
                </div>
            </div>
        </form>
        <form action="/processing-forms/processing-class-search.php" method="get">
            <div>
                <label class="titleSearchBar" for="classSearchBar">Rechercher une classe</label>
                <div>
                    <input type="search" id="classSearchBar" name="search" class="btn">
                    <button type="submit" class="btn">Rechercher</button>
                </div>
            </div>
        </form>
    </div>
</main>

<?php include 'modules/footer.php' ?>
</body>
</html>