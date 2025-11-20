<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
if (!empty($_POST['name']) && !empty($_POST['desc'])) {
    $db->beginTransaction();
    $statement = $db->prepare("INSERT INTO class (name, description) values (:name, :description)");
    $statement->execute(['name' => $_POST['name'], 'description' => $_POST['desc']]);
    $statement = $db->prepare("SELECT id FROM class ORDER BY created_at DESC LIMIT 1");
    $statement->execute();
    $lastInsertId = $statement->fetch();
    $statement = $db->prepare("INSERT INTO inclass (id_user, id_class,responsible) values (:idTeacher, :idClass, 1)");
    $statement->execute(['idTeacher' => $_SESSION['user']['id'], 'idClass' => $lastInsertId[0]]);
    $db->commit();
    header('Location: /index.php');
    exit();
}
