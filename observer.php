<?php
abstract class Observer
{
    public function subscribe(Observed $subject)
    {
        $subject->subscribe($this);
    }
    abstract function action($msg);
}

class Observed
{
    public $observerList = [];

    public function subscribe(Observer $observer)
    {
        array_push($this->observerList,$observer);
    }

    public function notify($msg)
    {
        foreach($this->observerList as $observer){
            $observer->action($msg);
        }
    }
}

class TvObserver extends Observer
{
    public function action($msg)
    {
        echo "TV表示已收到 ".$msg.'\n';
    }
}

class PcObserver extends Observer
{
    public function action($msg)
    {
        echo "Pc表示已收到 ".$msg.'\n';
    }
}

$obs = new Observed();
$tvShow = new TvObserver();
$tvShow->subscribe($obs);
$pc = new PcObserver();
$pc->subscribe($obs);
$obs->notify("顆顆");
//https://refactoring.guru/design-patterns/observer
?>