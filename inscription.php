<?php

// On démarre une session
session_start(); 

// On inclut le menu
include("menu.php");

// On récupère les données du formulaire de connexion
$pseudo = $_POST['pseudo']; 
$universite = $_POST['universite'];

$temp = $_SESSION['temp'];

// On initialise la variable de message d'erreur
$msg="";

// Si le formulaire est soumis
if (isset($_POST['submit'])){

    if (empty($temp)){
        $msg="Vous n'avez pas rempli le début du formulaire";
    }
    else{
        // Si les champs pseudo et université ne sont pas remplis
        if (empty($pseudo) || empty($universite)){
            $msg="Veuillez remplir tous les champs";
        }
        else {
            // On se connecte à la base de données
            $connexion = mysqli_connect ('localhost', 'root', '', 'projet' ) ;
            
            // Si la connexion échoue
            if (!$connexion) {
                echo 'Pas de connexion au serveur '; 
                exit;
            }
            
            // On définit l'encodage des caractères
            mysqli_set_charset($connexion, 'utf8'); 
            
            // On échappe les caractères spéciaux pour éviter les injections SQL
            $pseudo = mysqli_real_escape_string($connexion,$pseudo);
            $universite = mysqli_real_escape_string($connexion,$universite);
            
            // On vérifie si le pseudo existe déjà dans la base de données
            $req = 'SELECT * FROM `Utilisateur` WHERE pseudo="'.$pseudo.'"' ; 
            $resultat = mysqli_query($connexion, $req);
            $ligne=mysqli_fetch_assoc($resultat);
            
            // Si le pseudo est déjà utilisé
            if ($ligne) {
                $msg="Le pseudo est déjà utilisé";
            }
            else {
                // On ajoute l'utilisateur à la base de données
                $req2 = "UPDATE Utilisateur SET pseudo='$pseudo', universite='$universite' WHERE id=$temp";
                $resultat = mysqli_query($connexion, $req2);

                // On lui fait suivre toutes les personnes de son université
                $req3 = "SELECT id FROM utilisateur WHERE universite = '$universite'";
                $collegues = mysqli_query($connexion, $req3);
                while ($collegue = mysqli_fetch_assoc($collegues)) {
                    if ($temp != $collegue['id']) {
                        $req10 = 'INSERT INTO suivi (suiveur, suivi) VALUES ("'.$temp.'", "'.$collegue['id'].'")';
                        mysqli_query($connexion, $req10);
                        $req11 = 'INSERT INTO suivi (suiveur, suivi) VALUES ("'.$collegue['id'].'", "'.$temp.'")';
                        mysqli_query($connexion, $req11);
                    
                    }
                }
                

                header('location:accueil.php');
            }
            
            // On ferme la connexion à la base de données
            mysqli_close($connexion);
        }
    }      
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>CampusParis</title> <!-- Titre de la page -->
        <link rel="stylesheet" href="projet.css"> <!-- Import du fichier CSS -->
        <meta charset="UTF-8"> <!-- Encodage de la page -->
        <meta name="author" content="Kylian, Eva"> <!-- Auteurs de la page -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Paramètres d'affichage de la page -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans" rel="stylesheet"> <!-- Import de la police Open Sans -->
    </head>
    <body>
    <?php menu("Se connecter","accueil");?> <!-- Import du menu avec 2 paramètres -->
    <div class="element_flex2">
        <div class="element_flex1">
            <h1>Finalise ton inscription</h1> <!-- Titre principal de la page -->
            <form action="inscription.php" method="post"> <!-- Formulaire de connexion avec la méthode POST et l'action "accueil.php" -->
                <label for="pseudo">Pseudo</label> <!-- Label pour le champ mail -->
                <input type="text" name="pseudo"> <!-- Champ de saisie pour le mail -->
                <label for="universite">Université</label> <!-- Label pour le champ mot de passe -->
                <select name="universite" id="universite">
                    <?php
                    $connexion = mysqli_connect ('localhost','root', '', 'projet' ) ;
                    if (!$connexion) {
                        die('Connexion à la base de données impossible : ' . mysqli_connect_error());
                    }
                    $req = "SELECT nom FROM universite";
                    $resultat = mysqli_query($connexion, $req);
                    $options = array();
                    while ($ligne = mysqli_fetch_assoc($resultat)) {
                        $options[] = $ligne['nom'];
                    }
                    foreach($options as $option) {
                        echo '<option value="'.$option.'">'.$option.'</option>';
                    }
                    ?>
                </select>
                <p><?php echo $msg; ?></p> <!-- Affichage du message d'erreur ou de confirmation d'inscription -->
                <input type="submit" name='submit' class="button" value="S'inscrire"> <!-- Bouton de soumission du formulaire -->
            </form>
        </div>
    </div>
    </body>
</html>
