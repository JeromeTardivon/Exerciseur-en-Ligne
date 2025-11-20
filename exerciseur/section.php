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


            <form action="section-process.php" method="post">

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

                        

                    </ul>   

                    

                    

                </fieldset>

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