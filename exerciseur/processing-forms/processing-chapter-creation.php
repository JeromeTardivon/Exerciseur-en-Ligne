<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../db/db-connection.php';
if (isset($_POST['visibility']) && isset($_POST['level-select']) && isset($_POST['class-select']) && isset($_POST['tags_input']) && isset($_POST['title']) && isset($_POST['desc']) && isset($_SESSION['user']) && $_SESSION['user']['type'] === 'teacher'){
    $visibility = $_POST['visibility'];
    $level = $_POST['level-select'];
    $class = $_POST['class-select'];
    $tags = $_POST['tags_input'];
    $title = $_POST['title'];
    $description = $_POST['desc'];
    $show_correction_end = isset($_POST['correctionend']) && $_POST['correctionend']== "on" ? 1 : 0;
    $instructor_id = $_SESSION['user']['id'];

  
    

    if(isset ($_POST['timelimit'])&& $_POST['timelimit']=="on" && isset($_POST['timelimit_seconds'])&& isset($_POST['timelimit_minutes'])&& isset($_POST['timelimit_hours']))
    {
        $timelimit = $_POST['timelimit_seconds']+$_POST['timelimit_minutes']*60+$_POST['timelimit_hours']*3600;
       

        

    }else
    {
        $timelimit = NULL;
       
    }

    if(isset ($_POST['try_number'])&& isset ($_POST['limittry'])&& $_POST['limittry']=="on")
    {
        $try_number = $_POST['try_number'];
       
    }else
    {
        $try_number = NULL;
        

    }

    if(isset($_POST['class-select']) && $_POST['class-select'] != 'unspecified'){
        $classtmp = $_POST['class-select'];

        $statement = $db->prepare("SELECT id FROM class WHERE name = :class_name ORDER BY created_at DESC LIMIT 1" );
        $statement->execute(['class_name' => $classtmp]);

        if($class = $statement->fetch()){
            
        }else{
            $class = null;
        }
        /******************************************** Used if we need to have an option to grade or not the chapters ********************************************/
        // if(isset($_POST['graded']) && $_POST['graded']==1 && isset($_POST['grade_weight'])){
        //     $grade_weight = $_POST['grade_weight'];
        // }else{
        //     $grade_weight = null;
        // }
    }

    $db->beginTransaction();
    $db->prepare("INSERT INTO chapter (visible, level, title, description, secondstimelimit, corrend, tries, class) VALUES (:visibility, :level, :title, :description, :time_limit, :show_correction_end, :max_tries, :class)")
       ->execute([
           'title' => $title,
           'description' => $description,
           'visibility' => $visibility,
           'level' => $level,
           'time_limit' => $timelimit,
           'max_tries' => $try_number,
           'show_correction_end' => $show_correction_end,
           'class' => $class ? $class['id'] : null,
       ]);

    
   

    $statement = $db->prepare("SELECT id FROM chapter ORDER BY created_at DESC LIMIT 1");
    $statement->execute();
    if($chapter = $statement->fetch()){

        $db->prepare("INSERT INTO owns (id_user, id_chapter) VALUES (:class_id, :chapter_id)")
        ->execute([
        'class_id' => $_SESSION['user']['id'],
        'chapter_id' => $chapter['id'],
        ]);

            
    }

    

    $db->commit();


    





    
}
header('Location: /index.php');
exit();