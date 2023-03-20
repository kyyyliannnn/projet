<?php 

function menu_gauche($i){
    $icone = ["o","o","o","o"];
    $icone[$i] = "n";

    echo '<div id="menu_gauche">
    <img id="logo" src="image/logo2.png">
    <a href="" class="menu_gauche_bouton" >
        <img src="image/maison_'.$icone[0].'.png">
        <p class="'.$icone[0].'"> ACCUEIL </p>
    </a>    
    <a href=""  class="menu_gauche_bouton" >
        <img src="image/recherche_'.$icone[1].'.png">
        <p class="'.$icone[1].'"> RECHERCHE </p>
        </a> 
    <a href="" class="menu_gauche_bouton" >
        <img src="image/plus_'.$icone[2].'.png">
        <p class="'.$icone[2].'"> CREER </p>
        </a> 
    <a href="" class="menu_gauche_bouton" >
        <img src="image/perso_'.$icone[3].'.png">
        <p class="'.$icone[3].'"> PROFIL </p>
        </a> 
</div>';
}






?>