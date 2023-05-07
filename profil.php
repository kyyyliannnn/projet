<?php
    session_start();

    include("menu_gauche.php");
    include("publi.php");
    include("profil_function.php");

    $connexion = data();
    $_GET['id'];
    $id = $_SESSION['utilisateur'];
    $id_profil = $_GET['id'];
    //On évite les injections SQL à travers l'URL et les cookies
    $id_profil = mysqli_real_escape_string($connexion,$id_profil);
    $id = mysqli_real_escape_string($connexion,$id);
    $msg = '';

    //Récupère l'utilisateur correspondant à l'id dans l'url, càd celui sur lequel on a cliqué
    $req = "SELECT * FROM utilisateur WHERE id = '$id_profil'";
    $resultat = mysqli_query($connexion, $req);

    //On vérifie qu'on a un résultat
    if ($resultat) {

        //On récupère les infos de l'utilisateur dans l'url
        while ($ligne = mysqli_fetch_assoc($resultat)) {
            $pseudo = $ligne['pseudo'];
            $universite = $ligne['universite'];
            $pdp = $ligne['pdp'];
            $admin = $ligne['administrateur'];
        }
    }

    else {
        echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
    }
    mysqli_close($connexion);

    //Si le bouton suivre est cliqué
    if(isset($_POST['suivre'])) {
        $connexion = data();
        //On récupère la ligne nous indiquant si l'utilisateur suit celui de l'url
        $req = "SELECT * FROM suivi WHERE suiveur = '$id' AND suivi = '$id_profil'";
        $resultat = mysqli_query($connexion, $req);  
            
        //S'il ne le suit pas
        if(mysqli_num_rows($resultat) == 0) {
            //On ajoute le fait qu'il le suit
            $req1= "INSERT INTO suivi (suiveur, suivi) VALUES ('$id', '$id_profil')";
            $resultat1 = mysqli_query($connexion, $req1);
        }

        else{
            $msg = 'Vous suivez déjà cette personne';
        }
        mysqli_close($connexion);
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
        <?php menu_gauche(1);?>
        <div id="profil_publi">
            <div id="profil_box"> 
                <?php

                    //Vérifie si l'utilisateur de l'url est celui qui la consulte et propose alors d'aller à son profil
                    if ($id == $id_profil) {
                        echo 
                            '<h2 id="profil_perso">Voici à quoi ressemble votre compte, modifiez le <a class="orange" href="mon_profil.php">ici</a> !</h2>';
                    }
                    
                    //Affiche le pseudo et la photo de profil
                    echo 
                            '<div class="entete">
                                <a class="pdp" id="profil_pdp"><img src="pdp/personne'.$pdp.'.png"></a>
                                <div id="entete2">
                                    <a class="pseudo" id="profil_pseudo">'.$pseudo.'</a>';

                    //Vérifie si l'utilisateur et affiche le logo correspondant si c'est le cas
                    if($admin == 1){
                        echo 
                                    '<img id="image_admin" src="image/bouclier.png" title="Utilisateur Administrateur" alt="est administrateur">';
                    }

                    //Affiche le nombre d'abonnés et l'université
                    echo 
                                    '<p id="nbfollower">'.nbfollower($id_profil).' abonnés </p> 
                                </div>
                            </div>
                            <p id="etudiant">Je suis étudiant.e à '.$universite.'</p>
                            <div id="button_profil_box">
                                <div class="colonne">';

                    //Bouton pour suivre l'utilisateur si ce n'est pas lui-même
                    if ($id != $id_profil) {
                        echo 
                                    '<form method="post" class="button_profil" action="profil.php?id='.$id_profil.'">
                                        <input class="button" type="submit" name="suivre" value="Suivre">
                                    </form>';
                    }

                    echo $msg;
                    echo 
                                '</div>';
                    //Créer le bouton pour la liste d'abonnés
                    abonnes($id_profil); 
                    //Créer le bouton pour la liste d'abonnements
                    abonnement($id_profil);

                    echo 
                            '</div>';
                ?>
            </div>
            <div class="publi_box">
                <?php

                    $connexion = data();
                    //Récupère les publications de l'utilisateur en les triant
                    $req = "SELECT * FROM publication WHERE utilisateur = '$id_profil' ORDER BY id DESC";
                    $resultat = mysqli_query($connexion, $req);

                    //Vérifie qu'on a un résultat
                    if ($resultat) {

                        //Si il y a au moins une publication
                        if(mysqli_num_rows($resultat) > 0) {

                            //Affiche toutes les publications de l'utilisateur
                            while ($ligne = mysqli_fetch_assoc($resultat)) {
                                publi($ligne['id'],0);
                            }
                        }

                        else{
                            echo '<h2> Oups... On dirait que cet utilisateur n\'a encore rien posté</h2>';
                        }

                    } else {
                        echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
                    }
                    
                    mysqli_close($connexion);

                ?>
            </div>
        </div>
    </body>
</html>