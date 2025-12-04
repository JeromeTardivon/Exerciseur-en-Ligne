<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
if (isset($_POST['create-code'])) {
    $_SESSION['code-generated'] = generateCode($db, $_SESSION['user']['id'], 1);
    header("location: ../teacher-space.php");
    exit();
}
