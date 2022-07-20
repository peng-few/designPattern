

class Dish{
    constructor(name,isVeg,price){
        this.name = name;
        this.isVeg = isVeg;
        this.price = price;
    }
}

class ObjectIterator{
    [Symbol.iterator](){
        let that = this;
        
        let position = 0; //是閉包    
        return {
            next(){   
                const keys = Object.values(that);
                const value = keys[position]
                if(position < keys.length){   
                    position += 1;
                    return {value,done : false}
                }else{
                    return {value:undefined,done : true} //DONE 代表已經沒有資料了，值為未定義
                }
            }
        }
    }
}


class Waiter{
    constructor(menus){
        this.menus = menus;
    }

    printAllMenu(){
        this.menus.forEach(menu => {
            this.printMenu(menu);
        });
    }

    printMenu(menu){
        for (const dish of menu) {
            console.log(`${dish.name}  ${dish.isVeg} ${dish.price}`);
        }
    }
}

const breakfastMenu = [];
breakfastMenu.push(new Dish("鬆餅",true,58))
breakfastMenu.push(new Dish("牛奶",false,28))
breakfastMenu.push(new Dish("蛋餅",false,30))

const dinnerMenu = new ObjectIterator();
dinnerMenu["炒麵"] = new Dish("炒麵",false,88)
dinnerMenu["豬排飯"] = new Dish("豬排飯",false,88)

const waitor = new Waiter([breakfastMenu,dinnerMenu]);
waitor.printAllMenu();