<?php
  session_start();

  include("publi.php");
  include("menu_gauche.php");

  $connexion = data();
  //On évite les injections SQL
  $user = mysqli_real_escape_string($connexion,$_SESSION['utilisateur']); 
  //Récupère les informations de l'utilisateur connecté
  $req1= 'SELECT * FROM utilisateur WHERE id="'.$user.'"';
  $resultat1 = mysqli_query($connexion, $req1);
  $utilisateur=mysqli_fetch_assoc($resultat1);
  $message = '';

  //Si le bouton publier est cliqué
  if(!empty($_POST['submit'])){

    //Vérifie si un fichier a été importé
    if( !empty($_FILES['publication']['name']) ){
      //Récupère les infos de l'image
      $image_info = getimagesize($_FILES['publication']['tmp_name']);

      //Si on a récupéré un image
      if($image_info !== false){
      
        //Vérifie que l'image est un png
        if($image_info['mime'] == 'image/png'){
          //Donne un nouveau nom à l'image pour qu'elle bien dans la base de données
          $nomImage = 'image'.$user.'-'.$utilisateur['nbpubli'].'.png';

          //Déplace l'image au bon endroit tout en vérifiant que ça se passe bien
          if(move_uploaded_file($_FILES['publication']['tmp_name'], 'publication/'.$nomImage)){
            $new_nbpubli = $utilisateur['nbpubli'] +1;
            //Incrémente de 1 le nombre de publications de l'utilisateur
            $req2= 'UPDATE utilisateur SET nbpubli="'.$new_nbpubli.'" WHERE id="'.$user.'"';
            mysqli_query($connexion, $req2);
            //Ajoute la publication à la base de données
            $req3= 'INSERT INTO publication (texte,utilisateur,numero) VALUES ("'.$_POST['texte'].'","'.$user.'","'.$utilisateur['nbpubli'].'")';
            mysqli_query($connexion, $req3);
            //Retour au profil de l'utilisateur pour qu'il voit qu'elle a été postée
            header('location:mon_profil.php');       
          }  

          else{
            $message = 'Une erreur interne a empêché l\'upload de l\'image';     
          }
        }
        else{
          $message = "L'image doit être au format png";
        }
      }
      
      else{
        $message = "Erreur lors de l'enregistrement de l'image";
      }
    }
    
    else{
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
      <?php menu_gauche(2);?> <!--Affiche le menu gauche-->
      <div class="publier_box">
      <img src="image/image.png">
      <p>Importer une photo</p>
      <form enctype="multipart/form-data" action="publier.php" method="post">   <!--Formulaire pour importer l'image -->
          <?php echo $message;?>
          <div class="importer">   
          <label id="importer" for="file">IMPORTER</label>
          <input type="file" name="publication" id="file"></div>                <!--Dépot de l'image -->
          <input type="text" name="texte" placeholder="Legende">                <!--Champ pour écrire la légende -->
          <input type="submit" name="submit" value="PUBLIER">                   <!--Bouton pour publier -->
      </form>
      <a id="changer_publi" href="publier_sto.php">Publier une story </a>
      </div>  
    </body>
</html>