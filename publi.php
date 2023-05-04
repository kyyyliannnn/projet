<?php
    session_start();

    include("base_donnee.php");


    //fonction pour gérer les likes
    function like($publi){

        //Si le bouton like a été cliqué
        if (isset($_POST['like'.$publi])){
            $connexion=data();
            //Récupère l'id du j'aime de l'utilisateur sur la publication
            $req1= 'SELECT * FROM aime WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"';
            $resultat1 = mysqli_query($connexion, $req1);
            $ligne1=mysqli_fetch_assoc($resultat1);
            //Récupère le nombre de like de la publication
            $req2 = 'SELECT nblike FROM publication WHERE id="'.$publi.'"';
            $resultat2 = mysqli_query($connexion, $req2);
            $ligne2 = mysqli_fetch_assoc($resultat2);
            $nblike = $ligne2['nblike'];

            //si l'utilisateur a déjà liké la publication, on supprime le like
            if (!empty($ligne1)){ 
                //On retire le like de l'utilisateur de la publication
                $req = 'DELETE FROM aime WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"' ;
                //Le nombre de like de la publication baisse de 1
                $nblike--;
            }

            else {
                //On ajoute un like de l'utilisateur à la publication
                $req = 'INSERT INTO aime (utilisateur, publication) VALUES ("'.$_SESSION['utilisateur'].'","'.$publi.'")' ; 
                //Le nombre de like de la publication augmente de 1
                $nblike++;
            } 
            mysqli_query($connexion, $req);
            //On applique le nouveau nombre de like
            $req3 = 'UPDATE publication SET nblike="'.$nblike.'" WHERE id="'.$publi.'"';
            mysqli_query($connexion, $req3);
        }   
    }


    //fonction pour supprimer une publication (réservée aux administrateurs)
    function supprimer($publi){

        //Si le bouton est cliqué de supression est cliqué
        if (isset($_POST['admin'.$publi])){
            $connexion = data();
            $publication = coPubli($publi);
            //On supprime la publication de la base de données
            $req1= 'DELETE FROM `publication` WHERE id="'.$publication['id'].'" ';
            $resultat1 = mysqli_query($connexion, $req1);
            mysqli_close($connexion);
            //On envoie l'utilisateur sur la même page pour la raffraichir et éviter un bug d'affichage
            header('location:'.$_SERVER['REQUEST_URI']);
        }   
    }


    //fonction pour savoir si l'utilisateur a déjà liké une publication
    function coeur($publi){
        $connexion=data();
        //On récupère le like de l'utilisateur sur la publication
        $req1= 'SELECT * FROM aime WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"';
        $resultat1 = mysqli_query($connexion, $req1);
        $ligne=mysqli_fetch_assoc($resultat1);

        //Si le like existe
        if (!empty($ligne)){
            return "p";
        }

        //Si le like n'existe pas
        else {
            return "v";
        }
    }


    //fonction pour ajouter un commentaire
    function message($publi){

        //Vérifie qu'il y a un contenu
        if (!empty($_POST['message'.$publi])){
            $connexion=data();
            //Récupère le commentaire de l'utilisateur sur cette publication avec ce message
            $req1= 'SELECT * FROM commentaire WHERE utilisateur="'.$_SESSION['utilisateur'].'"'.' AND publication="'.$publi.'"'.' AND texte="'.$_POST['message'.$publi].'"';
            $resultat1 = mysqli_query($connexion, $req1);
            $ligne=mysqli_fetch_assoc($resultat1);
            //Récupère le nombre de commentaire de la publication
            $req2 = 'SELECT nbcom FROM publication WHERE id="'.$publi.'"';
            $resultat2 = mysqli_query($connexion, $req2);
            $ligne2 = mysqli_fetch_assoc($resultat2);
            $nbcom = $ligne2['nbcom'];

            //Verifie que l'utilisateur n'a pas déjà posté ce commentaire
            if (empty($ligne)){ 
                //Ajoute le commentaire à la publication
                $req3 = 'INSERT INTO commentaire (utilisateur, publication, texte) VALUES ("'.$_SESSION['utilisateur'].'","'.$publi.'","'.$_POST['message'.$publi].'")' ; 
                mysqli_query($connexion, $req3);
                $nbcom++;
                //Augmente de 1 le nombre de commentaire de la publication
                $req4 = 'UPDATE publication SET nbcom="'.$nbcom.'" WHERE id="'.$publi.'"';
                mysqli_query($connexion, $req4);
            } 
        }
    }


    //fonction pour afficher un commentaire avec un lien sur la photo de profil pour aller voir le profil
    function commentaire($texte,$utilisateur){
        echo  
        '<div class="com">
            <a href="profil.php?id='.$utilisateur['id'].'" class="pdp"><img src="pdp/personne'.$utilisateur['pdp'].'.png"></a>
            <p>'.$texte.'</p>
        </div>';
    }


    // Fonction pour afficher les commentaires d'une publication
    function affiche($publi){
        $connexion=data();
        //Récupère les commentaires de la publication
        $req1= 'SELECT * FROM commentaire WHERE publication="'.$publi.'"';
        $resultat1 = mysqli_query($connexion, $req1);
        $ligne=mysqli_fetch_assoc($resultat1);

        //Affiche chaque commentaire et la photo de profil
        while($ligne!=null){
            //Récupère l'utilisateur qui a posté un commentaire
            $req2= 'SELECT * FROM utilisateur WHERE id="'.$ligne["utilisateur"].'"';
            $resultat2 = mysqli_query($connexion, $req2);
            $utilisateur=mysqli_fetch_assoc($resultat2);
            //Affiche le commentaire
            commentaire($ligne['texte'],$utilisateur);
            $ligne=mysqli_fetch_assoc($resultat1);
        }
    }


    // Fonction pour récupérer les infos d'une publication à partir de son id
    function coPubli($publi){
        $connexion=data();
        //Récupère les infos de la publication
        $req1= 'SELECT * FROM publication WHERE id="'.$publi.'"';
        $resultat1 = mysqli_query($connexion, $req1);
        $ligne=mysqli_fetch_assoc($resultat1);
        return $ligne;
    }


    // Fonction pour récupérer les infos de l'utilisateur qui a publié la publication
    function coUtilisateur($publi){
        //Récupère les infos de la publication
        $ligne = coPubli($publi);
        $connexion=data();
        //Récupère les infos de l'utilisateur qui a posté la publication
        $req1= 'SELECT * FROM utilisateur WHERE id="'.$ligne["utilisateur"].'"';
        $resultat1 = mysqli_query($connexion, $req1);
        $utilisateur=mysqli_fetch_assoc($resultat1);
        return $utilisateur;
    }


    // Fonction pour afficher l'utilisateur qui a publié la publication avec un lien vers son profil
    function profil($utilisateur){
        echo 
        '<a href="profil.php?id='.$utilisateur['id'].'" class="pdp"><img src="pdp/personne'.$utilisateur['pdp'].'.png"></a>
        <a href="profil.php?id='.$utilisateur['id'].'" class="pseudo">'.$utilisateur['pseudo'].'</a>';
    }


    // Fonction pour afficher une publication
    function publication($publi){
        $ligne = coPubli($publi);
        $utilisateur = coUtilisateur($publi);
        //Affiche l'image puis son texte associé
        echo 
        '<div class="image">
            <img src="publication/image'.$utilisateur['id'].'-'.$ligne['numero'].'.png">
        </div>
        <div class="texte">
            <p>'.$ligne['texte'].'</p>
        </div>';
    }


    // Fonction pour vérifier si l'utilisateur est admin
    function reglage($publi){
        $connexion=data();
        //Récupère les infos de l'tuilisateur connecté
        $req1= 'SELECT * FROM utilisateur WHERE id="'.$_SESSION['utilisateur'].'"';
        $resultat1 = mysqli_query($connexion, $req1);
        $utilisateur=mysqli_fetch_assoc($resultat1);
        //Vérifie si il est administrateur
        if($utilisateur['administrateur'] != 0){
            return 'admin';
        }
        else{
            return 'nonadmin';
        }
    }


    //Fonction alternative à la précédente pour la fonction publi2()
    function reglage2($publi){
        return 'admin';
    }


    //Renvoie le nombre de like d'une publication
    function comptelike($publi){
        $publi = coPubli($publi); 
        return $publi['nblike'];
    }


    //Renvoie le nombre de commentaire d'une publication 
    function comptecom($publi){
        $publi = coPubli($publi); 
        return $publi['nbcom'];
    }


    // Fonction pour écrire un commentaire
    function ecrire($publi){
        $connexion=data();
        //Récupère les infos de l'utilisateur connecté
        $req1= 'SELECT * FROM utilisateur WHERE id="'.$_SESSION["utilisateur"].'"';
        $resultat1 = mysqli_query($connexion, $req1);
        $utilisateur=mysqli_fetch_assoc($resultat1);
        //Affiche la photo de profil avec un lien vers le profil et le formulaire pour écrire un commentaire
        echo 
            '<div class="com">
                <a href="profil.php?id='.$utilisateur['id'].'" class="pdp"><img src="pdp/personne'.$utilisateur['pdp'].'.png"></a>
                <form action="" method="post" >
                    <input type="texte" name="message'.$publi.'" class="message" placeholder="Ecrire un commentaire...">
                </form>
            </div>' ;
    }


    //Fonction pour afficher la publication
    function publi($publi){
        like($publi);
        supprimer($publi);
        message($publi);
        $like = coeur($publi);
        echo 
            '<div class="publication">
                <div class="entete">';
        profil(coUtilisateur($publi));
        echo 
                    '<div class="bouton_icone_boite">
                        <p class="nblike">'.comptelike($publi).'</p>
                        <p class="nbcom">'.comptecom($publi).'</p>
                        <form action="" method="post">
                            <img src="image/coeur_'.$like.'.png">
                            <input  class="bouton_icone" type="submit" name="like'.$publi.'" value="" id="like">
                        </form>
                        <button class="bouton_icone" onclick="affiche('.$publi.')"><img src="image/com.png"></button>
                        <button class="bouton_icone" onclick="afficheMenu'.reglage($publi).'('.$publi.')"><img src="image/option.png"></button>
                    </div>
                    <form action="" class="admin" id="admin'.$publi.'" method="post">
                        <input class="reglage" type="submit" name="admin'.$publi.'" value="Supprimer">
                    </form>
                </div>';
        publication($publi);
        echo 
                '<button class="commentaire" id="commentaire'.$publi.'" onclick="affiche('.$publi.')">Voir les commentaires</button>
                <div class="com_box" id="com_box'.$publi.'">';
        affiche($publi);
        ecrire($publi);
        echo 
                    '<button class="commentaire" onclick="cache('.$publi.')">Cacher les commentaires</button>
                </div>
            </div>';
    }


    //version alternative à la précédente mais où cette fois l'utilisateur est considéré comme admin, elle est donc utilisée seulement sur mon_profil.php
    function publi2($publi){
        like($publi);
        supprimer($publi);
        message($publi);
        $like = coeur($publi);
        echo 
            '<div class="publication">
                <div class="entete">';
        profil(coUtilisateur($publi));
        echo 
                    '<div class="bouton_icone_boite">
                        <p class="nblike">'.comptelike($publi).'</p>
                        <p class="nbcom">'.comptecom($publi).'</p>
                        <form action="" method="post">
                            <img src="image/coeur_'.$like.'.png">
                            <input  class="bouton_icone" type="submit" name="like'.$publi.'" value="" id="like">
                        </form>
                        <button class="bouton_icone" onclick="affiche('.$publi.')"><img src="image/com.png"></button>
                        <button class="bouton_icone" onclick="afficheMenu'.reglage2($publi).'('.$publi.')"><img src="image/option.png"></button>
                    </div>
                    <form action="" class="admin" id="admin'.$publi.'" method="post">
                        <input class="reglage" type="submit" name="admin'.$publi.'" value="Supprimer">
                    </form>
                </div>';
        publication($publi);
        echo 
                '<button class="commentaire" id="commentaire'.$publi.'" onclick="affiche('.$publi.')">Voir les commentaires</button>
                <div class="com_box" id="com_box'.$publi.'">';
        affiche($publi);
        ecrire($publi);
        echo 
                    '<button class="commentaire" onclick="cache('.$publi.')">Cacher les commentaires</button>
                </div>
            </div>';
    }
    
?>