<?php
session_start();

include("publi.php");
include("menu_gauche.php");

$connexion = data();
$req = 'SELECT * FROM suivi WHERE suiveur = "'.$_SESSION['utilisateur'].'"';
$resultat1 = mysqli_query($connexion, $req);
$id = $_SESSION['utilisateur'];
$msg = '';


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

if(isset($_POST['profil'])){
    $_SESSION['id_profil'] = $_POST['profil'];
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

    </head>
    <body class="display">
        <?php menu_gauche(1);?>
        <div id="rechercher">
<form id="recherche_form" action="recherche.php" method="post">
    <img src="image/recherche_o.png">
    <input type="text" name="recherche" placeholder="rechercher un compte ou un groupe...">
</form>
<div id="resultat">
<?php if(!empty($_POST['recherche'])){
    $connexion = data();
    $req1= 'SELECT * FROM utilisateur WHERE pseudo LIKE "%'.$_POST['recherche'].'%"';
    $resultat = mysqli_query($connexion, $req1);
    while($res=mysqli_fetch_assoc($resultat)){
        
        /* désolé c'était tout beau maintenant c'est moche mais maintenant ça marche
        echo '<div class="entete"><a href="profil.php" class="pdp"><img src="pdp/personne'.$res['pdp'].'.png"></a>
        <a href="profil.php" class="pseudo">'.$res['pseudo'].'</a></div>';
        $_SESSION['id_profil'] = $res['id'];*/

        echo '<form method="post" action=""><button type="image"  name="profil" value="'.$res['id'].'" src="pdp/personne'.$res['pdp'].'.png" ></button></form>
              <form method="post" action=""><button type="submit" name="profil" value="'.$res['id'].'">'.$res['pseudo'].'                     </button></form>';
    }
    } ?>
    <p> <?php echo $msg; ?> </p>
</div>
</div>

        
    </body>
</html>