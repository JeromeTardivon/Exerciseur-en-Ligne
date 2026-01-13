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
}else if (!isset($_GET['id-chapter'])) {
    header('Location: /index.php');
    exit();
}else if($db->chapterBelongsToTeacher($_GET['id-chapter'],$_SESSION['user']['id'])==false) {
    header('Location: /index.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
    <?php include 'modules/include.php' ?>
    
    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>

        <main id="modif-selection">     

            <ul>   
                <li><h3>Choisir un Exercice à modifier</h3></li>
                        
                <?php 
                        
                    for ($i = 1; $i <= $db->getExercisesNumberFromChapter($_GET['id-chapter']); $i++) {
                            
                        echo "<li><a class='btn' href='chapter-edition.php?id-chapter=" . $_GET['id-chapter'] . "&exercise-num=" . $i ."'>Exercice " . $i ." : ". $db->getTitleExercise($db->getExerciseIdFromNum($_GET['id-chapter'], $i))."</a></li>";
                        
                    }
                ?>
                <li><a class='btn' href="section.php">Ajouter un exercice</a></li>
            </ul>
            <a href="teacher-space.php" class="btn">Annuler</a>
            
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 

    </body>
    <script> //reseting localstorage in case the 'go back button (<-) has been pressed from chapter edition 
        localStorage.removeItem('dynamicModules');
    </script>
</html>