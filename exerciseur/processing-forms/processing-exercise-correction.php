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
}else if (!isset($_POST['id-chapter']) || !isset($_POST['exercise-num']) ) {
    header('Location: /index.php');
    exit();
} else if ($_POST['exercise-num']>$db->getExercisesNumberFromChapter($_POST['id-chapter'])||$_POST['exercise-num']<1) {
    header('Location: /index.php');
    exit();
}

$idExercise = $db->getExerciseIdFromNum($_POST['id-chapter'],$_POST['exercise-num']);



$originalContent = $db->getExerciseContent($idExercise);
$_POST['original-content'] = $originalContent;
$originalDecoded = !empty($originalContent) ? json_decode($originalContent, true) : NULL;

$gradedContent = $_POST['graded-answers'];
// unset($_POST['graded-content']);
$gradedDecoded = !empty($gradedContent) ? json_decode($gradedContent, true) : NULL;

$answersContent = $db->getAnswers($_POST['id-corrected-user'], $idExercise);
$answersDecoded = !empty($originalContent) ? json_decode($answersContent, true) : NULL;

// echo $answersContent;

$finalMaxGrades = array();
$finalGrades = array();


// filling up $finalMaxGrades
for ($i = 0; $i < count($originalDecoded); $i++) {
    if ($originalDecoded[$i]["type"] == "mcq") {
        $totalGrade = 0;

        foreach ($originalDecoded[$i]['choices'] as $choice) {
            $totalGrade += floatval(isset($choice['grade']) && $choice['grade'] > 0 ? $choice['grade'] : 0.0);
        }

        $grade = $totalGrade;
    } else {
        $grade = floatval($originalDecoded[$i]['grade'] ?? 0);
    }

    array_push($finalMaxGrades, $grade);
}

$answersCpt = 0;

// filling up $finalGrades
for ($i = 0; $i < count($gradedDecoded); $i++) {
    switch ($gradedDecoded[$i]['type']) {
        case 'openquestion':
            $grade = floatval($gradedDecoded[$i]['grade'] ?? 0);
            $grade = $grade > $finalMaxGrades[$i] ? $finalMaxGrades[$i] : $grade;
            break;

        case 'mcq':
            $grade = 0;
            for ($j = 0; $j < count($answersDecoded[$i]['choices']); $j++) {
                $choice = $answersDecoded[$i]['choices'][$j];
                $ogChoice = $originalDecoded[$i]['choices'][$j];

                if ($choice['text'] == $ogChoice['text'] && $choice['answer']) {
                    $grade += floatval($ogChoice['grade'] ?? 0.0);
                }
            }

            $answersCpt++;
            break;

        case 'numericalquestion':
            // echo $answersDecoded[$answersCpt]['answernumber'];
            if (isset($answersDecoded[$answersCpt]['answernumber'])) {
                if (floatval($answersDecoded[$answersCpt]['answernumber']) === floatval($originalDecoded[$i]['answerProf'])) {
                    $grade = $finalMaxGrades[$i];
                } else {
                    $grade = 0;
                }
            } else {
                $grade = 0;
            }
            
            $answersCpt++;
            break;

        case 'truefalse':
            // echo $answersDecoded[$answersCpt]['answer'] . " ; " . $originalDecoded[$i]['answerProf'] . "<br>";

            if (isset($answersDecoded[$answersCpt]['answer'])) {
                if ($answersDecoded[$answersCpt]['answer'] === $originalDecoded[$i]['answerProf']) {
                    $grade = $finalMaxGrades[$i];
                } else {
                    $grade = 0;
                }
            } else {
                $grade = 0;
            }
            $answersCpt++;
            break;

        default:
            $grade = 0;
            break;
    }

    array_push($finalGrades, $grade);
}

$totalGrade = array_sum($finalGrades);
$totalMaxGrade = array_sum($finalMaxGrades);


// basic printing of the results
// echo "Note : " . $totalGrade . "/" . $totalMaxGrade . "<br><br>";

// for ($i = 0; $i < count($finalMaxGrades); $i++) {
//     echo "Exercice " . $gradedDecoded[$i]['type'] . " : " . $finalGrades[$i] . "/" . $finalMaxGrades[$i] . "<br>";
// }

$db->setGrade($_POST['id-corrected-user'], $idExercise, $totalGrade);

// echo "Grade updated in DB";
header('Location: /index.php');
?>

<script>
    try {
        localStorage.removeItem('dynamicModules');
    } catch {}
    try {
        localStorage.removeItem('graded-answers');
    } catch {}
</script>

<?php

exit();

?>