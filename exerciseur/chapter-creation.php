<?php
include_once __DIR__ . '/config/config.php';
include_once __DIR__ . '/db/db-connection.php';
require_once __DIR__ . '/db/Database.php';
use db\Database;

if (!isset($_SESSION["user"])) {
    header('Location: /index.php');
    exit();
} else if ($_SESSION["user"]["type"] != "teacher" && $_SESSION["user"]["type"] != "admin") {
    header('Location: /index.php');
    exit();
}
$db = Database::getInstance();
$classes = $db->getClasses($_SESSION["user"]["id"]);
?>
<!DOCTYPE html>
<html lang="fr">
 <?php include 'modules/include.php' ?>

    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>

        <main id="chapter-creation">     
            <aside>
                <h2>Outils</h2>
                <div>
                    <ul>      
                        <li>Outil1</li>
                        <li>Outil2</li>
                    </ul>
                </div>
                <div>
                    <ul>      
                        <li>Outil1</li>
                        <li>Outil2</li>
                    </ul>
                </div>
                <div>
                    <ul>      
                        <li>Outil1</li>
                        <li>Outil2</li>
                    </ul>
                </div> 
            </aside>

            <form action="processing-forms/processing-chapter-creation.php" method="post">

                <fieldset>
                    <legend>Paramètres</legend>
                    
                    <ul>
                        <li><h3>Visibilité</h3></li>
                        <li> <input id="visibilityPublic" type="radio" name="visibility" value = "1"><label for = 'visibilityPublic'>Publique</label> </li>
                        <li> <input id="visibilityPrivate" type="radio" name="visibility" value="0" checked = 'true'><label for = 'visibilityPrivate'>Privée</label> </li>
                    
                        <li><h3>Niveau</h3></li>
                        <li>
                            <label for="level-select">Choisissez le niveau du chapitre</label>
                            <select name="level-select" id="level-select">
                            <option value="0">Non spécifié</option>
                            <option value="10">Primaire</option>
                            <option value="11">CE1</option>
                            <option value="12">CE2</option>
                            <option value="13">CM1</option>
                            <option value="14">CM2</option>
                            <option value="20">Collège</option>
                            <option value="21">Sixième</option>
                            <option value="22">Cinquième</option>
                            <option value="23">Quatrième</option>
                            <option value="24">Troisième</option>
                            <option value="30">Lycée</option>
                            <option value="31">Seconde</option>
                            <option value="32">Première</option>
                            <option value="33">Terminale</option>
                            <option value="40">Etudes Supérieures</option>
                            
                            </select>
                        </li>

                        <li><h3>Limite de temps</h3></li>
                        
                        <li> <input id="timelimit" type="checkbox" name="timelimit" ><label for = 'timelimit'>Ajouter une limite de temps</label> </li>
                        <span> <!-- hide everything in this span if checkbox not checked -->
                            <label for="timelimit-seconds" >Secondes</label>
                            <input id="timelimit-seconds" name="timelimit_seconds" type="number" min="0" max="59" step="1" value="0">
                            <label for="timelimit-minutes" >Minutes</label>
                            <input id="timelimit-minutes" name="timelimit_minutes" type="number" min="0" max="59" step="1" value="30">
                            <label for="timelimit-hours" class="visually-hidden">Heures</label>
                            <input id="timelimit-hours" name="timelimit_hours" type="number" min="0" max="2048" step="1" value="0">
                        </span>

                        <li><h3>Classe</h3></li>
                        <li> 
                            <label for="class-select">Choisissez la classe dans laquelle ce chapitre sera inscrite</label>
                            <select name="class-select" id="class-select">
                            <option value="unspecified">Hors d'une classe</option>
                            
                            <!-- dynamically generates options with php, getting all classes the professor is responsible of in the database-->
                            <?php
                                foreach ($classes as $class) {
                                    echo '<option value="' . $class["name"] .'">' . $class["name"] .'</option>';
                                }
                            ?>
                            </select>

                            <span><!-- only show this span if a class is selected -->
                                <input id="graded" type="checkbox" name="graded" value="3"></li><label for="graded">Noter ce chapitre?</label>
                                <span> <!-- only show this span if 'graded' checkbox checked -->
                                    <label for="grade-weight">Coefficient:</label>
                                    <input id="grade-weight" name="grade_weight" type="number" min="1" max="100" step="1" value="1">
                                </span>
                            
                            </span>
                        </li>

                        <li><h3>Essais</h3></li>
                        
                        <li> <input id="limittry" type="checkbox" name="limittry" ><label for="limittry">Limiter le nombre d'essais ? (pour le chapitre complet) </label>

                            <span> <!-- only show this span if 'limittry' checkbox checked -->
                                <label for="try-number">Nombre d'essais autorisés:</label>
                                <input id="try-number" name="try_number" type="number" min="1" max="100" step="1" value="1">
                            </span>
                        </li>

                        <li><h3>Correction</h3></li>
                        <li> <input id="correctionend" type="checkbox" name="correctionend" ><label for="correctionend">Afficher la correction à la fin du chapitre?</label> </li>

                        <li><h3>Tags</h3></li>
                        <li>
                            <label for="tags-input">Ajouter des tags (séparés par des virgules)</label>
                            <input id="tags-input" name="tags_input" type="text" placeholder="ex: mathématiques, géométrie, fonctions">
                        </li>
                    </ul>
                </fieldset>

                <fieldset>
                    <legend>Création</legend>
                    
                    <ul>
                        <li>
                        
                            <label for="title"><h3>Titre :</h3></label>
                        </li>
                        <li>
                            <input id="title" name="title" type="text" placeholder="Entrez le titre du chapitre ici" required>
                        </li>

                        <li>
                            <label for="desc"><h3>Description :</h3></label>
                        </li>   
                        <li>
                            <textarea id="desc" name="desc" rows="10" required ></textarea>
                        </li>

                    </ul>
                </fieldset>

                

                <div>
                    <button type=”submit” class="btn">Valider</button>
                    
                </div>

            </form>

            <aside>
               <h2>Raccourcis</h2>
               
               <ul>      
                    <li class="btn">Raccourcis1</li>
                    <li class="btn">Raccourcis2</li>
                    <li class="btn">Raccourcis3</li>
                    <li class="btn">Raccourcis4</li>
               </ul>
            </aside>
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 
    </body>
</html>