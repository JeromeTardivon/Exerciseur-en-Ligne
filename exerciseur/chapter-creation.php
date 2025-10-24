<html lang="fr">
 <?php include 'modules/include.php' ?>

    <body>

        <!-- nav -->
        <?php include 'modules/header.php' ?>


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


        <main>           
            <form action="formulchapitre.php" method="post">

                <fieldset>
                    <legend>Paramètres</legend>
                    <input id="param1" type="radio" name="param1" value="0"><p>0</p>
                    <input id="param1" type="radio" name="param1" value="1"><p>1</p>

                    <input id="param2" type="radio" name="param2" value="2"><p>2</p>
                    <input id="param2" type="radio" name="param2" value="2"><p>3</p>

                    <input id="param3" type="radio" name="param3" value="3"><p>4</p>
                    <input id="param3" type="radio" name="param3" value="4"><p>5</p>
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
                    <button type=”submit”>Valider</button>
                    <button type=”reset”>Effacer</button>
                </div>

            </form>
        </main>


        <aside>
           <h2>Raccourcis</h2>
           <ul>      
                <li>Raccourcis1</li>
                <li>Raccourcis2</li>
                <li>Raccourcis3</li>
                <li>Raccourcis4</li>
           </ul>
        </aside>

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 

    </body>
</html>









