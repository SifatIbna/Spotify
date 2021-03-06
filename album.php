<?php include("includes/header.php");

if(isset($_GET['id'])) {
    $albumID = $_GET['id'];
}

else {
   header("Location:index.php");
}

$album = new Album($con,$albumID);

$artist = $album->getArtistId();

//echo $album->getTitle(). "<br>";
//echo $artist->getName();
?>

<div class="entityInfo">

    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath();?>">
    </div>

    <div class="rightSection">
        <h2> <?php echo $album->getTitle(); ?> </h2>
        <p>By <?php echo $artist->getName(); ?></p>
        <p><?php if($album->getNumSongs()>1){
            echo $album->getNumSongs()." Albums";
            }
            else {
                echo $album->getNumSongs()." Album";
            }
        ?></p>

    </div>
</div>

<div class="trackListContainer">
    <ul class="trackList">
        <?php
        $songIdArray = $album->getSongIds();
        $i = 1;
        foreach ($songIdArray as $songId) {
           $albumSong = new Song($con,$songId);
           $albumArtist = $albumSong->getArtist();

           echo "<li class='trackListRow'>
                    <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-white.png'>
                        <span class='trackNumber'>$i</span>                 
                    </div>
                    
                    <div class='trackInfo'>
                        <span class='trackName'>".$albumSong->getTitle()."</span>
                        <span class='artistName'>".$albumArtist->getName()."</span>
                    </div>
                    
                    <div class='trackOptions'>
                        <img class='optionsButtons' src='assets/images/icons/more.png'>
                    </div>
                    
                    <div class='trackDuration'>
                        <span class='duration'>".$albumSong->getDuration()."</span>
                    </div>
                </li>";
           $i++;
        }
        ?>

    </ul>
</div>



<?php include("includes/footer.php");?>
