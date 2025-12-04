<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
if (isset($_POST['visibility']) && isset($_POST['level-select']) && isset($_POST['class-select']) && isset($_POST['tags_input']) && isset($_POST['title']) && isset($_POST['desc']) && isset($_SESSION['user']) && $_SESSION['user']['type'] === 'instructor')
     {
    $visibility = $_POST['visibility'];
    $level = $_POST['level-select'];
    $class = $_POST['class-select'];
    $tags = $_POST['tags_input'];
    $title = $_POST['title'];
    $description = $_POST['desc'];
    $show_correction_end = isset($_POST['correctionend']) ? $_POST['correctionend'] : 0;
    $instructor_id = $_SESSION['user']['id'];

    echo "Visibility: " . $visibility . "<br>";
    echo "Level: " . $level . "<br>";
    echo "Class: " . $class . "<br>";
    echo "Tags: " . $tags . "<br>";
    echo "Title: " . $title . "<br>";
    echo "Description: " . $description . "<br>";
    echo "Show Correction at End: " . $show_correction_end . "<br>";





    
}
// header('Location: /index.php');
exit();