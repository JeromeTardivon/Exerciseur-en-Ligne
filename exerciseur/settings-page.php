<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Profil</title>
</head>

<body>
<!-- nav -->
<?php include 'modules/header.php' ?>

<main>
    <form>
        <div>
            <div>
                <label for="display-settings">Paramètre d’affichage</label>
                <input type="radio" id="1" name="1" value="xxx" checked />
                <label for="1">xxxxxxx</label>
                <input type="radio" id="1" name="1" value="xxx"/>
                <label for="1">xxxxxxx</label>
                <input type="radio" id="1" name="1" value="xxx"/>
                <label for="1">xxxxxxx</label>
            </div>
            <div>
                <label for="range-font">XXXXXXXXX</label>
                <input type="range" id="range-font" name="range-font" min="0" max="11" />
            </div>
            <div>
                <p>Option des formules mathématiques</p>
                <input type="radio" id="2" name="4" value="xxx" checked />
                <label for="2">xxxxxxx</label>
                <input type="radio" id="2" name="4" value="xxx" />
                <label for="2">xxxxxxx</label>
            </div>

        </div>
        <div>
            <div>
                <p>Accessibilité</p>
                <p>
                    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                </p>
                <input type="radio" id="3" name="3" value="xxx" checked />
                <label for="3">xxxxxxx</label>
                <input type="radio" id="3" name="3" value="xxx" />
                <label for="3">xxxxxxx</label>
                <input type="radio" id="3" name="3" value="xxx" />
                <label for="3">xxxxxxx</label>
            </div>
            <div>
                <label for="language-select">Langage</label>
                <select name="language-select" id="language-select">
                    <option value="french">Français</option>
                    <option value="english">English</option>
                </select>
            </div>
        </div>
        <input type="submit">
    </form>

</main>

<!-- footer -->
<?php include 'modules/footer.php' ?>
</body>
</html>