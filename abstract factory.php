<?php
/*
要實體化(init)一系列相關的產品
*/
/*
difinition:
Provide an interface 
for creating families of related or dependent objects 
without specifying their concrete classes.
*/

//定義「多個」實體化的方法的介面
interface ComponentFactory
{
    //Provide an interface for creating families of related or dependent objects 
    public function makeMemoryFactory(string $type):Memory;
    public function makeVGAFactory(string $type):VGA;
}

//實踐「多個」實體化的方法
class VivoFactory implements ComponentFactory
{
    public function makeVGAFactory(string $type):VGA
    {
        switch ($type) {
            case '最高檔貨':
                return new Geforce('RTX-3300');

            case '次高檔貨':
                return new Geforce('RF-2000');
            default:
                return new Geforce('RS-1000');
        }
    }

    public function makeMemoryFactory(string $type):Memory
    {
        switch ($type) {
            case '最高檔貨':
                return new DDR4('16RAM','ROD');
            default:
                return new DDR4('8RAM','ROD');
        }
    }
}

$vivoCompoents = new VivoFactory();
$vivoVGA = $vivoCompoents->makeVGAFactory('最高檔貨');
echo $vivoVGA->model;

class Memory
{
    public $capacity;
    public $brand;
    protected $speedLevel;
    function __construct($capacity,$brand)
    {
        $this->capacity = $capacity;
        $this->brand = $brand;
    }

}

class DDR3 extends Memory
{
    function __construct($capacity,$brand)
    {
        parent::__construct($capacity,$brand);
        $this->speedLevel = '4';
    }
}

class DDR4 extends Memory
{
    function __construct($capacity,$brand)
    {
        parent::__construct($capacity,$brand);
        $this->speedLevel = '3';
    }
}

class VGA
{
    public $brand;
    public $model;
    function __construct($brand,$model){
        $this->capacity = $brand;
        $this->model = $model;
    }
}

class Geforce extends VGA
{
    function __construct($model){
        $this->model = $model;
        $this->brand = 'Nividia';
    }
}

class RX extends VGA
{
    function __construct($brand,$model){
        $this->model = $model;
        $this->brand = 'ROG';
    }
}
?>