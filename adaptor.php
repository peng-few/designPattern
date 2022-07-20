<?php
/*
definition:
This is a special object that converts the interface of one object so that another object can understand it
*/
/*
使用時機:
1. 某個class想轉換成另外一個class
2. 當某個既有的class缺少某些function，但這個function並不適合直接添加進去 (逼不得已: 不然code會變醜喔)
*/

class RoundHole
{
    protected $radius;

    function __construct($radius)
    {
        $this->radius = $radius;
    }

    public function fit(RoundPeg $peg)
    {
       echo $peg->getRadius() <= $this->radius ? "塞的進去!" : "塞不進去XX";
    }
}

//發生的狀態: 有兩個不同的class要做「連結」
class RoundPeg
{
    protected $radius;

    function __construct($radius)
    {
        $this->radius = $radius;
    }

    public function getRadius(){
        return $this->radius;
    }
}

class SquarePeg
{
    protected $width;

    function __construct($width)
    {
        $this->width = $width;
    }

    public function getWidth(){
        return $this->width;
    }
}

class SquareToRoundPeg extends RoundPeg
{
    private $square;
    function __construct(SquarePeg $square)
    {
        //覆蓋掉了原本的$radius設定(這邊的$radius的變數已無使用)
        $this->square = $square;
    }

    public function getRadius(){
        return $this->square->getWidth() * sqrt(2) / 2;
    }
}

$hole = new RoundHole(6);
$round1 = new RoundPeg(7);
$hole->fit($round1);

$square = new SquarePeg(5);
$squareToRound = new SquareToRoundPeg($square);
$hole->fit($squareToRound);

?>