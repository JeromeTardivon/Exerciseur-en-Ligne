<?php
session_start();

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