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

            <form action="section.php" method="post">

                <fieldset>
                    <legend>Séléctionnez le type de section que vous souhaitez ajouter</legend>


                    <div>
                        <input type="radio" id="courseSection" name="sectionType" value="text" checked />
                        <label for="courseSection">Section de cours</label> <img src="info.png" alt="plus d'info" width="15" height="15"> <!-- ajouter une pop up quand "plus d'info" est hover -->
                    </div>

                    <div>
                        <input type="radio" id="openExerciseSection" name="sectionType" value="text" checked />
                        <label for="openExerciseSection">Section d'exercice à question ouverte</label> <img src="info.png" alt="plus d'info" width="15" height="15"> <!-- ajouter une pop up quand "plus d'info" est hover -->
                    </div>

                    <div>
                        <input type="radio" id="multipleChoiceExerciseSection" name="sectionType" value="text" checked />
                        <label for="multipleChoiceExerciseSection">Section d'exercice à choix multiples</label> <img src="info.png" alt="plus d'info" width="15" height="15"> <!-- ajouter une pop up quand "plus d'info" est hover -->
                    </div>
                    <div>
                        <input type="radio" id="trueFalseExerciseSection" name="sectionType" value="text" checked />
                        <label for="trueFalseExerciseSection">Section d'exercice Vrai ou Faux</label> <img src="info.png" alt="plus d'info" width="15" height="15"> <!-- ajouter une pop up quand "plus d'info" est hover -->
                    </div>
                    <div>
                        <input type="radio" id="dropdownExerciseSection" name="sectionType" value="text" checked />
                        <label for="dropdownExerciseSection">Section d'exercice à menu déroulant</label> <img src="info.png" alt="plus d'info" width="15" height="15"> <!-- ajouter une pop up quand "plus d'info" est hover -->
                    </div>
                    <div>
                        <input type="radio" id="matchingPointsExerciseSection" name="sectionType" value="text" checked />
                        <label for="matchingPointsExerciseSection">Section d'exercice de points à relier</label> <img src="info.png" alt="plus d'info" width="15" height="15"> <!-- ajouter une pop up quand "plus d'info" est hover -->
                    </div>
                    <div>
                        <input type="radio" id="numericAnswerExerciseSection" name="sectionType" value="text" checked />
                        <label for="numericAnswerExerciseSection">Section d'exercice à réponse numérique</label> <img src="info.png" alt="plus d'info" width="15" height="15"> <!-- ajouter une pop up quand "plus d'info" est hover -->
                    </div>
                    <div>
                        <input type="radio" id="dragNDropExerciseSection" name="sectionType" value="text" checked />
                        <label for="dragNDropExerciseSection">Section d'exercice de placement d'objet</label> <img src="info.png" alt="plus d'info" width="15" height="15"> <!-- ajouter une pop up quand "plus d'info" est hover -->
                    </div>


                </fieldset>


                <div>
                    <button type="submit" class="btn">Valider</button>
                    <button type="submit" class="btn" formaction="">Terminer le Chapitre</button>-
                    <!-- second submit button to end chapter creation, action needs to be set to another page to end chapter creation -->
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