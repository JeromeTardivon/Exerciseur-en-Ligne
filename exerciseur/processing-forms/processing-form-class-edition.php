<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
require_once __DIR__ . '/../db/Database.php';
use db\Database;
$class = $_POST["class"];
$db = Database::getInstance();
if (!empty($_POST['name']) && !empty($_POST['desc'])) {
    header('Location: /index.php');
    exit();
}
if (isset($_POST['add-student'])) {
    if (!isInList($_SESSION['studentsToAdd'], $_POST['add-student'])) {
        $_SESSION['studentsToAdd'][] = $_POST['add-student'];
    }
} elseif (isset($_POST['delete-student'])) {
    $_SESSION['studentsToAdd'] = array_diff($_SESSION['studentsToAdd'], ['', $_POST['delete-student']]);
} elseif (isset($_POST['add-student-db'])) {
    $db->addStudentsToClassDB($_SESSION['studentsToAdd'], $class);
    $_SESSION['studentsToAdd'] = array();
} elseif (isset($_POST['delete-student-db'])) {
    $db->deleteStudentFromClassDB($class, $_POST['delete-student-db']);

} elseif (isset($_POST['className']) || isset($_POST['description'])) {
    $name = $_POST['className'];
    $description = $_POST['description'];
    $db->updateClass($class, $name, $description);


} elseif (isset($_POST['generate-code-class'])) {
    $db->generateCode($class, $_POST['number-usages-code']);
}elseif (isset($_POST['add-teacher'])){
    $db->addResponsible($_POST['add-teacher'], $class);
}
else {
    $_SESSION['studentsToAdd'] = array();
}

header("location: http://localhost:8080/editor-class.php?id-class=$class");
exit();