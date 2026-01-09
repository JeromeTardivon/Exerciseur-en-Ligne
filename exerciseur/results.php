<?php
session_start();
?>

<!DOCTYPE html>

<html lang="fr">
    <?php $_TITLE="Résultats"; include 'modules/include.php' ?>

    <body>
        <!-- nav -->
         <?php include 'modules/header.php' ?>

        <main>
            <h2>Résultats pour "xxxxxxxxxx"</h2>
            
            <ul>
                <li>
                    <a href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
                    <p>légende et info exercice</p>
                </li>
                <li>
                    <a href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
                    <p>légende et info exercice</p>
                </li>
                <li>
                    <a href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
                    <p>légende et info exercice</p>
                </li>
                <li>
                    <a href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
                    <p>légende et info exercice</p>
                </li>
                <li>
                    <a href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
                    <p>légende et info exercice</p>
                </li>
                <li>
                    <a href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
                    <p>légende et info exercice</p>
                </li>
                <li>
                    <a href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
                    <p>légende et info exercice</p>
                </li>
                <li>
                    <a href=""> xxxxxxxxxxxxxxxxxxxxxxxxx</a>
                    <p>légende et info exercice</p>
                </li>
            </ul>                  
        </main>


        <aside>
            <form action="formchapter.php" method="post">
                <fieldset>
                    <legend>Rechercher un exercice par mot clé</legend>
                    <label>
                        <input type="search" name="search_keyword" placeholder="Recherche mot-clé">
                    </label>
                </fieldset>

                <fieldset>
                    <legend>Rechercher un exercice par code</legend>
                    <label>
                        <input type="search" name="search_code" placeholder="Recherche code">
                    </label>
                </fieldset>
            </form>
        </aside>

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 

    </body>
</html>