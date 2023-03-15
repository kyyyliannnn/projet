<?php 

function menu($texte){
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
            <a href="'.$texte.'.php" class="button">'.$texte.'</a>
</header>';
}

