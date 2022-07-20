<?php
/*
composition
使用時機:
1. 想要在執行時動態加功能給object，但又不會破壞object原本的格式
2. 當試圖使用inheritance來增加功能，發現需要inherit出的subclass有共通的功能但是又沒法合成一個subclass
*/
/*
補充 : decorator模式就如同wrapper，層層包住(recursive composition)，一層一層的執行
主要達成的方法 : wrapper與 wrapped(被包者)需implement相同的interface，讓兩者在方法的構造上是一樣的
包的每一層都必定執行，無法有那一層跳過
*/
/*
definition:
allows behavior to be added to an individual object, 
dynamically, without affecting the behavior of other objects from the same class.
*/

//wrapper 與 wrapped 需實踐的共同interface
interface Writer
{
    public function write(string $text):string;
    public function getText():string;
}

//wrapped
class TextBox implements Writer
{
    private $text = "";

    public function write(string $text):string
    {
        $this->text = $this->text.$text;
        return $this->text;
    }

    public function getText():string
    {
        return $this->text;
    }
}

// wrapper的 super-class，必須有reference指向wrapped 
class TextBoxDecorator implements Writer
{   
    /** 
     * @var Writer reference指向wrapped 
    */
    public $wrapped;

    function __construct(Writer $writer)
    {
        $this->wrapped = $writer;
    }

    /**
     * 在decorator的super-class 就代理執行 wrapped 原本要執行的事
     * 實作的decorator sub-class 透過 parent::write來呼叫
     **/ 
    public function write(string $text):string
    {
        return $this->wrapped->write($text);
    }

    public function getText():string
    {
        return $this->wrapped->getText();
    }
}

//加蔥的decorator
class BolderDecorator extends TextBoxDecorator
{
    public function write(string $text):string
    {
        $text = "<b>".$text."</b>";
        return parent::write($text);
    }
}

class ItalicDecorator extends TextBoxDecorator
{
    public function write(string $text):string
    {
        $text = "<i>".$text."</i>";
        return parent::write($text);
    }
}


$editor = new TextBox();
$boldText = new BolderDecorator($editor);
$boldItlicText = new ItalicDecorator($boldText);
$boldItlicText->write("第一段文字");
$boldItlicText->write("第二段文字");
echo $boldItlicText->getText();
?>