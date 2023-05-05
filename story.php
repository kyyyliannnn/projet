<!DOCTYPE html>
<html>
    <script>
        function affiche_story(id){
            var c = document.getElementById('sto' + id);
            c.style.display = "inline";
        }

        function cache_story(id){
            var c = document.getElementById('sto' + id);
            c.style.display = "none";
            var d = document.getElementById('rond' + id);
            d.style.borderColor = "#EED8C2";
        }
        
    </script>
</html>

<?php 


function story($util){

    echo "    <div class='story'>
    <button onclick='affiche_story(".$util['id'].")' class='pdp' id='rond".$util['id']."'>
    <div class='story_contour'>
        <img src='pdp/personne".$util['pdp'].".png'>
    </div>
    </button>
</div>";
}


function image_story($util){
    echo "<div  id='sto".$util['id']."' class='sto'> 
    <button onclick='cache_story(".$util['id'].")' class='flou'> 
    </button> <div class='image_story'>
    <img src='story/image".$util['id'].".png'> 
    </div> </div> ";
}

?>