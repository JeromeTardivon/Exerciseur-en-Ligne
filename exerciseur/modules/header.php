<?php
include_once __DIR__ .'/../db/db-connection.php';
?>
<header>
    <div class="barHeader">
        <a href="/index.php">
            <img src="/img/exercisor3000.png" alt="">
        </a>
        <h1><?php if(isset($_TITLE)){echo $_TITLE;}else{echo "Exerciseur en ligne";} ?></h1>
        <div class="buttonsHeader">
            <a class="btn" href="../teacher-space.php">Espace Professeurs</a>
            <?php
                if (empty($_SESSION['user'])){
                    echo '<a  class="btn" href="../login.php">Se connecter/Creer compte</a>';
                }else{
                    echo '<a  class="btn" href="../profile.php">Profil</a>';
                    echo '<a  class="btn" href="../processing-forms/processing-logout.php">Déconnexion </a>';
                }
            ?>
        </div>
    </div>
    <nav id="menu">
        <ul>
            <li><a href="/index.php">Accueil</a></li>
            <li><a href="/about.php">À propos</a></li>
            <li><a href="/contact.php">Contact</a></li>
            <li><a href="/settings-page.php">Paramètres</a></li>
        </ul>
    </nav>
</header>