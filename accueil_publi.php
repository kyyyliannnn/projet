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
<div class="publi_box">
<?php 
    $connexion = data();
    $req = 'SELECT * FROM suivi WHERE suiveur = "'.$_SESSION['utilisateur'].'"';
    $resultat1 = mysqli_query($connexion, $req);
    $suivi=mysqli_fetch_assoc($resultat1);
    while($suivi!=null){
        $req1= 'SELECT * FROM publication ORDER BY id DESC WHERE utilisateur="'.$suivi['suivi'].'"';
        $resultat = mysqli_query($connexion, $req1);
        $ligne=mysqli_fetch_assoc($resultat);
        while($ligne!=null){
            publi($ligne['id']);
            $ligne=mysqli_fetch_assoc($resultat);
        }
    }
    


        ?>
</div>
<div id="story_box">
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
</div> 
    </body>
</html>