<?php

$songQuery = mysqli_query($con,"SELECT id FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray,$row['id']);
}

$jasonArray = json_encode($resultArray);
?>

<script>
    currentPlaylist = <?php echo  $jasonArray;?> ;

   $(document).ready(function () {
       currentPlaylist = <?php echo $jasonArray; ?> ;

       audioElement = new Audio();
       setTrack(currentPlaylist[0],currentPlaylist,false);
   });

   function setTrack(trackId,newPlayList, play) {

       //audioElement.setTrack("assets/music/bensound-clearday.mp3");
       //audioElement.audio.play();

       $.post("includes/handlers/ajax/getSongJson.php",{songId: trackId}, function (data) {

           var track = JSON.parse(data);

           $(".trackName span").text(track.title);

           $.post("includes/handlers/ajax/getArtistJson.php",{artistId: track.artist}, function (data) {
                var artist = JSON.parse(data);

               $(".artistName span").text(artist.name);
           });

           $.post("includes/handlers/ajax/getAlbumJson.php",{albumId: track.album}, function (data) {
               var album = JSON.parse(data);
               $(".albumLink img").attr("src",album.artworkPath);

           });
           audioElement.setTrack(track);
          // audioElement.play();

       });

       if(play){

       }

   }
   
   function playSong() {

       console.log(audioElement);

       if(audioElement.audio.currentTime == 0) {
           $.post("includes/handlers/ajax/updatePlay.php",{songId: audioElement.currentPlaying.id });
           //console.log(audioElement.currentPlaying.id );
       }
       $(".controlButton.play").hide();
       $(".controlButton.pause").show();
       audioElement.play();
   }
   
   function pauseSong() {
       $(".controlButton.play").show();
       $(".controlButton.pause").hide();
       audioElement.pause();
   }

</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img src="" class="albumArtWork">
                </span>

                <div class="trackInfo">
                    <span class="trackName">
                        <span></span>
                    </span>

                    <span class="artistName">
                        <span></span>
                    </span>

                </div>
            </div>

        </div>
        <div id="nowPlayingCenter">

            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle button">
                        <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous button">
                        <img src="assets/images/icons/previous.png" alt="Previous">
                    </button>

                    <button class="controlButton play" title="Play button" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause button"  style="display: none;" onclick="pauseSong()">
                        <img src="assets/images/icons/pause.png" alt="Pause">
                    </button>

                    <button class="controlButton next" title="Next button">
                        <img src="assets/images/icons/next.png" alt="Next">
                    </button>

                    <button class="controlButton Repeat" title="Repeat button">
                        <img src="assets/images/icons/repeat.png" alt="Repeat">
                    </button>

                </div>
                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0.00</span>
                </div>
            </div>
        </div>
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="volume button">
                    <img src="assets/images/icons/volume.png" alt="volume">
                </button>
            </div>

            <div class="progressBar">
                <div class="progressBarBg">
                    <div class="progress">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
