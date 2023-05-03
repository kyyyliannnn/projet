<?php 

//fonction pour se connecter à la base de données
function data(){
    $connexion = mysqli_connect('localhost', 'root', 'root', 'projet') ;
    if (!$connexion) {
        echo 'Pas de connexion au serveur '; exit;
    }
    mysqli_set_charset($connexion, 'utf8');
    return $connexion;
}

?>