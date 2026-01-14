<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
include_once __DIR__ . '/../db/Database.php';
//verif nécéssaire à cause du passage de données par $_GET
use db\Database;
$dbi = Database::getInstance();

if (!isset($_SESSION["user"])) {
    header('Location: /index.php');
    exit();
} else if ($_SESSION["user"]["type"] != "teacher" && $_SESSION["user"]["type"] != "admin") {
    header('Location: /index.php');
    exit();
}else if (!isset($_GET['id-chapter'])||!isset($_GET['exercise-num'])) {
    header('Location: /index.php');
    exit();
}else if($dbi->chapterBelongsToTeacher($_GET['id-chapter'],$_SESSION['user']['id'])==false) {
    header('Location: /index.php');
    exit();
}else if ($_GET['exercise-num']>$dbi->getExercisesNumberFromChapter($_GET['id-chapter'])||$_GET['exercise-num']<1) {
    header('Location: /index.php');
    exit();
}

if (isset($_POST['content'])&&isset($_POST['section-title'])&&isset($_POST['weight']) /*&& isset($_POST['time']) && isset($_SESSION['user']) && $_SESSION['user']['type'] === 'teacher'*/){
    $weight = $_POST['weight'];
    /*$ansdef = isset($_POST['ansdef']) && $_POST['ansdef']=="on" ? 1 : 0;
    $showans = isset($_POST['showans']) && $_POST['showans'] == "on" ? 2 : $ansdef;*/
    $content = $_POST['content'];
    $title = $_POST['section-title'];
    $time = $_POST['timelimit_seconds'] + $_POST['timelimit_minutes'] * 60 + $_POST['timelimit_hours'] * 3600;
    $grade = 0;
    if (isset($_POST["total-grade"])) {
        $grade =(float) $_POST["total-grade"];
    }
    
    /*

    if(isset($_POST['tries']) && $_POST['tries'] == "on" && isset($_POST['tries_number'])) {
        $tries_number = $_POST['tries_number'];
    } else {
        $tries_number = null;
    }*/
    $idExercise = $dbi->getExerciseIdFromNum($_GET['id-chapter'],$_GET['exercise-num']);

    $stmt = $db->prepare("UPDATE exercise SET content = :content, title = :title, coef=:coef, timesec=:timesec WHERE id = :id_exercise");  

    $stmt->execute([
        ':coef' => $weight,
        ':timesec' => $time ,
        /*':tries' => $tries_number,
        ':ansdef' => $ansdef,
        ':id_chapter' => $chapter_id,*/
        ':content' => $content,
        ':title' => $title,
        //':grade' => $grade,
        ':id_exercise' => $idExercise
    ]);
    $stmt = $db->prepare("UPDATE exercise SET updated_at = CURRENT_TIMESTAMP WHERE id = :id_exercise");  
    $stmt->execute([
        ':id_exercise' => $idExercise
    ]);
    
} else {
    header('Location: /index.php');
    exit();
}

//used to reset the local storage between sections
$_SESSION['clear_local_storage'] = false;

header('Location: /modif-selection.php?id-chapter=' . $_GET['id-chapter'] . '&exercise-num=' . $_GET['exercise-num']);
exit();
?>

