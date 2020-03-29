
var currentPlaylist = [];
var audioElement;
var mouseDown = false;

function formatTime(seconds) {

    var time = Math.round(seconds);
    var minutes = Math.floor(time/60);
    var seconds = time-minutes*60;

    if(seconds <10) {
        return minutes+":"+"0"+seconds;
    }
    return minutes+":"+seconds ;
}

function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration-audio.currentTime));

    var progress  = audio.currentTime/audio.duration *100;
    $("#nowPlayingCenter .progress").css("width",progress+"%");
}

function Audio(){
    this.currentPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("canplay",function () {
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate",function () {
       if(this.duration) {
           updateTimeProgressBar(this);
       }
    });

    this.setTrack = function (track) {

        this.currentPlaying = track;
        this.audio.src = track.path;
    };

    this.play = function () {
        this.audio.play();
    }

    this.pause = function () {
        this.audio.pause();
    }
}