<?php
//config
require_once __DIR__ . '/db/db-connection.php';
require_once __DIR__ . '/config/config.php';

// checks if user is connected
if (isset($_SESSION["user"])) {
    // changer les infos à afficher (surtout l'id)
    $grades = getGrades($db, $_SESSION["user"]["id"]);

    $namefile = "export.csv";
    $content = "id,title,grade,created_at \n";

    foreach ($grades as $g) {
        $content .= $g['id'] . ',' . $g['title'] . ',' . $g['grade'] . ',' . $g['created_at'] . "\n";
    }

    // saves file on the server
    $file = fopen($namefile, "w") or die("Unable to open file!");
    fwrite($file, $content);
    fclose($file);

    // header download
    header("Content-Disposition: attachment; filename=\"" . $namefile . "\"");
    header("Content-Type: application/force-download");
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header("Content-Type: text/plain");

    echo $content;

    // deletes the file on the server after it is downloaded
    unlink($namefile);
}