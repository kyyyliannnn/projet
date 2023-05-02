<?php
session_start();
include("menu_gauche.php");
include("publi.php");

$id_profil = $_SESSION['id_profil'];
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
    $suivi = $_POST['suivre'];
    $connexion = data();
    $req = "SELECT * FROM suivi WHERE suiveur = '$id' AND suivi = '$suivi'";
    $resultat = mysqli_query($connexion, $req);   
    if(mysqli_num_rows($resultat) == 0) {
        $req1= "INSERT INTO suivi (suiveur, suivi) VALUES ('$id', '$suivi')";
        mysqli_query($connexion, $req1);
    }
    else{
        $msg = 'Vous suivez déjà cette personne';
    }
    mysqli_close($connexion);
}
if(isset($_POST['abonn'])){
    $_SESSION['id_profil'] = $_POST['abonn'];
    header('location:profil.php');
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
<div class="publi_box">
<?php

$connexion = data();

$req = "SELECT * FROM publication WHERE utilisateur = '$id_profil'";
$resultat = mysqli_query($connexion, $req);

if ($resultat) {
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        publi($ligne['id']);
    }
} else {
    // Gérer l'erreur
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($connexion);
}

mysqli_close($connexion);

?>
    </div>
    <div> <!-- CSS A FAIRE AHHHHHH -->
        <?php
            if ($id == $id_profil) {
                echo '<h2>Voici à quoi ressemble votre compte, modifiez le <a href="mon_profil.php">ici</a> !</h2>';
            }
            echo '<img src="pdp/personne'.$pdp.'.png">
            <h1>'.$pseudo.'</h1>
            <p>Je suis étudiant.e à '.$universite.'</p>';
            if($admin == 1){
                echo '<img src="image/bouclier.png" alt="est administrateur">';
            }
            if ($id != $id_profil) {
                echo '<form method="post" action="profil.php"><button type="submit" name="suivre" value="'.$id_profil.'">Suivre</button></form>';
            }
            echo $msg;
            echo '<form method="post" action=""><button type="submit" name="abonnes">Voir les abonnés</button></form>';
            if(isset($_POST['abonnes'])){
                $connexion = data();
                $req1= "SELECT * FROM suivi WHERE suivi = '$id_profil'";
                $resultat = mysqli_query($connexion, $req1);
                while($res=mysqli_fetch_assoc($resultat)){
                    $req2 = "SELECT * FROM utilisateur WHERE id = '".$res['suiveur']."'";
                    $resultat2 = mysqli_query($connexion, $req2);
                    $utilisateur = mysqli_fetch_assoc($resultat2);
                    
                    /*je les transforme en bouton
                    echo '<div class="entete"><a href="profil.php" class="pdp"><img src="pdp/personne'.$utilisateur['pdp'].'.png"></a>
                    <a href="profil.php" class="pseudo">'.$utilisateur['pseudo'].'</a></div>';*/

                    //problème avec le button image mais je pense que ça vient du fait qu'il manque un css
                    echo '<form method="post" action="profil.php"><button type="image"  name="abonn" value="'.$utilisateur['id'].'" src="pdp/personne'.$utilisateur['pdp'].'.png" ></button></form>
                          <form method="post" action="profil.php"><button type="submit" name="abonn" value="'.$utilisateur['id'].'">'.$utilisateur['pseudo'].' </button>           </form>';
                }
            }
            echo '<form method="post" action=""><button type="submit" name="abonnements">Voir les abonnements</button></form>';
            if(isset($_POST['abonnements'])){
                $connexion = data();
                $req1= "SELECT * FROM suivi WHERE suiveur = '$id_profil'";
                $resultat = mysqli_query($connexion, $req1);
                while($res=mysqli_fetch_assoc($resultat)){
                    $req2 = "SELECT * FROM utilisateur WHERE id = '".$res['suivi']."'";
                    $resultat2 = mysqli_query($connexion, $req2);
                    $utilisateur = mysqli_fetch_assoc($resultat2);
                    
                    /* je les transforme en bouton
                    echo '<div class="entete"><a href="profil.php" class="pdp"><img src="pdp/personne'.$utilisateur['pdp'].'.png"></a>
                    <a href="profil.php" class="pseudo">'.$utilisateur['pseudo'].'</a></div>'; */

                    //problème avec le button image mais je pense que ça vient du fait qu'il manque un css
                    echo '<form method="post" action="profil.php"><button type="image"  name="abonn" value="'.$utilisateur['id'].'" src="pdp/personne'.$utilisateur['pdp'].'.png" ></button></form>
                          <form method="post" action="profil.php"><button type="submit" name="abonn" value="'.$utilisateur['id'].'">'.$utilisateur['pseudo'].'                     </button></form>';
                }
            }
        ?>
    </div>
    </body>
</html>
