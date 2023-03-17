<?php
    include("menu.php");

    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
    $msg="";
    
    if (isset($_POST['submit'])){
        if (empty($pseudo) || empty($mdp)){
            $msg="Erreur dans le pseudo ou le mot de passe";
        }
        else {
            $connexion = mysqli_connect ('localhost',
            'root', 'root', 'projet' ) ;
            if (!$connexion) {
                echo 'Pas de connexion au serveur '; exit;
            }
            mysqli_set_charset($connexion, 'utf8');
        
            $req = 'SELECT * FROM `Utilisateur` WHERE pseudo="'.$pseudo.'"' ; 
            $resultat = mysqli_query ($connexion, $req);
            if (!$resultat) {
                $msg="Erreur dans le pseudo ou le mot de passe";
            }
            else {
               $ligne=mysqli_fetch_assoc($resultat);
               if ($mdp != $ligne['mdp']){
                    $msg="Erreur dans le pseudo ou le mot de passe";
               }
               else {
                echo "connecté";
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
    <?php menu("S'inscrire","accueil2");?>
    <div class="element_flex">
        <div class="element_flex1">
            <h1>Rejoins de nombreuses communautés étudiantes</h1>
            <form action="accueil.php" method="post">
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo">
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp">
                <p><?php echo $msg; ?></p>
                <a href="">Mot de passe oublié ?</a>
                <input type="submit" class="button" name='submit' value="Envoyer">
            </form>
        </div>
        <?php image(); ?>
    </div>
    </body>
</html>