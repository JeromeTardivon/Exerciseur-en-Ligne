<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/style.css">
        <title>Espace Professeur</title>
    </head>

    <body>

        <?php include 'modules/header.php' ?>

        <main class="espace-professeur">
            <form action="formulchapitre.php" method="post">
                <div class="gerer-classe">
                    <!-- sert pour le carré de couleur dans le wireframing, comme ça le bouton "créer classe" reste dans le div "gerer-classe" -->
                    <div>
                        <h2>Gérer mes classes</h2>

                        <input class="btn" type="search" placeholder="Rechercher classe">

                        <!-- le contenu de la liste sera à changer avec du php pour avoir la liste des classes auquels il a accès -->
                        <!-- le nb de li sera en fonction de la hauteur de l'écran -->
                        <ul>
                            <li class="btn"><a href="">Classe 1</a></li>
                            <li class="btn"><a href="">Classe 2</a></li>
                        </ul>
                    </div>

                    <h2 class="btn"><a href="">Créer classes</a></h2>
                </div>

                <div class="gerer-chapitre">
                    <!-- sert pour le carré de couleur dans le wireframing, comme ça le bouton "créer classe" reste dans le div "gerer-classe" -->
                    <div>
                        <h2>Gérer mes chapitres</h2>

                        <input class="btn" type="search" placeholder="Rechercher chapitre">

                        <!-- le contenu de la liste sera à changer avec du php pour avoir la liste des classes auquels il a accès -->
                        <!-- le nb de li sera en fonction de la hauteur de l'écran -->
                        <ul>
                            <li class="btn"><a href="">Chapitre 1</a></li>
                            <li class="btn"><a href="">Chapitre 2</a></li>
                            <li class="btn"><a href="">Chapitre 1</a></li>
                            <li class="btn"><a href="">Chapitre 2</a></li>
                            <li class="btn"><a href="">Chapitre 1</a></li>
                            <li class="btn"><a href="">Chapitre 2</a></li>
                            <li class="btn"><a href="">Chapitre 1</a></li>
                            <li class="btn"><a href="">Chapitre 2</a></li>
                            <li class="btn"><a href="">Chapitre 1</a></li>
                            <li class="btn"><a href="">Chapitre 2</a></li>
                        </ul>
                    </div>

                    <h2 class="btn"><a href="">Créer chapitres</a></h2>
                </div>

                <div class="gerer-sujet">
                    <!-- sert pour le carré de couleur dans le wireframing, comme ça le bouton "créer classe" reste dans le div "gerer-classe" -->
                    <div>
                        <h2>Gérer mes sujets</h2>

                        <input class="btn" type="search" placeholder="Rechercher sujet">

                        <!-- le contenu de la liste sera à changer avec du php pour avoir la liste des classes auquels il a accès -->
                        <!-- le nb de li sera en fonction de la hauteur de l'écran -->
                        <ul>
                            <li class="btn"><a href="">Sujet 1</a></li>
                            <li class="btn"><a href="">Sujet 2</a></li>
                        </ul>
                    </div>

                    <h2 class="btn"><a href="">Créer sujet</a></h2>
                </div>
            </form>
        </main>

        <?php include 'modules/footer.php' ?>

    </body>

</html>