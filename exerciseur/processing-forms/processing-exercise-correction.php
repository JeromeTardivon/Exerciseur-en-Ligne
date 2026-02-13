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

$originalContent = $db->getExerciseContent($db->getExerciseIdFromNum($_POST['id-chapter'],$_POST['exercise-num']));
$_POST['original-content'] = $originalContent;
$originalDecoded = null;

$gradedContent = $_POST['graded-answers'];
// unset($_POST['graded-content']);
$gradedDecoded = NULL;

if (!empty($originalContent)) {
    $originalDecoded = json_decode($originalContent, true);
}

if (!empty($gradedContent)) {
    $gradedDecoded = json_decode($gradedContent, true);
}

$finalMaxGrades = array();
$finalGrades = array();

// filling up $finalMaxGrades
for ($i = 0; $i < count($originalDecoded); $i++) {
    $grade = floatval($originalDecoded[$i]['grade'] ?? 0);
    array_push($finalMaxGrades, $grade);
}

// filling up $finalGrades
for ($i = 0; $i < count($gradedDecoded); $i++) {
    $grade = floatval($gradedDecoded[$i]['grade'] ?? 0);
    $grade = $grade > $finalMaxGrades[$i] ? $finalMaxGrades[$i] : $grade;
    array_push($finalGrades, $grade);
}

$totalGrade = array_sum($finalGrades);
$totalMaxGrade = array_sum($finalMaxGrades);


// basic printing of the results
echo "Note : " . $totalGrade . "/" . $totalMaxGrade . "<br><br>";

for ($i = 0; $i < count($finalMaxGrades); $i++) {
    echo "Exercice " . $i . " : " . $finalGrades[$i] . "/" . $finalMaxGrades[$i] . "<br>";
}

$idExercise = $db->getExerciseIdFromNum($_POST['id-chapter'],$_POST['exercise-num']);

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

die();

?>