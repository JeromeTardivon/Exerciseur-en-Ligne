<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/Database.php';
use db\Database;
$db = Database::getInstance();


if (!isset($_SESSION["user"])) {
    header('Location: /');
    exit();
}

// changer les infos à afficher (surtout l'id)
$grades = $db->getGrades($_SESSION["user"]["id"]);
$list = $db->getClasses($_SESSION['user']['id']);

if (isset($_POST['code-class-add'])) {
    $db->addStudentToClassByCode($_SESSION["user"]["id"], $_POST['code-class-add']);
    header("Refresh:0");
}

?>

<!DOCTYPE html>

<html lang="fr">
<?php $_TITLE = "Profile";
include 'modules/include.php'; ?>
<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main id="main-profile">
    <aside>
        <div id="profile">
            <!-- image placeholder A CHANGER -->
            <img src="/img/profile-pic.jpg" alt="photo de profil">
            <div>
                <h2>
                    <?= $_SESSION['user']['name'] . " " . $_SESSION['user']['surname'] ?>
                </h2>
                <ul>
                    <li>
                        <p><strong> statut : </strong></p>
                        <img src="" alt="symbole statut">
                    </li>
                    <li>
                        <p>
                            <strong>Statut : </strong>
                            <?php

                            if ($_SESSION['user']['type'] == "student") {
                                echo "Étudiant";
                            } else {
                                echo "Enseignant";
                            }
                            ?>
                        </p>
                    </li>
                    <li>
                        <p>
                            <strong>Identifiant : </strong>

                            <?= $_SESSION['user']['schoolId'] ?>
                        </p>
                    </li>
                    <li>
                        <p>
                            <strong>Adresse mail : </strong>

                            <?= $_SESSION['user']['mail'] ?>
                        </p>
                    </li>
                </ul>
            </div>
        </div>

        <div id="profile-details">
            <div>
                <h2>Classes</h2>
                <ul>
                    <?php

                    foreach ($list as $class) { ?>
                        <li class="btn"><a href="class.php?id-class=<?= $class['id'] ?>"><?= $class['name'] ?></a></li>
                    <?php } ?>
                </ul>
                <form action="" method="post">
                    <label>
                        Rejoindre classe par code d'invitation
                        <input type="text" name="code-class-add">
                    </label>
                    <input type="submit" value="Rejoindre">
                </form>
            </div>
        </div>

    </aside>

    <div>
        <h2>Tableau de notes</h2>
        <?php

        if (count($grades) > 0) {
            echo "<table>";

            foreach ($grades as $g) {
                echo "<tr> \n";
                echo "<th>" . $g["id"] . "</th>";
                echo "<td>" . $g["title"] . "</td>";
                echo "<td>" . $g["grade"] . "</td>";
                echo "<td>" . $g["created_at"] . "</td>";

                echo "</tr>";
            }

            echo "</table>";

            echo "<a class='btn' href='/download-grades.php'>Télécharger notes en .csv</a>";
        } else {
            echo "<p>Vous n'avez pas encore de notes. Complétez des exercices pour obtenir des notes.</p>";
        }

        ?>
    </div>
</main>

<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>