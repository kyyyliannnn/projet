<?php

    include("menu_gauche.php");
    include("publi.php");
    include("profil_function.php");

    $connexion = data();
    //On évite les injections SQL
    $user = mysqli_real_escape_string($connexion,$_SESSION['utilisateur']);
    $req= 'SELECT * FROM utilisateur WHERE id="'.$user.'"';
    $resultat = mysqli_query($connexion, $req);
    $utilisateur=mysqli_fetch_assoc($resultat);
    $msg = '';
    $pseudo = $utilisateur['pseudo'];
    $id = $utilisateur['id'];
    $pdp = $utilisateur['pdp'];
    $admin = $utilisateur['administrateur'];
    $universite = $utilisateur['universite'];

    //Si on appuie sur le bouton enregistrer
    if (isset($_POST['submit'])){
            $new_pseudo = $_POST['new_pseudo'];

            //Vérifie si le champ est rempli
            if (empty($new_pseudo)){
                $msg="Veuillez remplir le champ";
            }

            else {
                //Evite les injections SQL
                $new_pseudo = mysqli_real_escape_string($connexion,$new_pseudo);
                //Récupère l'utilisateur avec le nouveau pseudo
                $req1 = 'SELECT * FROM `Utilisateur` WHERE pseudo="'.$new_pseudo.'"' ; 
                $resultat1 = mysqli_query($connexion, $req1);
                $ligne=mysqli_fetch_assoc($resultat1);

                //Vérifie que personne n'utilise déjà le nouveau pseudo
                if ($ligne) {
                    $msg="Le pseudo est déjà utilisé";
                }

                else {
                    //Met à jour le pseudo
                    $req2 = "UPDATE Utilisateur SET pseudo='$new_pseudo' WHERE id=$id";
                    $resultat2 = mysqli_query($connexion, $req2);
                    $pseudo = $new_pseudo;
                }
            }
        }

    mysqli_close($connexion);

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
        <?php menu_gauche(3);?>     <!--Affiche le menu de gauche -->
        <div id="profil_publi">
            <div id="profil_box">
                <div class="entete">
                    <?php echo '<a class="pdp" id="profil_pdp"><img src="pdp/personne'.$pdp.'.png"></a>';?> <!--Affiche la photo de profil -->
                    <div id="entete2">
                        <?php echo '<a class="pseudo" id="profil_pseudo">'.$pseudo.'</a>';      //Affiche le pseudo

                        //Vérifie si l'utilisateur est admin
                        if($admin == 1){
                            //Affiche le logo d'admin
                            echo '<img id="image_admin" src="image/bouclier.png" title="Utilisateur Administrateur" alt="est administrateur">';
                        }
                        echo '<p id="nbfollower">'.nbfollower($id).' abonnés </p>'; ?> <!--Affiche le nombre d'abonné -->
                    </div>
                </div>
                <?php echo '<p id="etudiant">Je suis étudiant.e à '.$universite.'</p> '; ?> <!--Affiche l'université -->
                <div id="button_profil_box">
                <?php 
                    abonnes($id);       //Bouton pour voir les abonnés
                    abonnement($id);    //Bouton pour voir les abonnements
                ?>
                </div>
                <a id="changer_publi" href="new_pdp.php">Changer ma photo de profil</a>     <!--Lien pour changer de photo de profil -->
                <form id="changer_pseudo" action="mon_profil.php" method="post">            <!--Formulaire pour changer de Pseudo -->
                    <label for="new_pseudo">Changer mon pseudo :</label> 
                    <input type="text" name="new_pseudo">                                   <!--Champ pour rentrer son nouveau pseudo -->
                    <input type="submit" name='submit' class="button" value="Enregistrer">  <!--Bouton pour enregistrer le nouveau -->
                </form>
            </div>
            <?php 

                echo $msg;
                $connexion = data();
                //Récupère nos publications en les rangeant
                $req = "SELECT * FROM publication WHERE utilisateur = '$id' ORDER BY id DESC";
                $resultat = mysqli_query($connexion, $req);

                //Vérifie qu'on a récupéré un résultat
                if ($resultat) {

                    //Vérifie qu'il y a au moins une publication
                    if(mysqli_num_rows($resultat) > 0) {

                        //Affiche les publications de l'utilisateur
                        while ($ligne = mysqli_fetch_assoc($resultat)) {
                            publi($ligne['id'],1);
                        }
                    }

                    //N'a pas de publication et propose alors de renvoyer à la page pour en poster
                    else{
                        echo '<h2> Oups... Vous n\'avez encore rien posté</h2>
                        <a id="changer_publi" href=publier.php>Postez votre première publication !<a>';
                    }
                } 
                
                else {
                    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
                }

                mysqli_close($connexion);

            ?>

    </div>
    </body>
</html>