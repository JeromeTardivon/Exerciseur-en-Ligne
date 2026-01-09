<?php 
include_once __DIR__ . '/config/config.php';
include_once __DIR__ . '/db/db-connection.php';
include_once __DIR__ . '/db/Database.php';
use db\Database;
$db = Database::getInstance();
if (!isset($_SESSION["user"])) {
    header('Location: /index.php');
    exit();
} else if ($_SESSION["user"]["type"] != "teacher" && $_SESSION["user"]["type"] != "admin") {
    header('Location: /index.php');
    exit();
}else if (!isset($_GET['id-chapter'])||!isset($_GET['exercise-num'])) {
    header('Location: /index.php');
    exit();
}else if($db->chapterBelongsToTeacher($_GET['id-chapter'],$_SESSION['user']['id'])==false) {
    header('Location: /index.php');
    exit();
}else if ($_GET['exercise-num']>$db->getExercisesNumberFromChapter($_GET['id-chapter'])||$_GET['exercise-num']<1) {
    header('Location: /index.php');
    exit();
}


$_POST['content']='';
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