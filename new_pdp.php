<?php

  session_start();

  include("menu_gauche.php");
  include("publi.php");
  
  $connexion = data();
  //On évite les injections SQL
  $user = mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
  $req= 'SELECT * FROM utilisateur WHERE id="'.$user.'"';
  $resultat = mysqli_query($connexion, $req);
  $utilisateur=mysqli_fetch_assoc($resultat);
  $message = '';

  //Si l'utilisateur appuie sur le bouton enregistrer
  if(!empty($_POST['submit'])){
      
    //Si on a récupérer un fichier
    if(!empty($_FILES['photo']['name'])){
      //Fixe le nom de l'image pour la base de données
      $nomImage = 'personne'.$user.'.png';
      $image_info = getimagesize($_FILES['photo']['tmp_name']);          
      
      //Si on a récupéré un image
      if($image_info !== false){
              
        //Si l'image est carré avec une petite marge d'erreur
        if(abs($image_info[0] - $image_info[1]) <= 10){
                
          //Vérifie que l'image est un png
          if($image_info['mime'] == 'image/png'){

            //Déplace l'image au bon endroit et vérifie que l'action s'effectue      
            if(move_uploaded_file($_FILES['photo']['tmp_name'], 'pdp/'.$nomImage)){   
              //Met à jour la photo de profil de l'utilisateur                 
              $req1= 'UPDATE utilisateur SET pdp="'.$user.'" WHERE id="'.$user.'"';                   
              $resultat1 = mysqli_query($connexion, $req1);                    
              $message = 'Nouvelle photo de profil enregistrée !';                  
            }
                  
            else{                    
              $message = 'Erreur lors de l\'enregistrement de l\'image sur le serveur';                  
            }                
          }
                
          else{                  
            $message = 'L\'image doit être au format PNG';                
          }              
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
        <?php menu_gauche(3);?> <!--Affichage du menu gauche -->
        <div class="publier_box">
          <img src="image/image.png">
          <p>Votre nouvelle photo de profil</p>
          <p>Au format png et le plus carré possible</p>
          <form enctype="multipart/form-data" action="new_pdp.php" method="post">   <!--Formulaire pour récupérer l'image -->
              <?php echo $message;?>
              <div class="importer">                                    
                <label id="importer" for="file">IMPORTER</label>
                <input type="file" name="photo" id="file">              <!--Bouton pour importer l'image -->
              </div>
              <input type="submit" name="submit" value="ENREGISTRER">   <!--Bouton pour enregistrer son choix -->
          </form>
        </div>
        <a id="changer_publi" href="mon_profil.php">Retour</a>          <!--Lien vers la page précédente -->
    </body>
</html>