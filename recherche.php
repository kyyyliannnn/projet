<?php
    session_start();

    include("publi.php");
    include("menu_gauche.php");

    $connexion = data();

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
        <?php menu_gauche(1);?>  <!--Affiche le menu gauche -->
        <div id="rechercher">
            <form id="recherche_form" action="recherche.php" method="post">  <!--Formulaire pour la recherche utilisateur -->
                <img src="image/recherche_o.png">
                <input type="text" name="recherche" placeholder="rechercher un compte ou un groupe...">
            </form>
            <div id="resultat">
                <?php 
                
                    if(!empty($_POST['recherche'])){
                        $connexion = data();
                        //Récupère les utilisateurs dont le pseudo correspond en partie avec ce qu'il y d'écrit dans le formulaire
                        $req1= 'SELECT * FROM utilisateur WHERE pseudo LIKE "%'.$_POST['recherche'].'%"';
                        $resultat = mysqli_query($connexion, $req1);
                        //Affiche les profils
                        while($res=mysqli_fetch_assoc($resultat)){
                            echo '<div class="entete">';
                            profil($res);
                            echo '</div>';
                        }
                    } 
                    
                ?>
            </div>
        </div> 
    </body>
</html>