<?php 

function menu($texte,$link){
    echo '<header>
            <img id="logo" src="image/logo2.png" alt="">
            <a href="propos.php" class="icone_menu">
                <img src="image/loupe.png" alt="">
                <p>A propos</p>
            </a>
            <a href="contact.php" class="icone_menu">
                <img src="image/contact.png" alt="">
                <p>Contact</p>
            </a>
            <hr>
            <a href="'.$link.'.php" class="button">'.$texte.'</a>
</header>';
}

function image(){
    echo '        <div class="element_flex3">
    <img id="bulle" src="image/bulle.png" alt="">
    <img id="gens" src="image/gens.png" alt="">
</div>';
}

