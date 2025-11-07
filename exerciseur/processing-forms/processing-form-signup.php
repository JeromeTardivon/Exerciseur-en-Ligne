<?php
include_once __DIR__ . '/../db/db-connection.php';
if (!empty($_POST['lastname']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $statement = $db->prepare("SELECT mail FROM users s WHERE s.mail LIKE :email");
    $statement->execute(['email' => $_POST['email']]);
    $user = $statement->fetch();
    if (!$user) {
        $statement = $db->prepare("INSERT INTO users (name, surname, mail, password, type) VALUES (:lastname, :surName, :email, :password, :type)");
        $statement->execute(['email' => $_POST['email'], 'lastname' => $_POST['lastname'], 'surName' => $_POST['surname'], 'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), 'type' => $_POST['status']]);
    }
}
header('Location: /index.php');
exit();