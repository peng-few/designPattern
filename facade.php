<?php
$audioPlayer = new AudioPlayer();
$dvdPlayer = new DvdPlayer();
$screen = new Screen();
$watchMethod = new WatchFacade($audioPlayer,$screen,$dvdPlayer);
$watchMethod->watchVideo('貓咪大作戰');

class WatchFacade{
    public AudioPlayer $audioPlayer;
    public Screen $screen;
    public DvdPlayer $dvdPlayer;
    
    function __construct(AudioPlayer $audioPlayer,Screen $screen,DvdPlayer $dvdPlayer)
    {
        $this->audioPlayer = $audioPlayer;
        $this->screen = $screen;
        $this->dvdPlayer = $dvdPlayer;
    }

    //包裝複雜行為的介面
    public function watchVideo($dvdName)
    {
        $this->screen->on();
        $this->screen->setAudioPlayer($this->audioPlayer);
        $this->screen->setDvdPlayer($this->dvdPlayer);
        $this->audioPlayer->on();
        $this->dvdPlayer->on();
        $this->dvdPlayer->setDvd($dvdName);
        $this->dvdPlayer->play();
    }

    public function closeVideo()
    {
        $this->screen->off();
        $this->audioPlayer->off();
        $this->dvdPlayer->off();
        $this->dvdPlayer->setDvd("");
        $this->dvdPlayer->stop();
    }
}

//以下為subSystem，通常代表既有且精密的class
class AudioPlayer
{
    public function on(){
        echo "打開音響\n";
    }

    public function off(){
        echo "關閉音響\n";
    }
}

class Screen
{
    public AudioPlayer $audioPlayer;
    public DvdPlayer $dvdPlayer;

    public function setAudioPlayer(AudioPlayer $audioPlayer)
    {
        $this->audioPlayer = $audioPlayer;
    }

    public function setDvdPlayer(DvdPlayer $dvdPlayer)
    {
        $this->dvdPlayer = $dvdPlayer;
    }

    public function on(){
        echo "打開螢幕\n";
    }

    public function off(){
        echo "關掉螢幕\n";
    }
}

class DvdPlayer
{
    private $dvd;
    public Screen $screen;
 
    public function on()
    {
        echo "打開DVD撥放器\n";
    }

    public function play()
    {
        echo "播放影片:".$this->dvd."\n";
    }

    public function stop()
    {
        echo "停止影片:".$this->dvd."\n";
    }

    public function pause()
    {
        echo "暫停影片:".$this->dvd."\n";
    }

    public function setScreen(Screen $screen)
    {
        $this->screen = $screen;
    }

    public function setDvd(string $name)
    {
        $this->dvd = $name;
    }

    public function off()
    {
        echo "關閉DVD撥放器\n";
    }
}
?>