<?php
session_start();

if (!isset($_SESSION["user"])) {
    header('Location: /index.php');
    exit();
} else if ($_SESSION["user"]["type"] != "teacher") {
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

            <form action="formulchapitre.php" method="post">

                <fieldset>
                    <legend>Paramètres</legend>
                    
                    <ul>
                        <li> <input id="param1" type="checkbox" name="param1" value="0"><p>xxxxxxx</p> </li>
                        <li> <input id="param2" type="checkbox" name="param2" value="1"><p>xxxxxxx</p> </li>
                        
                        <li> <input id="param2" type="radio" name="param2" value="2"><p>xxxxxxx</p> </li>
                        <li> <input id="param2" type="radio" name="param2" value="2"><p>xxxxxxx</p> </li>
                        
                        <li> <input id="param4" type="checkbox" name="param4" value="4"><p>xxxxxxx</p> </li>
                        <li> <input id="param5" type="checkbox" name="param5" value="5"><p>xxxxxxx</p> </li>
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