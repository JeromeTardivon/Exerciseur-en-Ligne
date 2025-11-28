<?php
session_start();
function getClasses($db, $teacherId): array
{
    $listClasses = array();
    $statement = $db->prepare("SELECT * FROM inclass WHERE id_user LIKE '$teacherId'");
    $statement->execute();
    $classes = $statement->fetchAll();
    foreach ($classes as $class) {
        $listClasses[] = getClass($db, $class['id_class']);
    }
    return $listClasses;
}

function getClass($db, $idClass)
{
    $statement = $db->prepare("SELECT * FROM class WHERE id = :id");
    $statement->execute(['id' => $idClass]);
    return $statement->fetch();
}

function getStudents($db)
{
    $statement = $db->prepare("SELECT * FROM users");
    $statement->execute();
    return $statement->fetchAll();
}

function getUser($db, $userId)
{
    $statement = $db->prepare("SELECT * FROM users WHERE id = :id");
    $statement->execute(['id' => $userId]);
    return $statement->fetch();
}

/**
 * @param $listIdStudents
 * @param $studentId
 * @return bool
 * it searches if the id of the student is in the list of ids of students
 */
function studentInList($listIdStudents, $studentId): bool
{
    foreach ($listIdStudents as $student) {
        if ($student == $studentId) {
            return true;
        }
    }
    return false;
}

function addStudentsDB($db, $listIdStudents, $classId): void
{
    foreach ($listIdStudents as $student) {
        $statement = $db->prepare("SELECT COUNT(id_user) as nb FROM inclass WHERE id_user = '$student' AND id_class = '$classId'");
        $statement->execute();
        $existStudent = $statement->fetch();
        if ($existStudent['nb'] == 0) {
            $statement = $db->prepare("INSERT INTO inclass (id_user, id_class, responsible) VALUES ('$student', '$classId', 0)");
            $statement->execute();
        }
    }
}

function getStudentsFromClass($db, $classId)
{
    $statement = $db->prepare("SELECT * FROM inclass WHERE id_class = '$classId' AND responsible LIKE 0");
    $statement->execute();
    return $statement->fetchAll();
}

function getResponsableFromClass($db, $classId)
{
    $statement = $db->prepare("SELECT * FROM inclass WHERE id_class = '$classId' AND responsible LIKE 1");
    $statement->execute();
    return getUser($db, $statement->fetch()['id_user']);
}

function deleteStudentFromClassDB($db, $classId, $studentId): void
{
    $statement = $db->prepare("DELETE FROM inclass WHERE id_class = '$classId' AND id_user = '$studentId'");
    $statement->execute();
}

function updateClass($db, $classId, $name, $description): void
{
    $statement = $db->prepare("UPDATE class SET description = '$description', name = '$name' WHERE id = '$classId'");
    $statement->execute();
}

function generateCodeClass($db, $classId, $nUses): string
{
    $code = bin2hex(random_bytes(5));
    $statement = $db->prepare("SELECT * FROM codes_class WHERE code = '$code'");
    $statement->execute();
    $codeClass = $statement->fetch();
    if ($codeClass) {
        while ($codeClass['code'] == $code) {
            $code = bin2hex(random_bytes(5));
        }
    }
    $statement = $db->prepare("INSERT INTO codes_class (code,num_usage, id_associated) VALUES ('$code', '$nUses', '$classId')");
    $statement->execute();
    return $code;
}

function getClassCodes($db, $classId)
{
    $statement = $db->prepare("SELECT code, num_usage FROM codes_class WHERE id_associated = '$classId' AND num_usage > 0");
    $statement->execute();
    return $statement->fetchAll();
}