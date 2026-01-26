<?php

use db\Database;
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
require_once __DIR__ . '/../db/Database.php';
if (!empty($_POST['lastname']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $db = Database::getInstance();
    $db->createUser($_POST['lastname'],$_POST['surname'], $_POST['email'], $_POST['password'], $_POST['status'], $_POST['userSchoolId'], $_POST['teacherCode']);
    $_SESSION['user'] = $db->getUserByEmail($_POST['email']);
}
header('Location: /index.php');
exit();