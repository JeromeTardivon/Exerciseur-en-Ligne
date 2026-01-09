<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';

if (isset($_POST['content'])&&isset($_POST['weight']) && isset($_POST['time']) && isset($_SESSION['user']) && $_SESSION['user']['type'] === 'teacher'){
    $weight = $_POST['weight'];
    $time = $_POST['time'];
    $ansdef = isset($_POST['ansdef']) && $_POST['ansdef']=="on" ? 1 : 0;
    $showans = isset($_POST['showans']) && $_POST['showans'] == "on" ? 2 : $ansdef;
    $content = $_POST['content'];
    $grade = 0;
    if (isset($_POST["total-grade"])) {
        $grade =(float) $_POST["total-grade"];
    }
    
    $chapter_id = $_SESSION['current_chapter_id'];

    if(isset($_POST['tries']) && $_POST['tries'] == "on" && isset($_POST['tries_number'])) {
        $tries_number = $_POST['tries_number'];
    } else {
        $tries_number = null;
    }

    $stmt = $db->prepare("INSERT INTO exercise (coef, timesec, tries, ansdef, id_chapter, content, grade) VALUES (:coef, :timesec, :tries, :ansdef, :id_chapter, :content, :grade)");  

    $stmt->execute([
        ':coef' => $weight,
        ':timesec' => $time *60,
        ':tries' => $tries_number,
        ':ansdef' => $ansdef,
        ':id_chapter' => $chapter_id,
        ':content' => $content,
        ':grade' => $grade
    ]);
    
} else {
    header('Location: /index.php');
    exit();
}

//used to reset the local storage between sections
$_SESSION['clear_local_storage'] = true;

// decide where to redirect after successful save
$redirect = '/section.php';
if (isset($_POST['redirect']) && $_POST['redirect'] === 'index') {
    $redirect = '/index.php';
}

header('Location: ' . $redirect);
exit();
?>

