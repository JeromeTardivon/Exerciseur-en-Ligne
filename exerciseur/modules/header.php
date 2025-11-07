<?php
include_once __DIR__ .'/../db/db-connection.php';
?>
<header>
    <div class="barHeader">
        <a href="/index.php">
            <img src="../exercisor3000.png" alt="">
        </a>
        <h1><?php if(isset($_TITLE)){echo $_TITLE;}else{echo "Xercizor 3000";} ?></h1>
        <div class="buttonsHeader">
            <a class="btn" href="../teacher-space.php">Espace Professeurs</a>
            <a  class="btn" href="../profile.php">Profil</a>
        </div>
    </div>
    <nav id="menu">
        <ul>
            <li><a href="../index.php">Accueil</a></li>
            <li>Mes classes</li>
            <li>Suivis</li>
            <li>Récents</li>
            <li>Mes Chapitres</li>
            <li>A propos</li>
            <li>Contact</li>
            <li><a href="../settings-page.php">Paramètres</a></li>
        </ul>
    </nav>
</header>