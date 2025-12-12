<?php 
include_once __DIR__ . '/config/config.php';
include_once __DIR__ . '/db/db-connection.php';
if (!isset($_SESSION["user"])) {
    header('Location: /index.php');
    exit();
} else if ($_SESSION["user"]["type"] != "teacher") {
    header('Location: /index.php');
    exit();
}else if (!isset($_SESSION['current_chapter_id'])) {
    header('Location: /index.php');
    exit();
}



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


            <form action="processing-forms/processing-section.php" method="post" id ="dynamic-form">

                <fieldset>
                    <legend>Paramètres de la section</legend>   

                    <ul>   
                        <li><h3>Options de notation</h3></li>
                        <li>
                            <span> 
                                <label for="weight">Coefficient (nécéssaire même si non notée, pour les statistiques):</label>
                                <input id="weight" name="weight" type="number" min="0" max="100" step="1" default="0">
                            </span>
                        </li>

                        <li><h3>Options de temps</h3></li>

                        <li>
                            <span> 
                                <label for="time">Limite de temps (en minutes, 0 pour illimité):</label>
                                <input id="time" name="time" type="number" min="0" max="2048" step="1" default="0">
                            </span>
                        </li>

                        <li><h3>Options d'essais</h3></li>

                        <li> <input id="tries" type="checkbox" name="tries"><label for="tries">Limiter le nombre d'essais ? </label>
                            <span> <!-- only show this span if 'tries' checkbox checked -->
                                <label for="tries-number">Nombre d'essais autorisés:</label>
                                <input id="tries-number" name="tries_number" type="number" min="1" max="100" step="1" default="1">
                            </span>
                    
                        </li>

                        <li><h3>Options de réponses</h3></li>

                        <li> 
                            <input id="ansdef" type="checkbox" name="ansdef"><label for="ansdef">Réponses définitives? (pas de modification possible après avoir quité la page ou validé la réponse)</label>
                             <!-- only show this input if 'ansdef' checkbox checked -->
                            <input id="showans" type="checkbox" name="showans"><label for="showans">Montrer la réponse après la validation</label>
                        </li>

                        
                    
                    </ul>

                </fieldset>

                <fieldset>
                    <legend>Création de la section</legend>

                    <ul>

                    
                        

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

                <button type="submit">Enregistrer la section et continuer</button>
                <button type="submit">Enregistrer la section et terminer le chapitre</button>


                </form>
            

            <aside id="chapter-creation-aside-2">
               <h2>Raccourcis</h2>
               
                <form >
                    <button type="button" id="add-text">Ajouter un champ de texte</button>
                    <span>Titres <img src="Arrow-down.svg" alt="arrow" width="5px" height="5px"></span> 
                    <!-- show buttons if the span is clicked (and change image)-->
                    <button type="button" id="add-title-1">Ajouter un titre 1</button>
                    <button type="button" id="add-title-2">Ajouter un titre 2</button>
                    <button type="button" id="add-title-3">Ajouter un titre 3</button>
                    <button type="button" id="add-title-4">Ajouter un titre 4</button>
                    <button type="button" id="add-title-5">Ajouter un titre 5</button>
                    <button type="button" id="add-hint">Ajouter un indice</button>
                </form>

                

                <div id="add-symbols-btn">

                </div>

                <div id="symbols">

                </div>
            </aside>
        </main>

        
        

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 

        <script type="text/javascript" src="js/math-symbol.js"></script>
        <script type=text/javascript src="js/modular-section.js"></script>
        
    </body>
</html>