<?php
include_once __DIR__ . '/../db/db-connection.php';
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $statement = $db->prepare("SELECT * FROM users WHERE mail = :emailUser");
    $statement->execute(['emailUser' => $_POST['email']]);
    $user = $statement->fetch();
    if ($user) {
        if (password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        }
    }
}
header('Location: /index.php');
exit();