<?php
session_start();

include("publi.php");



include("menu_gauche.php");



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
    <body class="display">
        <?php menu_gauche(1);?>
        <div id="rechercher">
<form id="recherche_form" action="recherche.php" method="post">
    <img src="image/recherche_o.png">
    <input type="text" name="recherche" placeholder="rechercher un compte ou un groupe...">
</form>
<div id="resultat">
<?php if(!empty($_POST['recherche'])){
    $connexion = data();
    $req1= 'SELECT * FROM utilisateur WHERE pseudo LIKE "%'.$_POST['recherche'].'%"';
    $resultat = mysqli_query($connexion, $req1);
    while($res=mysqli_fetch_assoc($resultat)){
        echo '<div class="entete"><a href="" class="pdp"><img src="pdp/personne'.$res['pdp'].'.png"></a>
        <a href="" class="pseudo">'.$res['pseudo'].'</a></div>';
    }
    } ?>
</div>
        </div>

        
    </body>
</html>