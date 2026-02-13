<?php 
include_once __DIR__ . '/config/config.php';
include_once __DIR__ . '/db/db-connection.php';
include_once __DIR__ . '/db/Database.php';
use db\Database;
$db = Database::getInstance();
if (!isset($_SESSION["user"])) {
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

if (is_array($decoded)) {

//setting up the json to be used in practice mode (removing grades and answers from localstorage as well as adding empty answers)
    foreach ($decoded as &$module) {
        if (isset($module['type']) && $module['type'] === 'mcq' && isset($module['choices']) && is_array($module['choices'])) {
            // For MCQ modules, delete the 'grade' field from each option
            foreach ($module['choices'] as &$choice) {
                if (isset($choice['grade'])) {
                    unset($choice['grade']);
                }
                
                if(!isset($choice['answer'])) {
                    $choice['answer'] = false;
                }
            }
            
        } else if (isset($module['type']) && $module['type'] === 'truefalse') {
            if(isset($module['grade'])) {
                unset($module['grade']);
            }
            if (isset($module['answerProf'])) {
                unset($module['answerProf']);
            }
            if(!isset($module['answer'])) {
                $module['answer'] = null;
            }
        }else if (isset($module['type']) && $module['type'] === 'numericalquestion') {
            if (isset($module['grade'])) {
                unset($module['grade']);
            }
            if (isset($module['answerProf'])) {
                unset($module['answerProf']);
            }
            if (!isset($module['answerjustification'])) {
                $module['answer'] = '';
            }
            if (!isset($module['answernumber'])) {
                $module['answernumber'] = 0;
            }

        }else if (isset($module['type']) && $module['type'] === 'hint') {
            //shouldnt be necessary but just in case (the case needs to be there but should work empty as hints shouldnt have grades)
            /*//*/if (isset($module['grade'])) {
            /*//*/    unset($module['grade']);
            /*//*/}
        }else{
            if (isset($module['grade'])) {
                unset($module['grade']);
            }
            if (isset($module['answerProf'])) {
                unset($module['answerProf']);
            }
            if (!isset($module['answer'])) {
                $module['answer'] = '';
            }
        }
    }
    unset($module);
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


            <form action= <?="processing-exercise-practice.php?id-chapter=".$_GET['id_chapter']."&exercisse-num=".$_GET['exercise-num']?> method="post" id ="dynamic-form">

                


                <fieldset>
                    <legend>Exercice <?= $_GET['exercise-num']?></legend>
                    <div id="exercise-container"></div>
                </fieldset>

                <input type="hidden" name="studentAnswer" >

                <button type="submit" id="validate-answers">Valider les réponses</button>
                

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
        <script type=text/javascript src="js/exercise-practice.js"></script>
        <script>
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