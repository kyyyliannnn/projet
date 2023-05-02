<?php
session_start();

//fonction pour se connecter à la base de données
function data(){
    $connexion = mysqli_connect ('localhost', 'root', '', 'projet' ) ;
    if (!$connexion) {
        echo 'Pas de connexion au serveur '; exit;
    }
    mysqli_set_charset($connexion, 'utf8');
    return $connexion;
}

//fonction pour gérer les likes
function like($publi){
    if (isset($_POST['like'.$publi])){ //si le bouton "like" a été cliqué
        $connexion=data();
        $req1= 'SELECT * FROM aime WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"';
        $resultat = mysqli_query($connexion, $req1);
        $ligne=mysqli_fetch_assoc($resultat);
        $req2 = 'SELECT nblike FROM publication WHERE id="'.$publi.'"';
        $resultat2 = mysqli_query($connexion, $req2);
        $ligne2 = mysqli_fetch_assoc($resultat2);
        $nblike = $ligne2['nblike'];
        if (!empty($ligne)){ //si l'utilisateur a déjà liké la publication, on supprime le like
            $req = 'DELETE FROM aime WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"' ;
            $nblike--;
        }
        else { //sinon, on ajoute un like
            $req = 'INSERT INTO aime (utilisateur, publication) VALUES ("'.$_SESSION['utilisateur'].'","'.$publi.'")' ; 
            $nblike++;
        } 
        mysqli_query($connexion, $req);
        $req3 = 'UPDATE publication SET nblike="'.$nblike.'" WHERE id="'.$publi.'"';
        mysqli_query($connexion, $req3);
    }   
}

//fonction pour supprimer une publication (réservée aux administrateurs)
function supprimer($publi){
    if (isset($_POST['admin'.$publi])){
        $connexion = data();
        $publication = coPubli($publi);

        $req1= 'DELETE FROM `Publication` WHERE id="'.$publication['id'].'" ';
        mysqli_query($connexion, $req1);

        mysqli_close($connexion);
        //header('location:accueil_publi.php');
    }   
}

//fonction pour savoir si l'utilisateur a déjà liké une publication
function coeur($publi){
    $connexion=data();

    $req1= 'SELECT * FROM aime WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"';
    $resultat = mysqli_query($connexion, $req1);
    $ligne=mysqli_fetch_assoc($resultat);
    if (!empty($ligne)){
        return "p"; //renvoie "p" si l'utilisateur a déjà liké la publication
    }
    else {
        return "v"; //renvoie "v" si l'utilisateur n'a pas encore liké la publication
    }
}

//fonction pour ajouter un commentaire
function message($publi){
    if (!empty($_POST['message'.$publi])){
        $connexion=data();
        $req1= 'SELECT * FROM commentaire WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"'.' AND texte="'.$_POST['message'.$publi].'"';
        $resultat = mysqli_query($connexion, $req1);
        $ligne=mysqli_fetch_assoc($resultat);
        $req2 = 'SELECT nbcom FROM publication WHERE id="'.$publi.'"';
        $resultat2 = mysqli_query($connexion, $req2);
        $ligne2 = mysqli_fetch_assoc($resultat2);
        $nbcom = $ligne2['nbcom'];
        if (empty($ligne)){ //on vérifie si l'utilisateur a déjà posté ce commentaire
            $req = 'INSERT INTO commentaire (utilisateur, publication, texte) VALUES ("'.$_SESSION['utilisateur'].'","'.$publi.'","'.$_POST['message'.$publi].'")' ; 
            mysqli_query($connexion, $req);
            $nbcom++;
            $req3 = 'UPDATE publication SET nbcom="'.$nbcom.'" WHERE id="'.$publi.'"';
            mysqli_query($connexion, $req3);
        } 
    }
}

//fonction pour afficher un commentaire
function commentaire($texte,$pdp){
    echo  '<div class="com">
    <a href="" class="pdp"><img src="pdp/personne'.$pdp.'.png"></a>
    <p>'.$texte.'</p>
        </div>';
}

// Fonction pour afficher les commentaires d'une publication
function affiche($publi){
    $connexion=data();
    $req1= 'SELECT * FROM commentaire WHERE publication="'.$publi.'"';
    $resultat = mysqli_query($connexion, $req1);
    $ligne=mysqli_fetch_assoc($resultat);
    // Parcourir tous les commentaires de la publication
    while($ligne!=null){
        $req= 'SELECT * FROM utilisateur WHERE id="'.$ligne["utilisateur"].'"';
        $resultat1 = mysqli_query($connexion, $req);
        $utilisateur=mysqli_fetch_assoc($resultat1);
        // Afficher chaque commentaire avec son texte et la photo de profil de l'utilisateur
        commentaire($ligne['texte'],$utilisateur['pdp']);
        $ligne=mysqli_fetch_assoc($resultat);
    }
}

// Fonction pour se connecter à la base de données et récupérer les informations d'une publication
function coPubli($publi){
    $connexion=data();
    $req1= 'SELECT * FROM publication WHERE id="'.$publi.'"';
    $resultat = mysqli_query($connexion, $req1);
    $ligne=mysqli_fetch_assoc($resultat);
    return $ligne;
}

// Fonction pour récupérer les informations de l'utilisateur qui a publié une publication
function coUtilisateur($publi){
    $ligne = coPubli($publi);

    $connexion=data();

    $req= 'SELECT * FROM utilisateur WHERE id="'.$ligne["utilisateur"].'"';
    $resultat1 = mysqli_query($connexion, $req);
    $utilisateur=mysqli_fetch_assoc($resultat1);
    return $utilisateur;
}

if(isset($_POST['abonn'])){
    $_SESSION['id_profil'] = $_POST['abonn'];
    header('location:profil.php');
}

// Fonction pour afficher le profil de l'utilisateur qui a publié une publication
function profil($publi){
    $utilisateur = coUtilisateur($publi);
    
    //Plus beau mais on peut pas aller sur le profil de la personne
    // echo ' <a href="" class="pdp"><img src="pdp/personne'.$utilisateur['pdp'].'.png"></a>
    //<a href="" class="pseudo">'.$utilisateur['pseudo'].'</a>';

    echo '<form method="post" action="profil.php"><button type="image"  name="abonn" value="'.$utilisateur['id'].'" src="pdp/personne'.$utilisateur['pdp'].'.png" ></button></form>
          <form method="post" action="profil.php"><button type="submit" name="abonn" value="'.$utilisateur['id'].'">'.$utilisateur['pseudo'].'                     </button></form>';
}

// Fonction pour afficher une publication
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

// Fonction pour vérifier si l'utilisateur est un administrateur et retourner "admin" ou "nonadmin"
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

function reglage2($publi){
    return 'admin';
}

// Fonction pour afficher le formulaire d'écriture de commentaire
function ecrire($publi){
    $connexion=data();

    $req= 'SELECT * FROM utilisateur WHERE id="'.$_SESSION["utilisateur"].'"';
    $resultat1 = mysqli_query($connexion, $req);
    $utilisateur=mysqli_fetch_assoc($resultat1);

    echo '<div class="com">
    <a href="" class="pdp"><img src="pdp/personne'.$utilisateur['pdp'].'.png"></a>
    <form action="" method="post" >';//<form action="accueil_publi.php" method="post" >
    echo '<input type="texte" name="message'.$publi.'" class="message" placeholder="Ecrire un commentaire...">
    </form>
    </div>' ;
}

function publi($publi){
    // Appelle la fonction like() pour afficher le nombre de likes de la publication
    echo like($publi);
    // Appelle la fonction supprimer() pour afficher un bouton de suppression de la publication
    echo supprimer($publi);
    // Appelle la fonction message() pour afficher la section des commentaires
    echo message($publi);
    // Récupère le nombre de likes de la publication
    $like = coeur($publi);

    // Affiche le bloc HTML de la publication
    echo '<div class="publication">
            <div class="entete">';
    // Appelle la fonction profil() pour afficher la photo de profil de l'auteur de la publication
    echo profil($publi);
    // Affiche les boutons pour liker la publication, commenter la publication et accéder aux options de la publication
    echo '<div class="bouton_icone_boite">
            <form action="" method="post">';//<form action="accueil_publi.php" method="post">
                echo '<img src="image/coeur_'.$like.'.png">
                <input  class="bouton_icone" type="submit" name="like'.$publi.'" value="" id="like">
            </form>
            <button class="bouton_icone" onclick="affiche('.$publi.')"><img src="image/com.png"></button>
            <button class="bouton_icone" onclick="afficheMenu'.reglage($publi).'('.$publi.')"><img src="image/option.png"></button>
          </div>';
    // Affiche le formulaire de suppression de la publication
    // echo '<form action="accueil_publi.php" class="admin" id="admin'.$publi.'" method="post">
    echo '<form action="" class="admin" id="admin'.$publi.'" method="post">
            <input class="reglage" type="submit" name="admin'.$publi.'" value="Supprimer">
          </form>
        </div>';

    // Affiche le contenu de la publication
    echo publication($publi);

    // Affiche le bouton pour voir les commentaires
    echo ' <button class="commentaire" id="commentaire'.$publi.'" onclick="affiche('.$publi.')">Voir les commentaires</button>';

    // Affiche la section des commentaires
    echo '<div class="com_box" id="com_box'.$publi.'">';
    // Affiche les commentaires existants
    affiche($publi);
    // Affiche le formulaire pour écrire un nouveau commentaire
    ecrire($publi);
    // Affiche le bouton pour cacher les commentaires
    echo '<button class="commentaire" onclick="cache('.$publi.')">Cacher les commentaires</button>
          </div>';
    // Ferme le bloc HTML de la publication
    echo '</div>';
}


//version alternative à publi() où l'utilisateur est considéré comme admin
function publi2($publi){
    // Appelle la fonction like() pour afficher le nombre de likes de la publication
    echo like($publi);
    // Appelle la fonction supprimer() pour afficher un bouton de suppression de la publication
    echo supprimer($publi);
    // Appelle la fonction message() pour afficher la section des commentaires
    echo message($publi);
    // Récupère le nombre de likes de la publication
    $like = coeur($publi);

    // Affiche le bloc HTML de la publication
    echo '<div class="publication">
            <div class="entete">';
    // Appelle la fonction profil() pour afficher la photo de profil de l'auteur de la publication
    echo profil($publi);
    // Affiche les boutons pour liker la publication, commenter la publication et accéder aux options de la publication
    echo '<div class="bouton_icone_boite">
            <form action="" method="post">';//<form action="accueil_publi.php" method="post">
                echo '<img src="image/coeur_'.$like.'.png">
                <input  class="bouton_icone" type="submit" name="like'.$publi.'" value="" id="like">
            </form>
            <button class="bouton_icone" onclick="affiche('.$publi.')"><img src="image/com.png"></button>
            <button class="bouton_icone" onclick="afficheMenu'.reglage2($publi).'('.$publi.')"><img src="image/option.png"></button>
          </div>';
    // Affiche le formulaire de suppression de la publication
    // echo '<form action="accueil_publi.php" class="admin" id="admin'.$publi.'" method="post">
    echo '<form action="" class="admin" id="admin'.$publi.'" method="post">
            <input class="reglage" type="submit" name="admin'.$publi.'" value="Supprimer">
          </form>
        </div>';

    // Affiche le contenu de la publication
    echo publication($publi);

    // Affiche le bouton pour voir les commentaires
    echo ' <button class="commentaire" id="commentaire'.$publi.'" onclick="affiche('.$publi.')">Voir les commentaires</button>';

    // Affiche la section des commentaires
    echo '<div class="com_box" id="com_box'.$publi.'">';
    // Affiche les commentaires existants
    affiche($publi);
    // Affiche le formulaire pour écrire un nouveau commentaire
    ecrire($publi);
    // Affiche le bouton pour cacher les commentaires
    echo '<button class="commentaire" onclick="cache('.$publi.')">Cacher les commentaires</button>
          </div>';
    // Ferme le bloc HTML de la publication
    echo '</div>';
}




?>