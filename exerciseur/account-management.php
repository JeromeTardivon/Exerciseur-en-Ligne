<html lang="fr">
    <?php $_TITLE="Modification du profil"; include 'modules/include.php' ?>
    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>


         <form action="">
            <main id="main-profile">
                <aside>
                
                    
                    <!-- image placeholder mettre la pdp actuelle en défaut avec php/db-->
                    <img src="exercisor3000.png" alt="photo de profil">

                    <label for="image">Changer de photo de profil</label>
                    <input id="image" type="file" name="image" multiple="false" accept="image/png, image/jpeg">

                    <div id="profile-details">
                        <div>
                            <h3>Statut</h2>
                            <label for="status">Modifier le statut</label>
                            <input id="status" type="text"  name="status" maxlength="99">
                            <!-- mettre lle statut actuelle en défault avec php/db -->
                        </div>   


                        <div>
                            <h3>Description</h2>
                            <label for="message" id="labelmessage">Modifier la descrption</label>
                            <textarea id="message" name="message" rows="10" cols="50"  ></textarea>
                            <!-- mettre la description actuelle en défault avec php/db -->
                            <!-- mettre en resize :none en css -->
                        </div>
                    </div>
                        

                </aside>

                <div>
                    <h2>Informations non changeables :</h2>

                    <div>
                        <h3>NOM Prénom :</h2>
                        <div>XXXXXXXX XXXXXXXXXX</div>
                        
                    </div>

                    <div>
                        <h3>Mail :</h2>
                        <div>XXXXXXXX@XXXXXXXXXX</div>
                        
                    </div>

                    <div>
                        <h3>Type de compte : </h2>
                        <div>Etudiant/prof</div>
                        
                    </div>

                    <div>
                        <h3>Envoyer une demande de modification </h2>
                        <label for="modificationrequest" id="labelmessage">Message</label>
                        <textarea id="modificationrequest" name="modificationrequest" rows="10" cols="50"  ></textarea>

                        <!-- mettre en resize :none en css -->
                        
                    </div>


                </div>


                

                
                
            </main>
            <button class="submit" type="submit">Envoyer</button>
            <button type="reset">Effacer</button>
        </form>

        

        <!-- footer -->
        <?php include 'modules/footer.php' ?>        
    </body>
</html>