<?php
session_start();

include("publi.php");
$connexion = data();
$req1= 'SELECT * FROM utilisateur WHERE id="'.$_SESSION['utilisateur'].'"';
$resultat = mysqli_query($connexion, $req1);
$utilisateur=mysqli_fetch_assoc($resultat);
$message = '';

include("menu_gauche.php");

if(!empty($_POST['submit'])){
  if( !empty($_FILES['publication']['name']) ){
            $nomImage = 'image'.$_SESSION['utilisateur'].'-'.$utilisateur['nbpubli'].'.png';
            if(move_uploaded_file($_FILES['publication']['tmp_name'], 'publication/'.$nomImage))
            {
            $new_nbpubli = $utilisateur['nbpubli'] +1;
            $req2= 'UPDATE utilisateur SET nbpubli="'.$new_nbpubli.'" WHERE id="'.$_SESSION['utilisateur'].'"';
            mysqli_query($connexion, $req2);
            $req3= 'INSERT INTO publication (texte,utilisateur,numero) VALUES ("'.$_POST['texte'].'","'.$_SESSION['utilisateur'].'","'.$utilisateur['nbpubli'].'")';
            mysqli_query($connexion, $req3);
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
<form enctype="multipart/form-data" action="publier.php" method="post">
    <?php echo $message;?>
    <div class="importer">   
    <label id="importer" for="file">IMPORTER</label>
    <input type="file" name="publication" id="file"></div>
    <input type="text" name="texte" placeholder="Legende">
    <input type="submit" name="submit" value="PUBLIER">
</form>
<a id="changer_publi" href="publier_sto.php">Publier une story </a>
</div>

        
    </body>
</html>