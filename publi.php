<?php

$_SESSION["utilisateur"]=1;

function coeur($publi){
    $connexion = mysqli_connect ('localhost',
            'root', 'root', 'projet' ) ;
    if (!$connexion) {
        echo 'Pas de connexion au serveur '; exit;
     }
    mysqli_set_charset($connexion, 'utf8');
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

function like($publi){
    if (isset($_POST['like'.$publi])){
        $connexion = mysqli_connect ('localhost',
            'root', 'root', 'projet' ) ;
            if (!$connexion) {
                echo 'Pas de connexion au serveur '; exit;
            }
            mysqli_set_charset($connexion, 'utf8');
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




function publi($publi){
    echo like($publi);
    $like = coeur($publi);

 echo '<div class="publication">
 <div class="entete">
     <a href="" class="pdp"><img src="image/personne1.png"></a>
     <a href="" class="pseudo">Laura32_</a>
     <div class="bouton_icone_boite">
     <form action="accueil_publi.php" method="post">
     <img src="image/coeur_'.$like.'.png">
     <input  class="bouton_icone" type="submit" name="like'.$publi.'" value="" id="like"></form>
     <button class="bouton_icone" onclick="affiche()"><img src="image/com.png"></button>
     <button class="bouton_icone" onclick="afficheMenu()"><img src="image/option.png"></button>
     </div>

 </div>
 <div class="image">
     <img src="image/image1.png">
 </div>
 <div class="texte">
     <p>Une journée banale...</p>
 </div>
 <button class="commentaire" id="commentaire'.$publi.'" onclick="affiche('.$publi.')">Voir les commentaires</button>
 <div class="com_box" id="com_box'.$publi.'">
 <div class="com">
     <a href="" class="pdp"><img src="image/personne1.png"></a>
     <p>Geniaaaal !</p>
 </div>
 <div class="com">
     <a href="" class="pdp"><img src="image/personne1.png"></a>
     <p>trop cool !</p>
 </div>
 <div class="com">
     <a href="" class="pdp"><img src="image/personne1.png"></a>
     <p>wow !</p>
 </div>
 <button class="commentaire" onclick="cache('.$publi.')">Cacher les commentaires</button>
 </div>';


 
 echo'</div>';



}



?>