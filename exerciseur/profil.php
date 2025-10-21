<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- décommenter et mettre le css quand il existera -->
        <!-- <link rel="stylesheet" href="/css/style.css"> -->
        <title>Profil</title>
    </head>

    <body>
        <!-- nav -->
         <?php include 'modules/header.php' ?>

        <main>
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

        <aside>
            <div>
                <h2>NOM Prénom</h2>
                <img src="" alt="photo de profil">
                <p>
                    <strong>Identifiant : </strong>
                    xxxxxxxxxxxxxxxxxxxxxxxxx
                </p>
                <p>élève / professeur</p>
            </div>
            <div>
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

        <!-- footer -->
        <?php include 'modules/footer.php' ?>


        
    </body>
</html>