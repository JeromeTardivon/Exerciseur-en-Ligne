<?php
session_start();
function getTeachersClasses($db): array
{
    $listClasses = array();
    $statement = $db -> prepare("SELECT * FROM inclass WHERE id_user = :id_teacher");
    $statement -> execute(['id_teacher' => $_SESSION['user']['id']]);
    $classes = $statement -> fetchAll();
    foreach ($classes as $class) {
        $listClasses[] = getClass($db, $class['id_class']);
    }
    return $listClasses;
}

function getClass($db, $idClass){
    $statement = $db -> prepare("SELECT * FROM class WHERE id = :id");
    $statement -> execute(['id' => $idClass]);
    return $statement-> fetch();
}

function getStudents($db)
{
    $statement = $db -> prepare("SELECT * FROM users");
    $statement -> execute();
    return $statement-> fetchAll();
}

function getStudentbyId($db, $studentId){
    $statement = $db -> prepare("SELECT * FROM users WHERE id = :id");
    $statement -> execute(['id' => $studentId]);
    return $statement-> fetch();
}

function studentInList($listIdStudents, $studentId): bool
{
    foreach ($listIdStudents as $student) {
        if ($student == $studentId) {
            return true;
        }
    }
    return false;
}