<?php include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
include_once __DIR__ . '/../db/Database.php';

use db\Database;
$dbi = Database::getInstance();

if(isset($_POST['studentAnswer'])){

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
    $idExercise=$dbi->getExerciseIdFromNum($_GET['id-chapter'], $_GET['exercise-num']);
    if($db->haveUserDoneExercise($_SESSION['user']['id'],$_GET['id-chapter'], $_GET['exercise-num'])){
        $statement=$db->prepare("UPDATE users_exercises SET answer = :answers WHERE id_user= :idUser AND id_exercise=:idExercise");
        $statement->execute(['answers'=>$_POST['studentAnswers'], 'idUser'=>$_SESSION['user']['id'],'idExercise'=>$idExercise]);
    }else{
        $statement=$db->prepare("INSERT INTO users_exercises (answer, id_user, id_exercise)  VALUES (:answers ,:idUser , :idExercise)");
        $statement->execute(['answers'=>$_POST['studentAnswers'], 'idUser'=>$_SESSION['user']['id'],'idExercise'=>$idExercise]);
    }




}

header("location: exercise.php?id-chapter=".$_GET['id-chapter']."&exercise-num=".$_GET['exercise-num']);
    exit();

?>