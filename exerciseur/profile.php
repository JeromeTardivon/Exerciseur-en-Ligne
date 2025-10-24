<html lang="fr">
    <?php $_TITLE = "Profile" ;include 'modules/include.php' ; ?>
    <body>
        <!-- nav -->
         <?php include 'modules/header.php' ?>

        <main id="main-profile">
            <aside>
                <div id="profile">
                    <!-- image placeholder A CHANGER -->
                    <img src="exercisor3000.png" alt="photo de profil">
                    <div>
                        <h2>NOM Prénom</h2>
                        
                        <p>
                            <strong>Identifiant : </strong>
                            xxxxxxxxxxxxxxxxxxxxxxxxx
                        </p>
                        <p>élève / professeur</p>
                    </div>
                </div>

                <div id="profile-details">
                    <div>
                        <h2>Historique exercice</h2>
                        <ul>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                            <li>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</li>
                        </ul>
                    </div>   
                    <div>
                        <h2>Classes</h2>
                        <ul>
                            <li>Science_1ere</li>
                            <li>Maths_term</li>
                            <li>Philo_term</li>
                        </ul>
                    </div>
                </div>

            </aside>

            <div>
                <h2>Tableau de notes</h2>
                <table>
                    <tr>
                        <th >exercice1</th>
                        <td>xx</td>
                        <td>mathématiques</td>
                        <td>10/06/2025</td>
                    </tr>
                    <tr>
                        <th >exercice2</th>
                        <td>xx</td>
                        <td>physique</td>
                        <td>10/06/2025</td>
                    </tr>
                    <tr>
                        <th >exercice3</th>
                        <td>xx</td>
                        <td>droit</td>
                        <td>10/06/2025</td>
                    </tr>
                    <tr>
                        <th >exercice4</th>
                        <td>xx</td>
                        <td>SVT</td>
                        <td>10/06/2025</td>
                    </tr>       
                </table>
            </div>
        </main>

        

        <!-- footer -->
        <?php include 'modules/footer.php' ?>        
    </body>
</html>