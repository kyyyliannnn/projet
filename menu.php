<?php 

function menu($texte,$link){
    echo '<header>
            <img id="logo" src="image/logo2.png" alt="">
            <a href="" class="icone_menu">
                <img src="image/loupe.png" alt="">
                <p>A propos</p>
            </a>
            <a href="" class="icone_menu">
                <img src="image/contact.png" alt="">
                <p>Contact</p>
            </a>
            <hr>
            <a href="'.$link.'.php" class="button">'.$texte.'</a>
</header>';
}

function image(){
    echo '        <div class="element_flex2">
    <img id="bulle" src="image/bulle2.png" alt="">
    <p id="bulle_texte">Découvre 
        qui sont les étudiants de ton amphi !</p>
    <img id="gens" src="image/gens.png" alt="">
</div>';
}

