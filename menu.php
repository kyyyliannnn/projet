<?php 

function menu($texte,$link){
    echo '<header>
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

