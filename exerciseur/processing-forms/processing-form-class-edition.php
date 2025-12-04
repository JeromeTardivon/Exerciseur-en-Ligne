<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
$class = $_POST["class"];
if (!empty($_POST['name']) && !empty($_POST['desc'])) {
    $db->beginTransaction();
    $db->commit();
    header('Location: /index.php');
    exit();
}
if (isset($_POST['add-student'])) {
    if (!studentInList($_SESSION['studentsToAdd'], $_POST['add-student'])) {
        $_SESSION['studentsToAdd'][] = $_POST['add-student'];
    }
} elseif (isset($_POST['delete-student'])) {
    $_SESSION['studentsToAdd'] = array_diff($_SESSION['studentsToAdd'], ['', $_POST['delete-student']]);
} elseif (isset($_POST['add-student-db'])) {
    addStudentsToClassDB($db, $_SESSION['studentsToAdd'], $class);
    $_SESSION['studentsToAdd'] = array();
} elseif (isset($_POST['delete-student-db'])) {
    deleteStudentFromClassDB($db, $class, $_POST['delete-student-db']);

} elseif (isset($_POST['className']) || isset($_POST['description'])) {
    $name = $_POST['className'];
    $description = $_POST['description'];
    updateClass($db, $class, $name, $description);


} elseif (isset($_POST['generate-code-class'])) {
    generateCode($db, $class, $_POST['number-usages-code']);
} else {
    $_SESSION['studentsToAdd'] = array();
}

header("location: http://localhost:8080/editor-class.php?id-class=$class");
exit();