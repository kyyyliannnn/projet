<?php 
function abonnement($id_profil){
    echo '<div class="colonne">
    <form class="button_profil" method="post" action="">
    <input class="button" type="submit" name="abonnements" value="Voir les abonnements"></form>';
    if(isset($_POST['abonnements'])){
        $connexion = data();
        $req1= "SELECT * FROM suivi WHERE suiveur = '$id_profil'";
        $resultat = mysqli_query($connexion, $req1);
        while($res=mysqli_fetch_assoc($resultat)){
            $req2 = "SELECT * FROM utilisateur WHERE id = '".$res['suivi']."'";
            $resultat2 = mysqli_query($connexion, $req2);
            $utilisateur = mysqli_fetch_assoc($resultat2);
            echo '<div class="entete">';
            echo profil($utilisateur);
            echo '</div>'; }
    }
    echo '</div>';
}

function abonnes($id_profil){
    echo ' <div class="colonne"> <form class="button_profil"  method="post" action="">
    <input class="button" type="submit" name="abonnes" value="Voir les abonnés"></form>';
    if(isset($_POST['abonnes'])){
    $connexion = data();
    $req1= "SELECT * FROM suivi WHERE suivi ='$id_profil'";
    $resultat = mysqli_query($connexion, $req1);
    while($res=mysqli_fetch_assoc($resultat)){
        $req2 = "SELECT * FROM utilisateur WHERE id = '".$res['suiveur']."'";
        $resultat2 = mysqli_query($connexion, $req2);
        $utilisateur = mysqli_fetch_assoc($resultat2);
        echo '<div class="entete">';
        echo profil($utilisateur);
        echo '</div>';
    }
}
    echo '</div>';
}




?>