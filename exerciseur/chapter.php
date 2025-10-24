<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE="Chapitre";include 'modules/include.php' ?>

    <body>
        <!-- nav -->
         <?php include 'modules/header.php' ?>

        <main>
            <form action="formchapter.php" method="post">
                <div>
                    <h2>Exercice 1 :</h2>
                    <p>
                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                    </p>

                    <input name="answer" type="textarea">
                </div>
                
            
                <div>
                    <button type=”submit”>Valider</button>
                    <button type=”reset”>Effacer</button>
                    
                    <!-- changer le type du bouton Abandon -->
                    <button type=”reset”>Abandon</button>
                </div>
            </form>
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?>
    </body>
</html>