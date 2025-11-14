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

            <form action="formulchapitre.php" method="post">

                <fieldset>
                    <legend>Paramètres</legend>
                    
                    <ul>
                        <li><h3>Visibilité</h3></li>
                        <li> <input id="visibilite" type="radio" name="visibilite" value="0"><label for = 'visibilite'>Publique</label> </li>
                        <li> <input id="visibilite" type="radio" name="visibilite" value="1" checked = 'true'><label for = 'visibilite'>Privée</label> </li>
                    
                        <li><h3>Niveau</h3></li>
                        <li>
                            <label for="level-select">Choisissez le niveau du chapitre</label>
                            <select name="level-select" id="level-select">
                            <option value="unspecified">Non spécifié</option>
                            <option value="Primaire">Primaire</option>
                            <option value="CE1">CE1</option>
                            <option value="CE2">CE2</option>
                            <option value="CM1">CM1</option>
                            <option value="CM2">CM2</option>
                            <option value="College">Collège</option>
                            <option value="Sixième">Sixième</option>
                            <option value="Cinquième">Cinquième</option>
                            <option value="Quatrième">Quatrième</option>
                            <option value="Troisième">Troisième</option>
                            <option value="Lycee">Lycée</option>
                            <option value="Seconde">Seconde</option>
                            <option value="Première">Première</option>
                            <option value="Terminale">Terminale</option>
                            <option value="EtudesSuperieures">Etudes Superieures</option>
                            
                            </select>
                        </li>

                        <li><h3>Limite de temps</h3></li>
                        
                        <li> <input id="timelimit" type="checkbox" name="timelimit" value="2"><label for = 'timelimit'>Ajouter une limite de temps</label> </li>
                        <span> <!-- hide everything in this span if checkbox not checked -->
                            <label for="timelimit-seconds" >Secondes</label>
                            <input id="timelimit-seconds" name="timelimit_seconds" type="number" min="0" max="60" step="1" value="0">
                            <label for="timelimit-minutes" >Minutes</label>
                            <input id="timelimit-minutes" name="timelimit_minutes" type="number" min="0" max="60" step="1" value="30">
                            <label for="timelimit-hours" class="visually-hidden">Heures</label>
                            <input id="timelimit-hours" name="timelimit_hours" type="number" min="0" max="2048" step="1" value="0">
                        </span>

                        <li><h3>Classe</h3></li>
                        <li> 
                            <label for="class-select">Choisissez la classe dans laquelle ce chapitre sera inscrite</label>
                            <select name="class-select" id="class-select">
                            <option value="unspecified">Hors d'une classe</option>
                            <!-- dynamically generates options with php, getting all classes the professor is responsible of in the database-->
                            <?php ?>
                            </select>

                            <span><!-- only show this span if a class is selected -->
                                <input id="graded" type="checkbox" name="graded" value="3"></li><label for="graded">Noter ce chapitre?</label>
                                <span> <!-- only show this span if 'graded' checkbox checked -->
                                    <label for="grade-weight">Coefficient:</label>
                                    <input id="grade-weight" name="grade_weight" type="number" min="0" max="100" step="1" value="1">
                                </span>
                            
                            </span>
                        </li>

                        <li><h3>Essais</h3></li>
                        
                        <li> <input id="limittry" type="checkbox" name="limittry" value="4"><label for="limittry">Limiter le nombre d'essais ? (pour le chapitre complet) </label>

                            <span> <!-- only show this span if 'limittry' checkbox checked -->
                                <label for="try-number">Nombre d'essais autorisés:</label>
                                <input id="try-number" name="try_number" type="number" min="1" max="100" step="1" value="1">
                            </span>
                        </li>

                        <li><h3>Correction</h3></li>
                        <li> <input id="correctionend" type="checkbox" name="correctionend" value="5"><label for="correctionend">Afficher la correction à la fin du chapitre?</label> </li>

                        <li><h3>Tags</h3></li>
                        <li>
                            <label for="tags-input">Ajouter des tags (séparés par des virgules)</label>
                            <input id="tags-input" name="tags_input" type="text" placeholder="ex: mathématiques, géométrie, fonctions">
                        </li>
                    </ul>
                </fieldset>

                

                <div>
                    <button type=”submit” class="btn">Valider</button>
                    <button type=”reset” class="btn">Effacer</button>
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