<?php

session_start();

    include("menu_gauche.php");
    include("publi.php");
    include("story.php");

    $connexion = data();
    //On évite les injections SQL
    $user = mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);

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
        <?php menu_gauche(0);?>     <!--Affiche le menu de gauche -->
    <div id="profil_publi">
        <div class="publi_box">
            <?php 

            //Récupère l'info de si l'utilisateur est admin ou non
            $req = 'SELECT administrateur FROM utilisateur WHERE id = "'.$user.'"';
            $resultat = mysqli_query($connexion, $req);

            if($resultat){
                $admin = mysqli_fetch_assoc($resultat);

                //Si l'utilisateur est admin, on affiche toutes les publications
                if($admin['administrateur'] == 1){  
                    //Récupère toutes les publications
                    $req1 = 'SELECT id FROM publication ORDER BY id DESC';
                    $resultat1 = mysqli_query($connexion, $req1);

                    if($resultat1){

                        //Affiche les publications
                        while($ligne = mysqli_fetch_assoc($resultat1)){
                            publi($ligne['id'],0);
                        }
                    }
                    
                    else {
                        echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
                    }
                } 

                //S'il n'est pas admin, on affiche les publications des gens qu'il suit
                else{ 
                    //Récupère tous les utilisateurs qu'il suit
                    $req2 = 'SELECT suivi FROM suivi WHERE suiveur = "'.$user.'"';
                    $resultat2 = mysqli_query($connexion, $req2);

                    if ($resultat2) {

                        while ($suivi = mysqli_fetch_assoc($resultat2)) {
                            $utilisateur_suivi = $suivi['suivi'];
                            //Récupère les publications des personnes suivies par l'utilisateur
                            $req3 = "SELECT * FROM publication WHERE utilisateur='$utilisateur_suivi' ORDER BY id ASC";
                            $resultat3 = mysqli_query($connexion, $req3);

                            if ($resultat3) {
                                
                                // Affiche les publications
                                while ($ligne = mysqli_fetch_assoc($resultat3)) {
                                    publi($ligne['id'],0);
                                }
                            } 

                            else {
                                echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
                            }
                        }
                    } 

                    else {
                        echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
                    }
                }
            }

            else {
                echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
            }


            ?>
        </div>
    </div>
        <div id="story_box">
            <?php

                $req = 'SELECT * FROM suivi WHERE suiveur = "'.$user.'"';
                $resultat1 = mysqli_query($connexion, $req);

                while($suivi = mysqli_fetch_assoc($resultat1)){
                    $req2= 'SELECT * FROM utilisateur WHERE id='.$suivi["suivi"].' ';
                    $resultat = mysqli_query($connexion, $req2);
                    $ligne=mysqli_fetch_assoc($resultat);

                    if($ligne['story']!=0){
                        if(time()-$ligne['story']>86400){
                            $req3= 'UPDATE utilisateur SET story=0 WHERE id="'.$ligne['id'].'"';
                            mysqli_query($connexion, $req3);
                        }
                        else{
                            story($ligne);
                            image_story($ligne);
                        }
                    }
                }
                mysqli_close($connexion);
                
                ?>
                
        </div>
    </body>
</html>


