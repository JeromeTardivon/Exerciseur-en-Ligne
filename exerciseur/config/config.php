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