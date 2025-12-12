<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
if (isset($_POST['weight']) && isset($_POST['time']) && isset($_POST['ansdef']) && isset($_POST['showans']) &&isset($_SESSION['user']) && $_SESSION['user']['type'] === 'teacher'){
    


    $weight = $_POST['weight'];
    $time = $_POST['time'];
    $ansdef = $_POST['ansdef']=="on" ? 1 : 0;
    $ansdef = $_POST['showans'] == "on" ? 2 : $ansdef;

    $chapter_id = $_SESSION['current_chapter_id'];

    if(isset($_POST['tries']) && $_POST['tries'] == "on" && isset($_POST['tries_number'])) {
        $tries_number = $_POST['tries_number'];
    } else {
        $tries_number = null;
    }

    $stmt = $db->prepare("INSERT INTO exercise (coef, timesec, tries, ansdef, id_chapter) VALUES (:coef, :timesec, :tries, :ansdef, :id_chapter)");  

    $stmt->execute([
        ':coef' => $weight,
        ':timesec' => $time*60,
        ':tries' => $tries_number,
        ':ansdef' => $ansdef,
        ':id_chapter' => $chapter_id
    ]);



    


   
    
}
 header('Location: /section.php');
exit();