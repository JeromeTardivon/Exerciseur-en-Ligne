<?php

require_once __DIR__ . '/db/db-connection.php';
require_once __DIR__ . '/config/config.php';

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
                    <tr>
                        <th >exercice1</th>
                        <td>xx</td>
                        <td>mathématiques</td>
                        <td>10/06/2025</td>
                    </tr>
                    <tr>
                        <th >exercice2</th>
                        <td>xx</td>
                        <td>physique</td>
                        <td>10/06/2025</td>
                    </tr>
                    <tr>
                        <th >exercice3</th>
                        <td>xx</td>
                        <td>droit</td>
                        <td>10/06/2025</td>
                    </tr>
                    <tr>
                        <th >exercice4</th>
                        <td>xx</td>
                        <td>SVT</td>
                        <td>10/06/2025</td>
                    </tr>       
                </table>
            </div>
        </main>

        

        <!-- footer -->
        <?php include 'modules/footer.php' ?>        
    </body>
</html>