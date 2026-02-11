<?php 
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
include_once __DIR__ . '/../db/Database.php';
use db\Database;

$_POST['exercise-num'] = intval($_POST['exercise-num']);

$db = Database::getInstance();
if (!isset($_SESSION["user"])) {
    header('Location: /index.php');
    exit();
} else if ($_SESSION["user"]["type"] != "teacher" && $_SESSION["user"]["type"] != "admin") {
    header('Location: /index.php');
    exit();
}else if (!isset($_POST['id-chapter'])||!isset($_POST['exercise-num'])) {
    header('Location: /index.php');
    exit();
}else if ($_POST['exercise-num']>$db->getExercisesNumberFromChapter($_POST['id-chapter'])||$_POST['exercise-num']<1) {
    header('Location: /index.php');
    exit();
}



$content = $db->getExerciseContent($db->getExerciseIdFromNum($_POST['id-chapter'],$_POST['exercise-num']));

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
                    $choice['answer'] = null;
                }
            }
            
        } else if (isset($module['type']) && $module['type'] === 'truefalse') {
            if(isset($module['grade'])) {
                unset($module['grade']);
            }
            if (isset($module['answerProf'])) {
                unset($module['answerProf']);
            }
            if(isset($module['answer'])) {
                unset($module['answer']);
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
$idExercise = $db->getExerciseIdFromNum($_POST['id-chapter'],$_POST['exercise-num']);


// debug stuff
var_dump($_POST['dynamic-modules']);
die();