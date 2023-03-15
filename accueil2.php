<?php
    include("menu.php")
?>

<!DOCTYPE html>
<html>
    <head>
        <title>CampusParis</title>
        <link rel="stylesheet" href="projet.css">
        <meta charset="UTF-8">
        <meta name="author" content="Kylian, Eva">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans" rel="stylesheet">
    </head>
    <body>
    <?php menu("Se connecter","accueil");?>
    <div class="element_flex">
        <div class="element_flex1">
            <h1>Rejoins de nombreuses communautés étudiantes</h1>
            <form action="accueil.php" method="post">
                <label for="Mail">Mail</label>
                <input type="text" name="Mail">
                <label for="mdp">Mot de passe (6 caractères minimum)</label>
                <input type="password" name="mdp">
                <input type="submit" class="button" value="S'inscrire">
            </form>
        </div>
        <div class="element_flex2">
            <img id="gens" src="image/gens.png" alt="">
        </div>
    </div>
    </body>
</html>