<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
require_once __DIR__ . '/../db/Database.php';

use db\Database;
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $db = Database::getInstance();
    $user = $db->getUserByEmail($_POST['email']);
    if ($user) {
        if (password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        }
    }
}
header('Location: /index.php');
exit();