<?php
session_start(); 
    include("menu.php");

    $mail = $_POST['mail']; 
    $mdp = $_POST['mdp'];
    $msg="";
    
    if (isset($_POST['submit'])){
        if (empty($mail) || empty($mdp)){
            $msg="Veuillez remplir tous les champs";
        }
        else {
            $connexion = mysqli_connect ('localhost',
            'root', 'root', 'projet' ) ;
            if (!$connexion) {
                echo 'Pas de connexion au serveur '; exit;
            }
            mysqli_set_charset($connexion, 'utf8'); 
            $mail = mysqli_real_escape_string($connexion,$mail);
            $mdp = mysqli_real_escape_string($connexion,$mdp);
            $req = 'SELECT * FROM `Utilisateur` WHERE mail="'.$mail.'"' ; 
            $resultat = mysqli_query($connexion, $req);
            $ligne=mysqli_fetch_assoc($resultat);
            if ($ligne || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $msg="Le mail est déjà utilisé ou mal écrit";
            }
            else {
               if (strlen($mdp)<6){
                $msg="Le mot de passe est trop court";
               }
               else {
                $req2 = 'INSERT INTO Utilisateur (mail, mdp) VALUES ("'.$mail.'","'.md5($mdp).'")';
                $resultat = mysqli_query($connexion, $req2);
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
    <?php menu("Se connecter","accueil");?>
    <div class="element_flex">
        <div class="element_flex1">
            <h1>Rejoins de nombreuses communautés étudiantes</h1>
            <form action="accueil2.php" method="post">
                <label for="mail">Mail</label>
                <input type="text" name="mail">
                <label for="mdp">Mot de passe (6 caractères minimum)</label>
                <input type="password" name="mdp">
                <p><?php echo $msg; ?></p>
                <input type="submit" name='submit' class="button" value="S'inscrire">
            </form>
        </div>
        <?php image(); ?>
    </div>
    </body>
</html>