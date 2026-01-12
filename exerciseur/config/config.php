<?php
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
session_start();

/**
 * @param $listIds
 * @param $id
 * @return bool
 * it searches if the id of the student is in the list of ids of students
 */
function isInList($listIds, $id): bool
{
    foreach ($listIds as $object) {
        if ($object == $id) {
            return true;
        }
    }
    return false;
}