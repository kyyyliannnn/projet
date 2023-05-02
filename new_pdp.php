<?php
session_start();

include("menu_gauche.php");
include("publi.php");

$connexion = data();
$req1= 'SELECT * FROM utilisateur WHERE id="'.$_SESSION['utilisateur'].'"';
$resultat = mysqli_query($connexion, $req1);
$utilisateur=mysqli_fetch_assoc($resultat);
$message = '';

if(!empty($_POST['submit'])){
    if(!empty($_FILES['photo']['name'])){
        $nomImage = 'personne'.$_SESSION['utilisateur'].'.png';
        $image_info = getimagesize($_FILES['photo']['tmp_name']);
        if($image_info !== false){
            if(abs($image_info[0] - $image_info[1]) <= 10){
              if($image_info['mime'] == 'image/png'){
                if(move_uploaded_file($_FILES['photo']['tmp_name'], 'pdp/'.$nomImage)){
                  $req2= 'UPDATE utilisateur SET pdp="'.$_SESSION['utilisateur'].'" WHERE id="'.$_SESSION['utilisateur'].'"';
                  mysqli_query($connexion, $req2);
                  $message = 'Nouvelle photo de profil enregistrée !';
                }
                else{
                  $message = 'Erreur lors de l\'enregistrement de l\'image sur le serveur';
                }
              }
              else{
                $messaeg = 'L\'image doit être au format PNG';
              }
        
            else{
              $message = ' L\'image n\'est pas assez carré';
            }
        }
        else{
          $message = 'Erreur lors de l\'enregistrement de l\'image sur le serveur';
        }
      }
      else{
        $message = 'Veuillez mettre une image';
      }
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
        <?php menu_gauche(3);?>
        <div class="publier_box">
<img src="image/image.png">
<p>Votre nouvelle photo de profil</p>
<p>Au format png et le plus carré possible</p>
<form enctype="multipart/form-data" action="new_pdp.php" method="post">
    <?php echo $message;?>
    <div class="importer">   
    <label id="importer" for="file">IMPORTER</label>
    <input type="file" name="photo" id="file"></div>
    <input type="submit" name="submit" value="ENREGISTRER">
</form>
</div>
<a id="changer_publi" href="mon_profil.php">Retour</a>



        
    </body>
</html>