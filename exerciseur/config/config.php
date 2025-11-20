<?php
session_start();
function getTeachersClasses($db): array
{
    $listClasses = array();
    $statement = $db -> prepare("SELECT * FROM inclass WHERE id_user = :id_teacher");
    $statement -> execute(['id_teacher' => $_SESSION['user']['id']]);
    $classes = $statement -> fetchAll();
    foreach ($classes as $class) {
        $statement = $db -> prepare("SELECT * FROM class WHERE id = :id");
        $statement -> execute(['id' => $class['id_class']]);
        $listClasses[] = $statement-> fetch();
    }
    return $listClasses;
}