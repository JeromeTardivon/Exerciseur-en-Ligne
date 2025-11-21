<?php

require_once __DIR__ . '/db/db-connection.php';
require_once __DIR__ . '/config/config.php';

if (!isset($_SESSION["user"])) {
    header('Location: /');
    exit();
}

// changer les infos à afficher (surtout l'id)
$command = $db->prepare("SELECT e.id, c.title, r.grade, r.created_at FROM result r JOIN exercise e ON r.id_exercise = e.id JOIN chapter c ON r.id_subject = c.id WHERE r.id_user = :user");
$command->execute(["user" => $_SESSION["user"]["id"]]);

$grades = $command->fetchAll();

?>

<!DOCTYPE html>

<html lang="fr">
    <?php $_TITLE = "Profile" ;include 'modules/include.php' ; ?>
    <body>
        <!-- nav -->
         <?php include 'modules/header.php' ?>

        <main id="main-profile">
            <aside>
                <div id="profile">
                    <!-- image placeholder A CHANGER -->
                    <img src="exercisor3000.png" alt="photo de profil">
                    <div>
                        <h2>
                            <?= $_SESSION['user']['name'] . " " . $_SESSION['user']['surname'] ?>
                        </h2>
                        <ul>
                            <li>
                                <p><strong> statut : </strong></p>
                                <img src="" alt="symbole statut">
                            </li>
                            <li>
                                <p>
                                    <strong>Identifiant : </strong>
                                    
                                    <?= $_SESSION['user']['mail'] ?>
                                </p>
                            </li>
                            <li><p>
                                <?php
                                
                                if($_SESSION['user']['type'] == "student") {
                                    echo "Étudiant";
                                } else {
                                    echo "Enseignant";
                                }

                                ?>
                            </p></li>
                        </ul>
                        
                        
                        
                    </div>
                </div>

                <div id="profile-details">
                    <div>
                        <h2>Historique exercice</h2>
                        <ul>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                        </ul>
                    </div>   
                    <div>
                        <h2>Classes</h2>
                        <ul>
                            <?php

                            foreach (getTeachersClasses($db) as $class) {
                                echo "<li>" . $class['name'] . "</li>";
                            }

                            ?>
                        </ul>
                    </div>
                </div>

            </aside>

            <div>
                <h2>Tableau de notes</h2>
                <table>
                    <?php 

                    foreach ($grades as $g) {
                        echo "<tr> \n";
                        echo "<th>" . $g["id"] . "</th>";
                        echo "<td>" . $g["title"] . "</td>";
                        echo "<td>" . $g["grade"] . "</td>";
                        echo "<td>" . $g["created_at"] . "</td>";

                        echo "</tr>";
                    }
                    
                    ?>
                </table>
            </div>
        </main>

        

        <!-- footer -->
        <?php include 'modules/footer.php' ?>        
    </body>
</html>