<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
if (!empty($_POST['name']) && !empty($_POST['desc'])) {
    $db->beginTransaction();
    $db->commit();
    header('Location: /index.php');
    exit();
}
