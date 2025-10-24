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
                    <input type="search" name="search_keyword" placeholder="Recherche mot-clé">
                </fieldset>

                <fieldset>
                    <legend>Rechercher un exercice par code</legend>
                    <input type="search" name="search_code" placeholder="Recherche code">
                </fieldset>
            </from>
        </aside>

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 

    </body>
</html>