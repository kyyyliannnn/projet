<?php

session_start();

    include("menu.php");
    include("base_donnee.php");

    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
    $msg="";
    
    //Si l'utilisateur appuie sur envoyer
    if (isset($_POST['submit'])){

        //Vérifie si il a marqué son pseudo et son mot de passe
        if (empty($pseudo) || empty($mdp)){
            $msg="Veuillez remplir tous les champs";
        }

        else {
            $connexion = data();

            //Vérification de la connexion au serveur
            if (!$connexion) {
                echo 'Pas de connexion au serveur '; exit;
            }

            //Récupère l'utilisateur qui a le pseudo marqué dans le formulaire
            $req = 'SELECT * FROM `Utilisateur` WHERE pseudo="'.$pseudo.'"' ;
            $resultat = mysqli_query ($connexion, $req);

            //Vérification de la récupération de la ligne SQL
            if (!$resultat) {
                $msg="Erreur de connexion au serveur";
            }

            else {
               $ligne=mysqli_fetch_assoc($resultat);

               //Hache le mot de passe est vérifie que c'est le même que dans la base de données
               if (md5($mdp) === $ligne['mdp']){
                    //Connecte l'utilisateur
                    $_SESSION['utilisateur']=$ligne['id'];
                    header('location:accueil_publi.php');
               }

               //Ne correspond pas à la base de données
               else {
                $msg="Erreur dans le pseudo ou le mot de passe";
               }
            }

            mysqli_close($connexion);
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
    <body>
        <?php menu("S'inscrire","accueil2");?>  <!-- entête du site -->
        <div class="element_flex">
            <div class="element_flex1">
                <h1>Rejoins de nombreuses communautés étudiantes</h1>
                <form action="accueil.php" method="post">   <!-- Formulaire de connexion -->
                    <label for="pseudo">Pseudo</label>
                    <input type="text" name="pseudo">       <!-- Champ pour écrire le pseudo -->
                    <label for="mdp">Mot de passe</label>
                    <input type="password" name="mdp">      <!-- Champ pour écrire le mot de passe -->
                    <p><?php echo $msg; ?></p>
                    <input type="submit" class="button" name='submit' value="Envoyer">  <!-- Bouton de connexion -->
                </form>
            </div>
            <?php image(); ?>
        </div>
    </body>
</html>