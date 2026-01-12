<?php

include_once __DIR__ . '/config/config.php';

?>

<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE = "Contact";
include 'modules/include.php'; ?>
<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main id="main-contact">

    <!-- Il y aura peut-être des trucs à rajouter -->
    <p>IUT Lyon 1, Site de Bourg-en-Bresse :</p>
    <ul>
        <li>Adresse : 71 Rue Peter Fink, 01006 Bourg-en-Bresse (<a target="_blank" href="https://www.google.com/maps/place/IUT+Lyon+1+site+de+Bourg-en-Bresse/@46.2153029,5.2390429,16z/data=!3m1!4b1!4m6!3m5!1s0x47f352450afe1fb5:0x45e8e55ff39daf53!8m2!3d46.2152992!4d5.2416178!16s%252Fg%252F122vldt6">Google Maps</a>)
        </li>
        <li>Tél. : 04 74 45 50 59</li>
        <li>Mail : iutbourg.direction@univ-lyon1.fr</li>
        <li>Site : <a target="_blank" href="https://iut.univ-lyon1.fr">https://iut.univ-lyon1.fr</a></li>
    </ul>
</main>

<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>