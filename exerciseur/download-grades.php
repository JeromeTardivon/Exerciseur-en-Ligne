<?php
//config
require_once __DIR__ . '/db/db-connection.php';
require_once __DIR__ . '/config/config.php';

// checks if user is connected
if (!isset($_SESSION["user"])) {
    // header('Location: /');
    // exit();
}

// changer les infos à afficher (surtout l'id)
$command = $db->prepare("SELECT e.id, c.title, r.grade, r.created_at FROM result r JOIN exercise e ON r.id_exercise = e.id JOIN chapter c ON r.id_subject = c.id WHERE r.id_user = :user");
$command->execute(["user" => $_SESSION["user"]["id"]]);

$grades = $command->fetchAll();

$namefile = "export.csv";
$content = "id,title,grade,created_at \n";

foreach ($grades as $g) {
    $content .= $g['id'] . ',' . $g['title'] . ',' . $g['grade'] . ',' . $g['created_at'] . '\n';
}



//save file
$file = fopen($namefile, "w") or die("Unable to open file!");
fwrite($file, $content);
fclose($file);

//header download
header("Content-Disposition: attachment; filename=\"" . $namefile . "\"");
header("Content-Type: application/force-download");
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header("Content-Type: text/plain");

echo $content;

// header("Location: /profile.php");