<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';

if (isset($_POST['content'])&&isset($_POST['weight']) && isset($_POST['timelimit_hours']) && isset($_POST['timelimit_minutes']) && isset($_POST['timelimit_seconds']) && isset($_SESSION['user'])&&isset($_POST['section-title']) && $_SESSION['user']['type'] === 'teacher'){
    $weight = $_POST['weight'];
    $time = $_POST['timelimit_seconds'] + $_POST['timelimit_minutes'] * 60 + $_POST['timelimit_hours'] * 3600;
    $ansdef = isset($_POST['ansdef']) && $_POST['ansdef']=="on" ? 1 : 0;
    $showans = isset($_POST['showans']) && $_POST['showans'] == "on" ? 2 : $ansdef;
    $content = $_POST['content'];
    $title = $_POST['section-title']??'';
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

    $stmt = $db->prepare("INSERT INTO exercise (coef,title,timesec, tries, ansdef, id_chapter, content, showans, grade) VALUES (:coef, :title, :timesec, :tries, :ansdef, :id_chapter, :content, :showans, :grade)");  

    $stmt->execute([
        ':coef' => $weight,
        ':title' => $title,
        ':timesec' => $time,
        ':tries' => $tries_number,
        ':ansdef' => $ansdef,
        ':id_chapter' => $chapter_id,
        ':content' => $content,
        ':grade' => $grade,
        ':showans' => $showans
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

