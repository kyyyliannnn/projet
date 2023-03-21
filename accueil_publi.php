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
            function affiche(){
                var c = document.getElementById('com_box');
                c.style.display = "inline";
                var d = document.getElementById('commentaire');
                d.style.display = "none";
            }

            function cache(){
                var c = document.getElementById('com_box');
                c.style.display = "none";
                var d = document.getElementById('commentaire');
                d.style.display = "inline";
            }


            function afficheMenu(){
                var c = document.getElementById("option");
                c.style.display = "inline";
            }

        </script>
    </head>
    <body class="display">
        <?php menu_gauche(0);
        publi(2); 
        ?>
        
    </body>
</html>