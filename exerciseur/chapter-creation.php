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
                        <li> <input id="param1" type="radio" name="param1" value="0"><p>0</p> </li>
                        <li> <input id="param1" type="radio" name="param1" value="1"><p>1</p> </li>
                        
                        <li> <input id="param2" type="radio" name="param2" value="2"><p>2</p> </li>
                        <li> <input id="param2" type="radio" name="param2" value="2"><p>3</p> </li>
                        
                        <li> <input id="param3" type="radio" name="param3" value="3"><p>4</p> </li>
                        <li> <input id="param3" type="radio" name="param3" value="4"><p>5</p> </li>
                    </ul>
                </fieldset>

                <fieldset>
                    <legend>Question 1</legend>
                    <input type="textarea">
                    <label for="illutration">Photo</label>
                    <input id="illustration" type="file" name="illustration" accept=".jpg, .png">
                </fieldset>

                <fieldset>
                    <legend>Question 2</legend>
                    <input type="textarea">
                    <label for="illutration">Photo</label>
                    <input id="illustration" type="file" name="illustration" accept=".jpg, .png">
                </fieldset>

                <fieldset>
                    <legend>Question 3</legend>
                    <input type="textarea">
                    <label for="illutration">Photo</label>
                    <input id="illustration" type="file" name="illustration" accept=".jpg, .png">
                </fieldset>

                <fieldset>
                    <legend>Question 4</legend>
                    <input type="textarea">
                    <label for="illutration">Photo</label>
                    <input id="illustration" type="file" name="illustration" accept=".jpg, .png">
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