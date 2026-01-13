<?php 
include_once __DIR__ . '/config/config.php';
include_once __DIR__ . '/db/db-connection.php';
include_once __DIR__ . '/db/Database.php';
use db\Database;
$db = Database::getInstance();
if (!isset($_SESSION["user"])) {
    header('Location: /index.php');
    exit();
} else if ($_SESSION["user"]["type"] != "teacher" && $_SESSION["user"]["type"] != "admin") {
    header('Location: /index.php');
    exit();
}else if (!isset($_GET['id-chapter'])||!isset($_GET['exercise-num'])) {
    header('Location: /index.php');
    exit();
}else if($db->chapterBelongsToTeacher($_GET['id-chapter'],$_SESSION['user']['id'])==false) {
    header('Location: /index.php');
    exit();
}else if ($_GET['exercise-num']>$db->getExercisesNumberFromChapter($_GET['id-chapter'])||$_GET['exercise-num']<1) {
    header('Location: /index.php');
    exit();
}



$content = $db->getExerciseContent($db->getExerciseIdFromNum($_GET['id-chapter'],$_GET['exercise-num']));

$_POST['content'] = $content;

$decoded = null;

if (!empty($content)) {
    
    $decoded = json_decode($content, true);
    
}
?>

<script>
    var payload = <?php echo $decoded !== null ? json_encode($decoded, JSON_UNESCAPED_UNICODE) : 'null'; ?>;
    
     //setting localstorage with exercise content so we dont need another function than "loadState()"
     if (payload !== null) {
        try { 
            localStorage.setItem('dynamicModules', JSON.stringify(payload)); } catch(e) { console && console.warn && console.warn('Failed to set dynamicModules', e); 
            $_SESSION['clear_local_storage'] = false;
        }
        
        } else {
          try { localStorage.removeItem('dynamicModules'); } catch(e) {}
     }
</script>




<!DOCTYPE html>
<html lang="fr">
    <?php include 'modules/include.php' ?>
    
    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>

        <main id="chapter-creation">     
            <aside id=chapter-creation-aside-1>
                <h2>Outils</h2>
                <div>
                    <div id="add-symbols-btn">
    
                    </div>
    
                    <div id="symbols">
    
                    </div>
                </div>
            </aside>


            <form action="processing-forms/processing-exercise-edition.php?id-chapter=<?php echo $_GET['id-chapter']; ?>&exercise-num=<?php echo $_GET['exercise-num']; ?>" method="post" id ="dynamic-form">

                <fieldset>
                    <legend>Paramètres de la section</legend>   

                    <ul>   
                        <li><h3>Options de notation</h3></li>
                        <li>
                            <span> 
                                <label for="weight">Coefficient (nécéssaire même si non notée, pour les statistiques):</label>
                                <input id="weight" name="weight" type="number" min="0" max="100" step="1" value= "0">
                            </span>
                        </li>

                        <li><h3>Options de temps</h3></li>

                        <li>
                            <span> 
                                <label for="time">Limite de temps (en minutes, 0 pour illimité):</label>
                                <input id="time" name="time" type="number" min="0" max="2048" step="1" value="0">
                            </span>
                        </li>

                        <li><h3>Options d'essais</h3></li>

                        <li> <input id="tries" type="checkbox" name="tries"><label for="tries">Limiter le nombre d'essais ? </label>
                            <span> <!-- only show this span if 'tries' checkbox checked -->
                                <label for="tries-number">Nombre d'essais autorisés:</label>
                                <input id="tries-number" name="tries_number" type="number" min="1" max="100" step="1" value="1">
                            </span>
                    
                        </li>

                        <li><h3>Options de réponses</h3></li>

                        <li> 
                            <input id="ansdef" type="checkbox" name="ansdef" value =><label for="ansdef">Réponses définitives? (pas de modification possible après avoir quité la page ou validé la réponse)</label>
                             <!-- only show this input if 'ansdef' checkbox checked -->
                            <input id="showans" type="checkbox" name="showans"><label for="showans">Montrer la réponse après la validation</label>
                        </li>

                        
                    
                    </ul>

                </fieldset>

                <fieldset>
                    <legend>Création de la section</legend>

                    
                    <ul>
                        <li>
                            <label for="total-grade" id="total-grade-display">Note totale : ?</label>
                            <input id="total-grade" type="text" name="total-grade" hidden>
                        </li>

                        <li><h3>Modules par défaut</h3></li>
                        <li>
                            <label for="section-title">Titre de la section</label>
                            <input id="section-title" type="text" name="section-title">
                        </li>

                        <li><h3>Modules dynamiques</h3></li>
                        
                        <li>
                            <div id="inputs"></div>
                        </li>
                    </ul>   
                    
                </fieldset>
                <fieldset>
                    <legend>Aperçu de l'exercice (point de vue d'un élève)</legend>
                    <div id="previews"></div>
                </fieldset>

                <button type="submit" id="accept-changes">Enregistrer les modifications</button>
                <button type="submit" id="cancel-changes">Annuler les modifications</button>

                </form>

            <aside id="chapter-creation-aside-2">
               <h2>Modules</h2>
               
                <form >
                    <button type="button" id="add-text">Ajouter un champ de texte</button>
                    

                    <!-- show buttons if the span is clicked (and change image)-->
                    <input type="checkbox" id="dropdown" hidden/>
                    <label for="dropdown">Titres <img src="Arrow-down.svg" alt="arrow" width="5px" height="5px"></label> 
                    <div>
                        <button type="button" id="add-title-1">Ajouter un titre 1</button>
                        <button type="button" id="add-title-2">Ajouter un titre 2</button>
                        <button type="button" id="add-title-3">Ajouter un titre 3</button>
                        <button type="button" id="add-title-4">Ajouter un titre 4</button>
                        <button type="button" id="add-title-5">Ajouter un titre 5</button>
                    </div>
                    <button type="button" id="add-multiple-choice">Ajouter une question QCM</button>
                    <button type="button" id="add-true-false">Ajouter une question Vrai/Faux</button>
                    <button type="button" id="add-open-question">Ajouter une question à réponse ouverte</button>
                    <button type="button" id="add-numerical-question">Ajouter une question numérique</button>
                    <button type="button" id="add-hint">Ajouter un indice</button>
                </form>
            </aside>
        </main>

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 

        <?php
        
        if (isset($_SESSION['clear_local_storage']) && $_SESSION['clear_local_storage']) {
            
            echo '<script>try{localStorage.removeItem("dynamicModules"); /*localStorage.clear();*/}catch(e){}</script>';
            unset($_SESSION['clear_local_storage']);
        }
        ?>

        <script type="text/javascript" src="js/math-symbol.js"></script>
        <script type=text/javascript src="js/modular-section.js"></script>
    </body>
</html>