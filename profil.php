<?php
session_start();
include("menu_gauche.php");
include("publi.php");
include("profil_function.php");

$id_profil = $_GET['id'];
$connexion = data();
$id = $_SESSION['utilisateur'];
$msg = '';

$req = "SELECT * FROM utilisateur WHERE id = '$id_profil'";
$resultat = mysqli_query($connexion, $req);

if ($resultat) {
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

if(isset($_POST['suivre'])) {
    $connexion = data();
    $req = "SELECT * FROM suivi WHERE suiveur = '$id' AND suivi = '$id_profil'";
    $resultat = mysqli_query($connexion, $req);   
    if(mysqli_num_rows($resultat) == 0) {
        $req1= "INSERT INTO suivi (suiveur, suivi) VALUES ('$id', '$id_profil')";
        mysqli_query($connexion, $req1);
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
        <?php menu_gauche(1);?>
    <div id="profil_publi">
    <div id="profil_box"> <!-- CSS A FAIRE AHHHHHH -->
        <?php
            if ($id == $id_profil) {
                echo '<h2>Voici à quoi ressemble votre compte, modifiez le <a href="mon_profil.php">ici</a> !</h2>';
            }
            echo '<div class="entete"><a class="pdp" id="profil_pdp"><img src="pdp/personne'.$pdp.'.png"></a>
             <div id="entete2"><a class="pseudo" id="profil_pseudo">'.$pseudo.'</a>';
             if($admin == 1){
                echo '<img id="image_admin" src="image/bouclier.png" title="Utilisateur Administrateur" alt="est administrateur">';
            }
            echo ' <p>Je suis étudiant.e à '.$universite.'</p> </div></div>
            <div id="button_profil_box">
            <div class="colonne">';

            if ($id != $id_profil) {
                echo '<form method="post" class="button_profil" action="profil.php?id='.$id_profil.'"><input class="button" type="submit" name="suivre" value="Suivre"></form>';
            }
            echo $msg;
            echo '</div>';
            abonnes($id_profil);
            abonnement($id_profil);
        ?>
    </div>
    </div>

    <div class="publi_box">
<?php

$connexion = data();

$req = "SELECT * FROM publication WHERE utilisateur = '$id_profil'";
$resultat = mysqli_query($connexion, $req);

if ($resultat) {
    if(mysqli_num_rows($resultat) > 0) {
        while ($ligne = mysqli_fetch_assoc($resultat)) {
            publi($ligne['id']);
        }
    }
    else{
        echo '<h2> Oups... On dirait que cet utilisateur n\'a encore rien posté</h2>';
    }
} else {
    // Gérer l'erreur
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
}

mysqli_close($connexion);

?>
    </div>
    </div>
    </body>
</html>