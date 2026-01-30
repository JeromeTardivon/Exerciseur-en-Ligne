<?php 
include_once __DIR__ . '/config/config.php';
include_once __DIR__ . '/db/db-connection.php';
include_once __DIR__ . '/db/Database.php';
use db\Database;
$db = Database::getInstance();
$classes = $db->getClasses($_SESSION["user"]["id"]);
if (!isset($_SESSION["user"])) {
    header('Location: /index.php');
    exit();
} else if ($_SESSION["user"]["type"] != "teacher" && $_SESSION["user"]["type"] != "admin") {
    header('Location: /index.php');
    exit();
}else if (!isset($_GET['id-chapter'])) {
    header('Location: /index.php');
    exit();
}else if($db->chapterBelongsToTeacher($_GET['id-chapter'],$_SESSION['user']['id'])==false) {
    header('Location: /index.php');
    exit();
}
$_SESSION['current_chapter_id'] = $_GET['id-chapter'];
?>


<!DOCTYPE html>
<html lang="fr">
    <?php include 'modules/include.php' ?>
    
    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>

        <main id="modif-selection">     

            <form action="processing-forms/processing-chapter-edition.php?id-chapter=<?php echo $_GET['id-chapter']; ?>" method="post">
                <fieldset>
                    <legend>Paramètres</legend>
                    <ul>
                        <li><h3>Visibilité</h3></li>
                        <li><input id="visibilityPublic" type="radio" name="visibility" value="1"><label for='visibilityPublic'>Publique</label>
                        </li>
                        <li><input id="visibilityPrivate" type="radio" name="visibility" value="0" checked='checked'><label for='visibilityPrivate'>Privée</label></li>
                        <li><h3>Niveau</h3></li>
                        <li>
                            <label for="level-select">Choisissez le niveau du chapitre</label>
                            <select name="level-select" id="level-select">
                                <option value="0">Non spécifié</option>
                                <option value="1">Primaire</option>
                                <option value="2">CE1</option>
                                <option value="3">CE2</option>
                                <option value="4">CM1</option>
                                <option value="5">CM2</option>
                                <option value="6">Collège</option>
                                <option value="7">Sixième</option>
                                <option value="8">Cinquième</option>
                                <option value="9">Quatrième</option>
                                <option value="10">Troisième</option>
                                <option value="11">Lycée</option>
                                <option value="12">Seconde</option>
                                <option value="13">Première</option>
                                <option value="14">Terminale</option>
                                <option value="15">Etudes Supérieures</option>
                            </select>
                        </li>

                        <li><h3>Limite de temps</h3></li>

                        <li><input id='timelimit' type="checkbox" name="timelimit"><label for='timelimit'>Ajouter une limite de
                                temps</label></li>
                        <li>
                            <div id="timelimit-box"> <!-- hide everything in this span if checkbox not checked -->
                                <label for="timelimit-hours" class="visually-hidden">Heures</label>
                                <input id="timelimit-hours" name="timelimit_hours" type="number" min="0" max="2048" step="1" value="0">
                                <label for="timelimit-minutes" >Minutes</label>
                                <input id="timelimit-minutes" name="timelimit_minutes" type="number" min="0" max="59" step="1" value="30">
                                <label for="timelimit-seconds" >Secondes</label>
                                <input id="timelimit-seconds" name="timelimit_seconds" type="number" min="0" max="59" step="1" value="0">
                            </div>
                        </li>
                        <li><h3>Classe</h3></li>
                        <li>
                            <label for="class-select">Choisissez la classe dans laquelle ce chapitre sera inscrite</label>
                            <select name="class-select" id="class-select">
                                <option value="unspecified">Hors d'une classe</option>
                                <!-- dynamically generates options with php, getting all classes the professor is responsible for in the database-->
                                <?php
                                foreach ($classes as $class) {
                                    echo '<option value="' . $class["name"] . '">' . $class["name"] . '</option>';
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <div id="grade-options"><!-- only show this span if a class is selected -->
                                <input id="graded" type="checkbox" name="graded" value="3"><label for="graded">Noter ce
                                    chapitre?</label>
                                <div id="coefficient-box"> <!-- only show this span if 'graded' checkbox checked -->
                                    <label for="grade-weight">Coefficient:</label>
                                    <input id="grade-weight" name="grade_weight" type="number" min="1" max="100" step="1"
                                        value="1">
                                </div>
                            </div>
                        </li>

                        <li><h3>Essais</h3></li>

                        <li><input id="limittry" type="checkbox" name="limittry"><label for="limittry">Limiter le nombre
                                d'essais ? (pour le chapitre complet) </label>
                            <div id="limit-try-options"> <!-- only show this span if 'limittry' checkbox checked -->
                                <label for="try-number">Nombre d'essais autorisés :</label>
                                <input id="try-number" name="try_number" type="number" min="1" max="100" step="1" value="1">
                            </div>
                        </li>
                        <li><h3>Correction</h3></li>
                        <li><input id="correctionend" type="checkbox" name="correctionend"><label for="correctionend">Afficher
                                la correction à la fin du chapitre?</label></li>

                        <li><h3>Tags</h3></li>
                        <li>
                            <label for="tags-input">Ajouter des tags (séparés par des virgules)</label>
                            <input id="tags-input" name="tags-input" type="text"
                                placeholder="ex: mathématiques, géométrie, fonctions">
                        </li>
                    </ul>
                </fieldset>
                <fieldset>
                    <legend>Création</legend>
                    <ul>
                        <li><label class="subTitle3" for="title">Titre :</label></li>
                        <li><input id="title" name="title" type="text" placeholder="Entrez le titre du chapitre ici" required></li>
                        <li><label class="subTitle3" for="desc">Description :</label></li>
                        <li><textarea id="desc" name="desc" rows="10" required></textarea></li>
                    </ul>
                </fieldset>
                <button type="submit">Valider la modifiacation des paramètres du chapitre</button>
            </form>

            <ul>   
                <li><h3>Choisir un Exercice à modifier</h3></li>
                        
                <?php 
                        
                    for ($i = 1; $i <= $db->getExercisesNumberFromChapter($_GET['id-chapter']); $i++) {
                            
                        echo "<li><a class='btn' href='exercise-edition.php?id-chapter=" . $_GET['id-chapter'] . "&exercise-num=" . $i ."'>Exercice " . $i ." : ". $db->getTitleExercise($db->getExerciseIdFromNum($_GET['id-chapter'], $i))."</a></li>";
                        
                    }
                ?>
                <li><a class='btn' href="section.php">Ajouter un exercice</a></li>
            </ul>
            <a href="teacher-space.php" class="btn">Annuler</a>
            
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 

    </body>
    <script>//setting up all the parameters
        document.getElementById('visibility<?php echo $db->getChapterVisibility($_GET['id-chapter'])==1 ? 'Public' : 'Private' ?>').checked = true;
        let levelSelect = document.getElementById('level-select');
        let level = <?php echo $db->getChapterLevel($_GET['id-chapter']) ?>;
        levelSelect.value = level;
        document.getElementById('timelimit').checked = <?php echo $db->getChapterTimeLimit($_GET['id-chapter']) != 0 ? 'true' : 'false' ?>;
        if (document.getElementById('timelimit').checked) {
            
            let time = <?php echo $db->getChapterTimeLimit($_GET['id-chapter'])?>;
            document.getElementById('timelimit-hours').value = Math.floor(time / 3600);
            time = time % 3600; 
            document.getElementById('timelimit-minutes').value = Math.floor(time / 60);
            time = time % 60;
            document.getElementById('timelimit-seconds').value = time;
        }
        let classSelect = document.getElementById('class-select');
        <?php $classId = $db->getChapterClass($_GET['id-chapter']);?>
        let classname = "<?php echo $db->getClassName($classId)?>";
        classSelect.value = classname;
        
        if(classSelect.value!="unspecified" && <?php echo $db->getChapterWeight($_GET['id-chapter'])!=null ? 'true' : 'false'?>){
            
            document.getElementById('graded').checked = true;
            document.getElementById('grade-weight').value = <?php echo $db->getChapterWeight($_GET['id-chapter'])==null? 0 : $db->getChapterWeight($_GET['id-chapter'])?>;
           
        }
        document.getElementById('limittry').checked = <?php echo $db->getChapterTries($_GET['id-chapter'])!=null ? 'true' : 'false'?>;
        if (document.getElementById('limittry').checked) {
            document.getElementById('try-number').value = <?php echo $db->getChapterTries($_GET['id-chapter'])==null? 0 : $db->getChapterTries($_GET['id-chapter'])?>;
        }
        document.getElementById('correctionend').checked = <?php echo $db->getChapterCorrend($_GET['id-chapter'])==1 ? 'true' : 'false' ?>;
        document.getElementById('title').value = `<?php echo str_replace("`","'",  $db->getChapterTitle($_GET['id-chapter'])) ?>`;
        document.getElementById('desc').value = `<?php echo str_replace("`","'",  $db->getChapterDescription($_GET['id-chapter'])) ?>`;;
        

    </script>
    <script> //reseting localstorage in case the 'go back' button (<-) has been pressed from chapter edition (else it will keep the section's modules in memory)
        localStorage.removeItem('dynamicModules');
    </script>
</html>