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
    <?php menu("S'inscrire");?>
    <div class="element_flex">
        <div class="element_flex1">
            <h1>Rejoins de nombreuses communautés étudiantes</h1>
            <form action="accueil.php" method="post">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo">
                <label for="pseudo">Mot de passe</label>
                <input type="password" name="pseudo">
                <a href="">Mot de passe oublié ?</a>
                <input type="submit" class="button">
            </form>
        </div>
        <div class="element_flex2">
            <img id="gens" src="image/gens.png" alt="">
        </div>
    </div>
    </body>
</html>