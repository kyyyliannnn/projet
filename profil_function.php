<?php 

//affiche le nombre d'abonnés
function nbfollower($id_profil){
    $i = 0;
    $connexion = data();
    $req= "SELECT * FROM suivi WHERE suivi ='$id_profil'";
    $resultat = mysqli_query($connexion, $req);

    while(mysqli_fetch_assoc($resultat)){
        $i++;
    }

    return $i;
}

//Créer le bouton permettant de voir la liste des utilisateurs auxquels l'utilisateur avec $id_profil est abonné
function abonnement($id_profil){
    echo 
        '<div class="colonne">
        <form class="button_profil" method="post" action="">
            <input class="button" type="submit" name="abonnements" value="Voir les abonnements">
        </form>';

    //Si le bouton abonnements est cliqué
    if(isset($_POST['abonnements'])){
        $connexion = data();
        //Récupère les utilisateurs à qui notre utilisateur est abonné
        $req= "SELECT * FROM suivi WHERE suiveur = '$id_profil'";
        $resultat = mysqli_query($connexion, $req);

        while($res=mysqli_fetch_assoc($resultat)){
            //Récupère les infos des utilisateurs récupérés précédement
            $req1 = "SELECT * FROM utilisateur WHERE id = '".$res['suivi']."'";
            $resultat1 = mysqli_query($connexion, $req1);
            $utilisateur = mysqli_fetch_assoc($resultat1);
            echo '<div class="entete">';
            //Affiche la photo de profil et le pseudo de l'utilisateur
            echo profil($utilisateur);
            echo '</div>'; 
        }
    }

    echo '</div>';
}

//Créer le bouton permettant de voir la liste des utilisateurs qui sont abonnés au notre
function abonnes($id_profil){
    echo 
        '<div class="colonne"> 
        <form class="button_profil"  method="post" action="">
            <input class="button" type="submit" name="abonnes" value="Voir les abonnés">
        </form>';

    //Si le bouton abonnes est cliqué
    if(isset($_POST['abonnes'])){
        $connexion = data();
        //Récupère les utilisateurs abonnés au notre
        $req= "SELECT * FROM suivi WHERE suivi ='$id_profil'";
        $resultat = mysqli_query($connexion, $req);

        while($res=mysqli_fetch_assoc($resultat)){
            //Récupère les infos des utilisateurs récupérés précédement
            $req1 = "SELECT * FROM utilisateur WHERE id = '".$res['suiveur']."'";
            $resultat1 = mysqli_query($connexion, $req1);
            $utilisateur = mysqli_fetch_assoc($resultat1);
            echo '<div class="entete">';
            //Affiche la photo de profil et le pseudo de l'utilisateur
            echo profil($utilisateur);
            echo '</div>';
        }
    }

    echo '</div>';
}

?>