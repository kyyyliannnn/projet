<?php 

/*  Renvoie du code qui affiche le menu à gauche
    La sélection du paramètre permet de changer l'icone coloré
    L'icone coloré est celui correspondant à la page sur laquelle on est    */
function menu_gauche($i){

    $icone = ["o","o","o","o"];
    $icone[$i] = "n";

    echo 
        '<div id="menu_gauche"> 
            <img id="logo" src="image/logo2.png">
            <a href="accueil_publi.php" class="menu_gauche_bouton" >
                <img src="image/maison_'.$icone[0].'.png">
                <p class="'.$icone[0].'"> ACCUEIL </p>
            </a>

            <a href="recherche.php"  class="menu_gauche_bouton" >
                <img src="image/recherche_'.$icone[1].'.png">
                <p class="'.$icone[1].'"> RECHERCHE </p>
                </a>

            <a href="publier.php" class="menu_gauche_bouton" >
                <img src="image/plus_'.$icone[2].'.png">
                <p class="'.$icone[2].'"> CREER </p>
                </a>

            <a href="mon_profil.php" class="menu_gauche_bouton" >
                <img src="image/perso_'.$icone[3].'.png">
                <p class="'.$icone[3].'"> PROFIL </p>
                </a>

            <a href="accueil.php" class="menu_gauche_bouton" >
                <img src="image/deconnexion.png">
                <p class="o"> DECONNEXION </p>
            </a>

        </div>';

}

?>