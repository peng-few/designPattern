<?php
/*
使用時機:
當construct過於冗長
需要透過判斷來實體化(new)稍有不同的產品(但擁有共同的superclass)
並且對這些產品有共同的方法要呼叫(oderPizza)
*/
/*
definition: 
Factory Method defines an interface for creating an object,
but lets subclasses decide which of those to instantiate.
A factory method lets classes defer instantiation to subclasses.
 */

/*
定義實體化方法的interface(createPizza)
這裡使用abstract super-class，是因為產生出來的產品有共同的邏輯組合可以使用(orderPizza)，因此可以在這裡先定義好
*/
abstract class PizzaStore {
    // parant defined an interface for creating an object
    abstract function createPizza(string $pizzaType):Pizza;

    public function orderPizza($pizzaType)
    {
      $pizza = $this->createPizza($pizzaType);
      $pizza->toldPrice();
      $pizza->prepare();
      $pizza->bake();
      $pizza->finish();
    }
}

//由sub-class來實踐實體化方法
class TPEStore extends PizzaStore{
    //lets subclasses decide which of those to instantiate
    function createPizza(string $pizzaType):Pizza
    {
        switch ($pizzaType) {
            case 'doubleCheesePizza':
                return new CheesePizza('雙倍濃厚起司pizza',999);
            case 'hawaiiPizza': 
                return new HawaiiPizza('夏威夷pizza',350);
            default:
                return new CheesePizza('起司pizza',500);
        }
    }
}

//定義實體化所返回的object其共同super-class (工廠所產出的object需有共通的super-class)
abstract class Pizza{
    protected $pizzaName;
    protected $price;

    function __construct(string $name,Int $price){
        $this->pizzaName = $name;
        $this->price = $price;
    }

    public function toldPrice()
    {
        echo "這個".$this->pizzaName."要價".$this->price."元\n";
    }
    abstract public function prepare():void;
    abstract public function bake():void;
    abstract public function finish():void;

}

class CheesePizza extends Pizza{
    public function prepare():void
    {
        echo $this->pizzaName."加入超級大量的起司\n";
    }
    public function bake():void
    {
        echo $this->pizzaName."需要高溫烤40分鐘讓起司融化\n";
    }
    public function finish():void
    {
        echo $this->pizzaName."完成出爐!\n";
    }
}

class HawaiiPizza extends Pizza{
    public function prepare():void
    {
        echo $this->pizzaName."加入火腿跟鳳梨\n";
    }
    public function bake():void
    {
        echo $this->pizzaName."需要高溫烤20分鐘\n";
    }
    public function finish():void
    {
        echo $this->pizzaName."完成出爐!\n";
    }
}

$northTREStore = new TPEStore();
$northTREStore->orderPizza('doubleCheesePizza');
$northTREStore->orderPizza('hawaiiPizza');
?>