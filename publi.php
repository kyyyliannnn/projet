<?php
session_start();

function data(){
    $connexion = mysqli_connect ('localhost',
    'root', 'root', 'projet' ) ;
    if (!$connexion) {
        echo 'Pas de connexion au serveur '; exit;
    }
    mysqli_set_charset($connexion, 'utf8');
    return $connexion;
}

function like($publi){
    if (isset($_POST['like'.$publi])){
            $connexion=data();

            $req1= 'SELECT * FROM aime WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"';
            $resultat = mysqli_query($connexion, $req1);
            $ligne=mysqli_fetch_assoc($resultat);
            if (!empty($ligne)){
                $req = 'DELETE FROM aime WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"' ; 
            }
            else {
                $req = 'INSERT INTO aime (utilisateur, publication) VALUES ("'.$_SESSION['utilisateur'].'","'.$publi.'")' ; 
            } 
            mysqli_query($connexion, $req);
        }   
}

function supprimer($publi){
    if (isset($_POST['admin'.$publi])){
        $connexion = data();
            $publication = coPubli($publi);

            $req1= 'DELETE FROM `Publication` WHERE id="'.$publication['id'].'" ';
            mysqli_query($connexion, $req1);

            mysqli_close($connexion);
            header('location:accueil_publi.php');


        }   
}

function coeur($publi){
    $connexion=data();

    $req1= 'SELECT * FROM aime WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"';
    $resultat = mysqli_query($connexion, $req1);
    $ligne=mysqli_fetch_assoc($resultat);
    if (!empty($ligne)){
        return "p";
    }
    else {
        return "v";
    }
}

function message($publi){
    if (!empty($_POST['message'.$publi])){
        $connexion=data();
            $req1= 'SELECT * FROM commentaire WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"'.' AND texte="'.$_POST['message'.$publi].'"';
            $resultat = mysqli_query($connexion, $req1);
            $ligne=mysqli_fetch_assoc($resultat);
            if (empty($ligne)){
                $req = 'INSERT INTO commentaire (utilisateur, publication, texte) VALUES ("'.$_SESSION['utilisateur'].'","'.$publi.'","'.$_POST['message'.$publi].'")' ; 
                mysqli_query($connexion, $req);
            } 
    }
}

function commentaire($texte,$pdp){
    echo  '<div class="com">
    <a href="" class="pdp"><img src="pdp/personne'.$pdp.'.png"></a>
    <p>'.$texte.'</p>
        </div>';
}

function affiche($publi){
    $connexion=data();
    $req1= 'SELECT * FROM commentaire WHERE publication="'.$publi.'"';
    $resultat = mysqli_query($connexion, $req1);
    $ligne=mysqli_fetch_assoc($resultat);
    while($ligne!=null){
        $req= 'SELECT * FROM utilisateur WHERE id="'.$ligne["utilisateur"].'"';
        $resultat1 = mysqli_query($connexion, $req);
        $utilisateur=mysqli_fetch_assoc($resultat1);
        commentaire($ligne['texte'],$utilisateur['pdp']);
        $ligne=mysqli_fetch_assoc($resultat);
    }
}

function coPubli($publi){
    $connexion=data();
    $req1= 'SELECT * FROM publication WHERE id="'.$publi.'"';
    $resultat = mysqli_query($connexion, $req1);
    $ligne=mysqli_fetch_assoc($resultat);
    return $ligne;
}

function coUtilisateur($publi){
    $ligne = coPubli($publi);

    $connexion=data();

    $req= 'SELECT * FROM utilisateur WHERE id="'.$ligne["utilisateur"].'"';
    $resultat1 = mysqli_query($connexion, $req);
    $utilisateur=mysqli_fetch_assoc($resultat1);
    return $utilisateur;
}

function profil($publi){
    $utilisateur = coUtilisateur($publi);

    echo ' <a href="" class="pdp"><img src="pdp/personne'.$utilisateur['pdp'].'.png"></a>
    <a href="" class="pseudo">'.$utilisateur['pseudo'].'</a>';
}

function publication($publi){
    $ligne = coPubli($publi);
    $utilisateur = coUtilisateur($publi);

    echo ' <div class="image">
    <img src="publication/image'.$utilisateur['id'].'-'.$ligne['numero'].'.png">
</div>
<div class="texte">
    <p>'.$ligne['texte'].'</p>
</div>';
}

function reglage($publi){
    $connexion=data();
    $req= 'SELECT * FROM utilisateur WHERE id="'.$_SESSION['utilisateur'].'"';
    $resultat1 = mysqli_query($connexion, $req);
    $utilisateur=mysqli_fetch_assoc($resultat1);
    if($utilisateur['administrateur'] != 0){
        return 'admin';
    }
    else{
        return 'nonadmin';
    }
}


function ecrire($publi){
    $connexion=data();

    $req= 'SELECT * FROM utilisateur WHERE id="'.$_SESSION["utilisateur"].'"';
    $resultat1 = mysqli_query($connexion, $req);
    $utilisateur=mysqli_fetch_assoc($resultat1);

    echo '<div class="com">
    <a href="" class="pdp"><img src="pdp/personne'.$utilisateur['pdp'].'.png"></a>
    <form action="accueil_publi.php" method="post" >
    <input type="texte" name="message'.$publi.'" class="message" placeholder="Ecrire un commentaire...">
    </form>
    </div>' ;
}

function publi($publi){
    echo like($publi);
    echo supprimer($publi);
    echo message($publi);
    $like = coeur($publi);

 echo '<div class="publication">
 <div class="entete">';
    echo profil($publi);
     echo '<div class="bouton_icone_boite">
     <form action="accueil_publi.php" method="post">
     <img src="image/coeur_'.$like.'.png">
     <input  class="bouton_icone" type="submit" name="like'.$publi.'" value="" id="like"></form>
     <button class="bouton_icone" onclick="affiche('.$publi.')"><img src="image/com.png"></button>
     <button class="bouton_icone" onclick="afficheMenu'.reglage($publi).'('.$publi.')"><img src="image/option.png"></button>
     </div>
     <form action="accueil_publi.php" class="admin" id="admin'.$publi.'" method="post">

     <input class="reglage" type="submit" name="admin'.$publi.'" value="Supprimer"></form>
    </form>
 </div>'
;

 echo publication($publi);
 
 echo ' <button class="commentaire" id="commentaire'.$publi.'" onclick="affiche('.$publi.')">Voir les commentaires</button>

 
 <div class="com_box" id="com_box'.$publi.'">';


 affiche($publi);
 ecrire($publi);
 echo '<button class="commentaire" onclick="cache('.$publi.')">Cacher les commentaires</button>
 </div>';
 echo'</div>';

}



?>