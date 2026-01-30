<?php
include_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../db/db-connection.php';
if (isset($_POST['visibility']) && isset($_POST['level-select']) && isset($_POST['class-select']) && isset($_POST['tags-input']) && isset($_POST['title']) && isset($_POST['desc']) && isset($_SESSION['user']) && $_SESSION['user']['type'] === 'teacher'&&isset($_GET['id-chapter'])) {
    $visibility = $_POST['visibility'];
    $level = $_POST['level-select'];
    $class = $_POST['class-select'];
    //$tags = $_POST['tags_input'];
    $title = $_POST['title'];
    $description = $_POST['desc'];
    $show_correction_end = isset($_POST['correctionend']) && $_POST['correctionend'] == "on" ? 1 : 0;
    $instructor_id = $_SESSION['user']['id'];
    if (isset ($_POST['timelimit']) && $_POST['timelimit'] == "on" && isset($_POST['timelimit_seconds']) && isset($_POST['timelimit_minutes']) && isset($_POST['timelimit_hours'])) {
        $timelimit = $_POST['timelimit_seconds'] + $_POST['timelimit_minutes'] * 60 + $_POST['timelimit_hours'] * 3600;
    } else {
        $timelimit = 0;
    }

    if (isset ($_POST['try_number']) && isset ($_POST['limittry']) && $_POST['limittry'] == "on") {
        $try_number = $_POST['try_number'];
    } else {
        $try_number = NULL;
    }
    if (isset($_POST['class-select']) && $_POST['class-select'] != 'unspecified') {
        $classtmp = $_POST['class-select'];
        $statement = $db->prepare("SELECT id FROM class WHERE name = :class_name ORDER BY created_at DESC LIMIT 1");
        $statement->execute(['class_name' => $classtmp]);
        if ($class = $statement->fetch()) {

        } else {
            $class = null;
        }
        
        if(isset($_POST['graded'])&&isset($_POST['grade-weight'])&& $_POST['graded']=="on"){
            $weight=$_POST['grade-weight'];
            
        }else{
            $weight = null; 
        }
    } else {
        $class = null;
        $weight= null;
    }
    
    
    $db->beginTransaction();
    $db->prepare("UPDATE chapter SET visible = :visibility, weight = :weight, level = :level, title = :title, description = :description, secondstimelimit = :time_limit, corrend = :show_correction_end, tries = :max_tries, class = :class, updated_at = NOW() WHERE id = :id")
        ->execute([
            'title' => $title,
            'description' => $description,
            'visibility' => $visibility,
            'level' => $level,
            'time_limit' => $timelimit,
            'max_tries' => $try_number,
            'show_correction_end' => $show_correction_end,
            'class' => $class ? $class['id'] : null,
            'weight' => $weight,
            'id' => $_GET['id-chapter'],
        ]);
   
    $db->commit();
}
header('Location: /modif-selection.php?id-chapter=' . $_GET['id-chapter']);
exit();