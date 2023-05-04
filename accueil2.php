<?php

session_start(); 

    include("menu.php");
    include("base_donnee.php");

    $mail = $_POST['mail']; 
    $mdp = $_POST['mdp'];
    $msg="";
    
    //Si l'utilisateur appuie sur le bouton s'inscrire
    if (isset($_POST['submit'])){

        //Vérifie si il a écrit son mail et mot de passe
        if (empty($mail) || empty($mdp)){
            $msg="Veuillez remplir tous les champs";
        }

        else {
            $connexion = data();

            //Vérification de la connexion au serveur
            if (!$connexion) {
                echo 'Pas de connexion au serveur '; exit;
            }

            //On évite les injections SQL
            $mail = mysqli_real_escape_string($connexion,$mail);
            $mdp = mysqli_real_escape_string($connexion,$mdp);
            //Récupère l'utilisateur qui a le mail rentré
            $req = 'SELECT * FROM `Utilisateur` WHERE mail="'.$mail.'"' ; 
            $resultat = mysqli_query($connexion, $req);
            $ligne=mysqli_fetch_assoc($resultat);

            //Vérifie qu'aucun utilisateur a le mail ou que le mail est bien un mail
            if ($ligne || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $msg="Le mail est déjà utilisé ou mal écrit";
            }

            else {

                //Vérifie que le mot de passe fait au moins 6 charactères
               if (strlen($mdp)<6){
                $msg="Le mot de passe est trop court";
               }

               else {
                //Créer un nouvel utilisateur avec le mail donné et le mot de passe hashé
                $req2 = 'INSERT INTO Utilisateur (mail, mdp) VALUES ("'.$mail.'","'.md5($mdp).'")';
                $resultat = mysqli_query($connexion, $req2);
                //Récupère l'identifiant pour une connexion temporaire le temps de l'inscription
                $temp = mysqli_insert_id($connexion);
                $_SESSION['temp'] = $temp;
                //Envoie à la 2e page d'inscription
                header('Location:inscription.php');
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
        <?php menu("Se connecter","accueil");?>  <!--Entête du site -->
        <div class="element_flex">
            <div class="element_flex1">
                <h1>Rejoins de nombreuses communautés étudiantes</h1>
                <form action="accueil2.php" method="post">      <!--Formulaire d'inscription -->
                    <label for="mail">Mail</label>
                    <input type="text" name="mail">             <!--Champ pour écrire son mail -->
                    <label for="mdp">Mot de passe (6 caractères minimum)</label>
                    <input type="password" name="mdp">          <!--Champ pour écrire son mot de passe -->
                    <p><?php echo $msg; ?></p>
                    <input type="submit" name='submit' class="button" value="S'inscrire"> <!--Bouton pour s'inscrire -->
                </form>
            </div>
            <?php image(); ?>
        </div>
    </body>
</html>