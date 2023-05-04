<?php
session_start();
    include("menu_gauche.php");
    include("publi.php");
    include("story.php");
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
        <script>
            function affiche(publi){
                var c = document.getElementById('com_box' + publi);
                c.style.display = "inline";
                var d = document.getElementById('commentaire'+publi);
                d.style.display = "none";
            }

            function cache(publi){
                var c = document.getElementById('com_box'+publi);
                c.style.display = "none";
                var d = document.getElementById('commentaire'+publi);
                d.style.display = "inline";
            }


            function afficheMenuadmin(publi){
                var c = document.getElementById('admin'+publi);
                if(c.style.display=="none"){
                    c.style.display = "inline";
                }
                else{
                    c.style.display = "none";
                }
            }

            function affiche_story(id){
                var c = document.getElementById('sto' + id);
                c.style.display = "inline";
            }

            function cache_story(id){
                var c = document.getElementById('sto' + id);
                c.style.display = "none";
                var d = document.getElementById('rond' + id);
                d.style.borderColor = "#EED8C2";
            }


        </script>
    </head>
<body class="display">
        <?php menu_gauche(0);?>
<div id="profil_publi">
<div class="publi_box">
<?php 

$connexion = data();

$requete = 'SELECT administrateur FROM utilisateur WHERE id = "'.$_SESSION['utilisateur'].'"';
$resultat = mysqli_query($connexion, $requete);
if($resultat){
    $admin = mysqli_fetch_assoc($resultat);
    if($admin['administrateur'] == 1){
        $requete1 = 'SELECT id FROM publication ORDER BY id DESC';
        $resultat10 = mysqli_query($connexion, $requete1);
        if($resultat10){
            while($ligne = mysqli_fetch_assoc($resultat10)){
                publi($ligne['id']);
            }
        }
        else {
            // Gérer l'erreur
            echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
        }
    } 
    else{
        $req = 'SELECT suivi FROM suivi WHERE suiveur = "'.$_SESSION['utilisateur'].'"';
        $resultat1 = mysqli_query($connexion, $req);

        if ($resultat1) {
            // Traitement des résultats
            while ($suivi = mysqli_fetch_assoc($resultat1)) {
                $utilisateur_suivi = $suivi['suivi'];
                $req1 = "SELECT * FROM publication WHERE utilisateur='$utilisateur_suivi' ORDER BY id ASC";
                $resultat2 = mysqli_query($connexion, $req1);

                if ($resultat2) {
                    // Afficher les publications
                    while ($ligne = mysqli_fetch_assoc($resultat2)) {
                        publi($ligne['id']);
                    }
                } else {
                    // Gérer l'erreur
                    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
                }
            }
        } else {
            // Gérer l'erreur
            echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
        }
    }
}
else {
    // Gérer l'erreur
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
}

mysqli_close($connexion);

?>
    </div></div>
 <!-- <div id="story_box">
 <?php
    $req = 'SELECT * FROM suivi WHERE suiveur = "'.$_SESSION['utilisateur'].'"';
    $resultat1 = mysqli_query($connexion, $req);
    $suivi=mysqli_fetch_assoc($resultat1);
    while($suivi!=null){
        $req2= 'SELECT * FROM utilisateur WHERE story!=0 ';
        $resultat = mysqli_query($connexion, $req2);
        $ligne=mysqli_fetch_assoc($resultat);
        while($ligne!=null){
            if(time()-$ligne['story']>86400){
                $req3= 'UPDATE utilisateur SET story=0 WHERE id="'.$ligne['id'].'"';
            }
            else{
                story($ligne['id']);
                image_story($ligne['id']);
            }
            $ligne=mysqli_fetch_assoc($resultat);
        }
    }

    
    mysqli_close($connexion);?>
    </div> -->
    </body>
</html>


