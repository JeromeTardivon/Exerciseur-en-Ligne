<?php

use db\Database;

include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
require_once __DIR__ . '/../db/Database.php';
if (isset($_POST['create-code'])) {
    $db = Database::getInstance();
    $_SESSION['code-generated'] = $db->generateCode($_SESSION['user']['id'], 1);
    header("location: ../teacher-space.php");
    exit();
}
