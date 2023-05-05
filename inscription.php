<?php

session_start(); 

    include("menu.php");
    include("base_donnee.php");

    $pseudo = $_POST['pseudo']; 
    $universite = $_POST['universite'];
    $temp = $_SESSION['temp'];
    $msg="";

    // Si l'utilisateur appuie sur le bouton s'inscrire
    if (isset($_POST['submit'])){

        //Vérifie que l'utilisateur a rempli la première partie du formulaire
        if (empty($temp)){
            $msg="Vous n'avez pas rempli le début du formulaire";
        }

        else{

            // Vérifie si les champs pseudo et université ne sont remplis
            if (empty($pseudo) || empty($universite)){
                $msg="Veuillez remplir tous les champs";
            }
            
            else {
                $connexion = data();
                
                // Vérifie la cconnexion
                if (!$connexion) {
                    echo 'Pas de connexion au serveur '; 
                    exit;
                }
                
                // On évite les injections SQL
                $pseudo = mysqli_real_escape_string($connexion,$pseudo);
                // On récupère l'utilisateur qui le pseudo rentré
                $req = 'SELECT * FROM `Utilisateur` WHERE pseudo="'.$pseudo.'"' ; 
                $resultat = mysqli_query($connexion, $req);
                $ligne=mysqli_fetch_assoc($resultat);
                
                // Si cet utilisateur existe
                if ($ligne) {
                    $msg="Le pseudo est déjà utilisé";
                }

                else {
                    // On met à jour le nouvel utilisateur en ajoutant son pseudo et son choix d'université
                    $req1 = "UPDATE Utilisateur SET pseudo='$pseudo', universite='$universite' WHERE id=$temp";
                    $resultat1 = mysqli_query($connexion, $req1);
                    // On récupère tous les utilisateurs de l'université choisie
                    $req2 = "SELECT id FROM utilisateur WHERE universite = '$universite'";
                    $resultat2 = mysqli_query($connexion, $req2);

                    //Fait se suivre mutuellement l'utilisateur avec toutes les personnes de son université
                    while ($res = mysqli_fetch_assoc($resultat2)) {

                        //L'empêche de se suivre lui-même
                        if ($temp != $res['id']) {
                            $req3 = 'INSERT INTO suivi (suiveur, suivi) VALUES ("'.$temp.'", "'.$res['id'].'")';
                            mysqli_query($connexion, $req3);
                            $req4 = 'INSERT INTO suivi (suiveur, suivi) VALUES ("'.$res['id'].'", "'.$temp.'")';
                            mysqli_query($connexion, $req4);
                        }
                    }

                    //Renvoie à la page de connexion
                    header('location:accueil.php');
                }
                
                mysqli_close($connexion);
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
    <body>
        <?php menu("Se connecter","accueil");?> <!--Entête du site -->
        <div class="element_flex2" id="inscription_box">
            <div class="element_flex1" id="inscription_ombre">
                <h1>Finalise ton inscription</h1>
                <form action="inscription.php" method="post">   <!--Formulaire d'inscription -->
                    <label for="pseudo">Pseudo</label>
                    <input type="text" name="pseudo">           <!--Champ pour le mail -->
                    <label for="universite">Université</label>  
                    <select name="universite" id="universite">  <!--Volet déroulant pour choisir son université -->
                        <?php

                        $connexion = data();

                        //Vérifie la connexion
                        if (!$connexion) {
                            echo 'Pas de connexion au serveur '; 
                            exit;
                        }

                        else{
                            //Récupère les noms d'université de la base de données
                            $req = "SELECT nom FROM universite";
                            $resultat = mysqli_query($connexion, $req);
                            $noms = array();

                            //Récupère tous les noms
                            while ($ligne = mysqli_fetch_assoc($resultat)) {
                                $noms[] = $ligne['nom'];
                            }

                            //Affiche chaque nom dans le volet
                            foreach($noms as $nom) {
                                echo '<option value="'.$nom.'">'.$nom.'</option>';
                            }
                        }

                        ?>
                    </select>
                    <p><?php echo $msg; ?></p>
                    <input type="submit" name='submit' class="button" value="S'inscrire"> <!--Bouton d'inscription -->
                </form>
            </div>
        </div>
    </body>
</html>
