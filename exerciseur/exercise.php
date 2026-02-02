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
}else if ($_GET['exercise-num']>$db->getExercisesNumberFromChapter($_GET['id-chapter'])||$_GET['exercise-num']<1) {
    header('Location: /index.php');
    exit();
}



$content = $db->getExerciseContent($db->getExerciseIdFromNum($_GET['id-chapter'],$_GET['exercise-num']));

$_POST['content'] = $content;

$decoded = null;

if (!empty($content)) {
    
    $decoded = json_decode($content, true);
    
}
$idExercise = $db->getExerciseIdFromNum($_GET['id-chapter'],$_GET['exercise-num']);
?>








<!DOCTYPE html>
<html lang="fr">
    <?php include 'modules/include.php' ?>
    
    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>

        <main id="chapter-creation">     
            <aside id=chapter-creation-aside-1>
                <h2>Outils</h2>
                <div>
                    <div id="add-symbols-btn">
    
                    </div>
    
                    <div id="symbols">
    
                    </div>
                </div>
            </aside>


            <form action="processing-forms/processing-exercise-edition.php?id-chapter=<?php echo $_GET['id-chapter']; ?>&exercise-num=<?php echo $_GET['exercise-num']; ?>" method="post" id ="dynamic-form">

                


                <fieldset>
                    <legend>Exercice <?= $_GET['exercise-num']?></legend>
                    <div id="previews"></div>
                </fieldset>

                <button type="submit" id="accept-changes">Valider les réponses</button>
                

                </form>

            
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 

        <?php
        
        if (isset($_SESSION['clear_local_storage']) && $_SESSION['clear_local_storage']) {
            
            echo '<script>try{localStorage.removeItem("dynamicModules"); /*localStorage.clear();*/}catch(e){}</script>';
            unset($_SESSION['clear_local_storage']);
        }
        ?>

        <script type="text/javascript" src="js/math-symbol.js"></script>
        <script type=text/javascript src="js/modular-section.js"></script>
        <script>

            //Sets up all the needed data and parameters
            document.getElementById("section-title").value="<?php echo $db->getTitleExercise($idExercise); ?>";
            document.getElementById("weight").value="<?php echo $db->getExerciseCoefficient($idExercise); ?>";
            let time ="<?php echo $db->getExerciseTimeLimit($idExercise); ?>";
            document.getElementById("timelimit-hours").value = Math.floor(time / 3600);
            document.getElementById("timelimit-minutes").value = Math.floor((time % 3600) / 60);
            document.getElementById("timelimit-seconds").value = time % 60;

            let triesLimit = "<?php echo $db->getExerciseTriesLimit($idExercise); ?>";
            
            document.getElementById("tries").checked = (triesLimit != ''); ;
            document.getElementById("tries-number").value = triesLimit!== null ? triesLimit : '1'; ;
            
            let ansdef = "<?php echo $db->getExerciseAnsDef($idExercise); ?>";
            console.log (ansdef);
            document.getElementById("ansdef").checked = (ansdef == 1 ); ;

            let showans = "<?php echo $db->getExerciseShowAns($idExercise); ?>";
            console.log(showans);
            document.getElementById("showans").checked = (showans == 1 && ansdef == 1); ;

            var payload = <?php echo $decoded !== null ? json_encode($decoded, JSON_UNESCAPED_UNICODE) : 'null'; ?>;
            
            //setting localstorage with exercise content so we dont need another function than "loadState()"
            if (payload !== null) {
                try { 
                    localStorage.setItem('dynamicModules', JSON.stringify(payload)); } catch(e) { console && console.warn && console.warn('Failed to set dynamicModules', e); 
                    $_SESSION['clear_local_storage'] = false;
                }
                
                } else {
                try { localStorage.removeItem('dynamicModules'); } catch(e) {}
            }
            
        </script>
    </body>
</html>