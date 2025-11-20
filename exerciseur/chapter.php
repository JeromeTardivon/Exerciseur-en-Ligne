<?php
session_start();
?>

<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE="Chapitre";include 'modules/include.php' ?>

    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>

        <main id="chapter">
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
                    <button class="btn" type=”submit”>Valider</button>
                    <button class="btn" type=”reset”>Effacer</button>
                    
                    <!-- changer le type du bouton Abandon -->
                    <button class="btn" type=”reset”>Abandon</button>
                </div>
            </form>
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?>
    </body>
</html>