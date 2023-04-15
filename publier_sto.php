<?php
session_start();

include("publi.php");

$connexion = data();

include("menu_gauche.php");

if(!empty($_POST['submit'])){
  if( !empty($_FILES['publication']['name']) ){
            $nomImage = 'image'.$_SESSION['utilisateur'].'.png';
            if(move_uploaded_file($_FILES['publication']['tmp_name'], 'story/'.$nomImage))
            {
            $req2= 'UPDATE utilisateur SET story=1 WHERE id="'.$_SESSION['utilisateur'].'"';
            mysqli_query($connexion, $req2);
            header('location:accueil_publi.php');
            }
          else
          {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
      }
      else
      {
        $message = 'Veuillez mettre une image';
      }
}

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
        <?php menu_gauche(2);?>
<div class="publier_box">
<img src="image/image.png">
<p>Importer une photo</p>
<form enctype="multipart/form-data" action="publier_sto.php" method="post">
    <?php echo $message;?>
    <div class="importer">   
    <label id="importer" for="file">IMPORTER</label>
    <input type="file" name="publication" id="file"></div>
    <input type="submit" name="submit" value="POSTER">
</form>
<a href="publier.php">Poster une publication</a>
</div>



        
    </body>
</html>