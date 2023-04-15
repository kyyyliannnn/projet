<?php 



function story($id){
    echo "    <div class='story'>
    <button onclick='affiche_story($id)' class='pdp' id='rond$id'>
    <div class='story_contour'>
        <img src='pdp/personne$id.png'>
    </div>
    </button>
</div>";
}

function image_story($id){
    echo "<div  id='sto$id' class='sto'> <button onclick='cache_story($id)' class='flou'> </button> <div class='image_story'><img src='story/image$id.png'> </div> </div> ";
}

?>