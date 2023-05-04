<?php

include("menu_gauche.php");
include("publi.php");
include("profil_function.php");

$connexion = data();
$req1= 'SELECT * FROM utilisateur WHERE id="'.$_SESSION['utilisateur'].'"';
$resultat = mysqli_query($connexion, $req1);
$utilisateur=mysqli_fetch_assoc($resultat);
$msg = '';
$pseudo = $utilisateur['pseudo'];
$id = $utilisateur['id'];
$pdp = $utilisateur['pdp'];
$admin = $utilisateur['administrateur'];
$universite = $utilisateur['universite'];



if (isset($_POST['submit'])){
        $new_pseudo = $_POST['new_pseudo'];
        if (empty($new_pseudo)){
            $msg="Veuillez remplir le champ";
        }
        else {
            $new_pseudo = mysqli_real_escape_string($connexion,$new_pseudo);
            $req = 'SELECT * FROM `Utilisateur` WHERE pseudo="'.$new_pseudo.'"' ; 
            $resultat = mysqli_query($connexion, $req);
            $ligne=mysqli_fetch_assoc($resultat);
            if ($ligne) {
                $msg="Le pseudo est déjà utilisé";
            }
            else {
                $req2 = "UPDATE Utilisateur SET pseudo='$new_pseudo' WHERE id=$id";
                $resultat = mysqli_query($connexion, $req2);
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
        <script>
            function affiche(publi){
                var c = document.getElementById('com_box' + publi);
                c.style.display = "inline";
                var d = document.getElementById('commentaire'+publi);
                d.style.display = "none";
            }

            function cache(publi){
                var c = document.getElementById('com_box'+publi);
                c.style.display = "none";
                var d = document.getElementById('commentaire'+publi);
                d.style.display = "inline";
            }


            function afficheMenuadmin(publi){
                var c = document.getElementById('admin'+publi);
                if(c.style.display=="none"){
                    c.style.display = "inline";
                }
                else{
                    c.style.display = "none";
                }
            }
        </script>
    </head>
    <body class="display">
        <?php 
            echo menu_gauche(3);

             echo '<div id="profil_publi">
             <div id="profil_box">
            <div class="entete">
                <a class="pdp" id="profil_pdp"><img src="pdp/personne'.$pdp.'.png"></a>
                <div id="entete2">
                    <a class="pseudo" id="profil_pseudo">'.$pseudo.'</a>';
             if($admin == 1){
                echo '<img id="image_admin" src="image/bouclier.png" title="Utilisateur Administrateur" alt="est administrateur">';
            }
            echo '<p id="nbfollower">'.nbfollower($id).' abonnés </p></div></div>

             <p id="etudiant">Je suis étudiant.e à '.$universite.'</p> '; ?>
            
            <div id="button_profil_box">
            <?php 
            abonnes($id);
            abonnement($id);
            ?>
            </div>

            <a id="changer_publi" href="new_pdp.php">Changer ma photo de profil</a>
            <form id="changer_pseudo" action="mon_profil.php" method="post"> 
                <label for="new_pseudo">Changer mon pseudo :</label> 
                <input type="text" name="new_pseudo">
                <input type="submit" name='submit' class="button" value="Enregistrer">
            </form>
        </div>
            <?php echo $msg;

$connexion = data();

$req = "SELECT * FROM publication WHERE utilisateur = '$id' ORDER BY id DESC";
$resultat = mysqli_query($connexion, $req);

if ($resultat) {
    if(mysqli_num_rows($resultat) > 0) {
        while ($ligne = mysqli_fetch_assoc($resultat)) {
            publi2($ligne['id']);
        }
    }
    else{
        echo '<h2> Oups... Vous n\'avez encore rien posté</h2>
        <a id="changer_publi" href=publier.php>Postez votre première publication !<a>';
    }
} else {
    // Gérer l'erreur
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
}

mysqli_close($connexion);

?>


    </div>
    </body>
</html>