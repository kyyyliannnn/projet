<?php
    include("menu_gauche.php");
    include("publi.php");

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


            function afficheMenu(publi){
                var c = document.getElementById("option");
                c.style.display = "inline";
            }

        </script>
    </head>
    <body class="display">
        <?php menu_gauche(0);?>
<div class="publi_box">
<?php 
    $connexion = data();
    $req1= 'SELECT * FROM publication ORDER BY id DESC ';
    $resultat = mysqli_query($connexion, $req1);
    $ligne=mysqli_fetch_assoc($resultat);
    while($ligne!=null){
        publi($ligne['id']);
        $ligne=mysqli_fetch_assoc($resultat);
    }

    mysqli_close($connexion);
        ?>
</div>

        
    </body>
</html>